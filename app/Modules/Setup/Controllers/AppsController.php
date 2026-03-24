<?php

namespace Modules\Setup\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use Modules\Setup\Models\AppsModel;

class AppsController extends BaseController
{   
    private $module = 'Setup'; // Module name

    public function setup(){
        $apps = new AppsModel();
        $where = ["id"=>1];
        $getApps = $apps->getFind($where)[0];
        $data['data'] = $getApps;
        $data['title'] = "Apps";
        $data['module'] = $this->module;
        return hmvcView($this->module, 'apps', $data);
    }

    public function save_process(){
        $rules = [
            'name'      	    => 'required|min_length[2]|max_length[30]',
            'description'       => 'required|min_length[2]|max_length[255]'
        ];
        $post = $this->request->getPost();
        $add = null;
        $img_thumbnails = '';
        $img_profile = '';
        if($_FILES['image_thumbnail']['size'] > 0){
            $rulesImages = [
                    'image_thumbnail' => [  
                        'label' => 'Image File',  
                        'rules' => 'uploaded[image_thumbnail]'  
                            . '|is_image[image_thumbnail]'  
                            . '|mime_in[image_thumbnail,image/jpg,image/jpeg,image/gif,image/png,image/webp]'  
                            . '|max_size[image_thumbnail,2048]'
                            . '|max_dims[image_thumbnail,1200,800]',
                    ],
                ];
            if ($this->validate($rulesImages)) {
                    $image = $this->request->getFile('image_thumbnail');
                    $filename = $image->getRandomName();
                    Services::image()
                        ->withFile($image)
                        ->fit( 400, 160)
                        ->save(ROOTPATH .'/public/uploads/'. $filename);
                    $img_thumbnails = "/uploads/".$filename;
                }else{
                    return redirect()->back()->with('error', $this->validator->listErrors());
                }
        }if($_FILES['image_profile']['size'] > 0){
            $rulesImages = [
                    'image_profile' => [  
                        'label' => 'Image File',  
                        'rules' => 'uploaded[image_profile]'  
                            . '|is_image[image_profile]'  
                            . '|mime_in[image_profile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'  
                            . '|max_size[image_profile,2048]'  
                            . '|max_dims[image_profile,1200,800]',  
                    ],
                ];
            if ($this->validate($rulesImages)) {
                    $image = $this->request->getFile('image_profile');
                    $filename = $image->getRandomName();
                    Services::image()
                        ->withFile($image)
                        ->resize(400, 400,true,'height')
                        ->save(ROOTPATH .'/public/uploads/'. $filename);
                    //$image->move(WRITEPATH . '/public/uploads');
                    $img_profile = "/uploads/".$filename;
                }else{
                    return redirect()->back()->with('error', $this->validator->listErrors());
                }
        }
        if ($this->validate($rules)) {
            $add['name']                = $post['name'];
            $add['description']         = $post['description'];
            $add['website']             = $post['website'];
            $add['url']                 = $post['url'];
            $add['access_api']          = $post['access_api'];
            $add['access_code']         = $post['access_code'];
            $add['access_expired']      = $post['access_expired'];
            $add['access_activate']     = $post['access_activate'];
            $add['access_email']        = $post['access_email'];
            $add['developed_by']        = $post['developed_by'];
            $add['made_by']             = $post['made_by'];
            $add['server_url']          = $post['server_url'];
            $add['made_year']           = $post['made_year'];
            if($_FILES['image_thumbnail']['size'] > 0){
                $add['img_thumbnails']      = $img_thumbnails;
            }
            if($_FILES['image_profile']['size'] > 0){
                $add['img_profile']      = $img_profile;
            }
            $apps = new AppsModel();
            $addApps = $apps->update(1,$add);
            if (!$addApps) {
                return redirect()->back()->withInput()->with('errors', $apps->errors());
            } else {
                 return redirect()->to(site_url('settings/apps'))->with('success', 'Data Berhasil Disimpan');
            }
        }else{
              return redirect()->back()->with('error', $this->validator->listErrors());
        }
    }
}