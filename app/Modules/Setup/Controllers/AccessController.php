<?php

namespace Modules\Setup\Controllers;

use App\Controllers\BaseController;
use Modules\Setup\Models\AccessModel;
use Modules\Setup\Models\MainMenuModel;

class AccessController extends BaseController
{   
    private $module = 'Setup'; // Module name

    public function index(){
        $data = [];
        $access = new AccessModel();
        $keyword = $this->request->getGet('keyword');
		$data = $access->getPaginated(10, $keyword);
        //dd($data);
        return hmvcView($this->module, 'access_list', $data);
    }
    public function create(){
		$modules = new AccessModel();
        $getModules = $modules->getModule();
        $mainModule = new MainMenuModel();
        $getMain = $mainModule->getFind();
        $data['modules'] = $getModules; 
        $data['main_module']=$getMain;
        return hmvcView($this->module, 'access_create', $data);
    }
    public function edit($id){
		$access = new AccessModel();
         $getModules = $access->getModule();
        $where = ["id"=>$id];
        $getAccess = $access->getFind($where);
        $mainModule = new MainMenuModel();
        $getMain = $mainModule->getFind();
         $data['modules'] = $getModules; 
        $data['access'] = $getAccess[0]; 
        $data['main_module']=$getMain;
        return hmvcView($this->module, 'access_edit', $data);
    }
    public function create_process(){
         $rules = [
            'label_name'      	=> 'required|min_length[2]|max_length[100]',
            'parent_id'       => 'required'
        ];
        if ($this->validate($rules)) {
            $access = new AccessModel(); 
            $post = $this->request->getPost();
            $addInsert = [];
            if($post['parent_id']!="0" && strlen($post['modules'])==0){
               return redirect()->back()->withInput()->with('error', "Module not Found");
            }else{
                $parent_id      = $post['parent_id'];
                $main_module_id = $post['main_module_id'];
                if($parent_id=="0"){
                    $trimString = trim($post['label_name']);
                    $addInsert['module_name'] = strtolower(str_replace(" ","",$trimString));
                }
                if($parent_id!="0"){
                    $trimString = trim($post['label_name']);
                    $addInsert['function_name'] = strtolower(str_replace(" ","",$trimString));
                };
                $addInsert['label_name'] = trim($post['label_name']);
                $addInsert['url'] = strtolower(trim($post['url']));
                $addInsert['parent_id'] = (int)$parent_id;
                $addInsert['main_module_id'] = (int)$main_module_id;
                $addInsert['active'] = 1;
                $addSave = $access->insert($addInsert);
                if(!$addSave) {
			       return redirect()->back()->withInput()->with('errors', $access->errors());
                } else {
                    return redirect()->to(site_url('settings/accessmenu'))->with('success', 'Data Berhasil Disimpan');
                }
            }
        }else{
             return redirect()->back()->with('error', $this->validator->listErrors());
        }
    }

    public function changes($id = null){
         $rules = [
            'label_name'      => 'required|min_length[2]|max_length[100]',
            'parent_id'       => 'required'
        ];
        if ($this->validate($rules)) {
            $access = new AccessModel(); 
            $post = $this->request->getPost();
            $addChange = [];
            if($post['parent_id']!="0" && strlen($post['modules'])==0){
               return redirect()->back()->withInput()->with('error', "Module not Found");
            }else{
                $parent_id      = $post['parent_id'];
                $main_module_id = $post['main_module_id'];
                if($parent_id=="0"){
                    $trimString = trim($post['label_name']);
                    //$str = strtolower(preg_replace('/\s+/', '', $trimString));
                    $addChange['module_name'] = strtolower(str_replace(" ","",$trimString));
                }
                if($parent_id!="0"){
                    $trimString = trim($post['label_name']);
                    $addChange['function_name'] = strtolower(str_replace(" ","",$trimString));
                }
                $addChange['label_name'] = trim($post['label_name']);
                $addChange['url'] = strtolower(trim($post['url']));
                $addChange['parent_id'] = (int)$parent_id;
                $addChange['main_module_id'] = (int)$main_module_id;
                $addChange['active'] = 1;
                $addChange['icon_image'] = strtolower($post['icon_image']);
                $addSave = $access->update($id,$addChange);
                if(!$addSave) {
			       return redirect()->back()->withInput()->with('errors', $access->errors());
                } else {
                    return redirect()->to(site_url('settings/accessmenu'))->with('success', 'Data Berhasil Disimpan');
                }
            }
        }else{
             return redirect()->back()->with('error', $this->validator->listErrors());
        }
    }


}