<?php

namespace Modules\Setup\Controllers;

use App\Controllers\BaseController;
use Modules\Setup\Models\MainMenuModel;

class MainMenuController extends BaseController
{   
    private $module = 'Setup'; // Module name

    public function index(){
        $mainMenu = new MainMenuModel();
        $keyword = $this->request->getGet('keyword');
		$data = $mainMenu->getPaginated(10, $keyword);
        return hmvcView($this->module, 'mainmenu_list', $data);
    }
    public function create(){
        $data['title'] = "Main Menu"; 
        return hmvcView($this->module, 'mainmenu_create', $data);
    }
    public function edit($id){
        $mainMenu = new MainMenuModel();
        $where = ["id"=>$id];
        $getMainMenu= $mainMenu->getFind($where);
        $countResult = $mainMenu->countAllResults();
        $getOrder = $mainMenu->getOrderNumber($countResult);
        $data['menu'] = $getMainMenu[0];
        $data['order_number'] = $getOrder;
        //dd($data);
        return hmvcView($this->module, 'mainmenu_edit', $data);
    }
    public function create_process(){
        $mainMenu = new MainMenuModel();
         $rules = [
            'name'      	=> 'required|min_length[2]|max_length[100]',
        ];
        if ($this->validate($rules)) {
                $post = $this->request->getPost();
                $addInsert['name'] = trim($post['name']);
                $addInsert['order_number'] = intval($post['order_number']);
                $addInsert['active'] = 1;
                $addSave = $mainMenu->insert($addInsert);
                if(!$addSave) {
			       return redirect()->back()->withInput()->with('errors', $mainMenu->errors());
                } else {
                    return redirect()->to(site_url('settings/mainmenu'))->with('success', 'Data Berhasil Disimpan');
                }
        }else{
             return redirect()->back()->with('error', $this->validator->listErrors());
        }
    }

    public function changes($id = null){
        $mainmenu         = new MainMenuModel(); // Instantiate your model
        $rules = [
            'name'      	=> 'required|min_length[2]|max_length[100]',
        ];
         if ($this->validate($rules)) {
            $post = $this->request->getPost();
            $addInsert['name'] = trim($post['name']);
            $addInsert['order_number'] = intval($post['order_number']);
            $addInsert['active'] = 1;
            $update = $mainmenu->update($id,$addInsert);
            if (!$update) {
                return redirect()->back()->withInput()->with('errors', $mainmenu->errors());
            } else {
                return redirect()->to(site_url('settings/mainmenu'))->with('success', 'Data Berhasil Disimpan');
            }
        }else {
            $data['validation'] = $this->validator;
            return redirect()->back()->with('error', $this->validator->listErrors());
		}
	}
}