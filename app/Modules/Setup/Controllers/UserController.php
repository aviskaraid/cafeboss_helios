<?php

namespace Modules\Setup\Controllers;

use App\Controllers\BaseController;
use Modules\Setup\Models\UsersModel;
use Config\Services;

use function PHPSTORM_META\type;

class UserController extends BaseController
{   
    private $module = 'Setup'; // Module name

    public function index(){
        $data = [];
        $user = new UsersModel();
        $keyword = $this->request->getGet('keyword');
		$data = $user->getPaginated(10, $keyword);
        $data['title'] = "User Apps List";
        return hmvcView($this->module, 'user_list', $data);
    }

    public function create(){
        $data['title'] = "New User"; 
        $data['generate_code'] = becko_user_code(8,true);
        return hmvcView($this->module, 'user_create', $data);
    }
    public function generate_userCode(){
        $userCode = becko_user_code(8,true);
        $message = "successfully Generate User Code";
        $data['user_code'] = $userCode;
        return $this->respond($userCode);
    }
    public function upload_image(){
        $user = new UsersModel();
        $rulesImages = [
            'imageToUpload' => [  
                'label' => 'Image File',  
                'rules' => 'uploaded[imageToUpload]'  
                    . '|is_image[imageToUpload]'  
                    . '|mime_in[imageToUpload,image/jpg,image/jpeg,image/gif,image/png,image/webp]'  
                    . '|max_size[imageToUpload,2000]'  
            ],
        ];
        if (!$this->validate($rulesImages )) {
            return $this->fail($this->validator->getErrors());
        }else{
            $image = $this->request->getFile('imageToUpload');
            $postData = $this->request->getPost();
            $filename = $image->getRandomName();
            Services::image()
                ->withFile($image)
                ->fit( 480, 480,'center')
                ->save(ROOTPATH .'/public/uploads/'. $filename);
            $upda['picture'] = "/uploads/".$filename;
            $data['image'] = ROOTPATH .'/public/uploads/'. $filename;
            $data['message'] = "format Success";
            $data['user_id'] = $this->request->getPost('user_id');
            $user->update($this->request->getPost('user_id'),$upda);
            return json_response($data,200);
        }
            
    }
    public function create_process(){
        $user = new UsersModel();
        $post = $this->request->getJSON(true);
        $save = $user->save($post);
        if($save) {
            $message = "successfully Inserted";
            $data['redirect'] = "settings/users";
            return json_response($data,200,$message);
        } else {
            $data['errors'] = $user->errors();
            return json_response($data, 400);
        }
        
    }
            
}