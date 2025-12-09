<?php

namespace Modules\API\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use Modules\API\Models\AppsModel;
use Modules\Master\Models\ItemCategoryModel;
use Modules\Setup\Models\UserGroupsModel;

class ApiAppsController extends BaseController{   
    private $module = 'API'; // Module name

    public function index(){
        $data = ["index"=>1];
        return $this->response->setJSON($data);
    }
    public function get_access_user_menu($id = null){
        $apps = new AppsModel();
        $getMenu = $apps->getAccessUserMenu($id);
        $data = $getMenu;
        return $this->response->setJSON($data);
    }

    public function get_user_groups(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getGroups($keyword);
        return $this->response->setJSON($data);
    }

    public function get_ItemCategory(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getItemCategory($keyword);
        return $this->response->setJSON($data);
    }

    public function get_ItemUnits(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getItemsUnits($keyword);
        return $this->response->setJSON($data);
    }

    public function get_ItemIngredient(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getItemsIngredients($keyword);
        return $this->response->setJSON($data);
    }

    public function get_Warehouse(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getWarehouse($keyword);
        return $this->response->setJSON($data);
    }

    public function get_itemUnitsByItemId(){
        $keyword = $this->request->getGet('id');
        $groups = new AppsModel();
        $data = $groups->getItemUnitsbyItemId($keyword);
        return $this->response->setJSON($data);
    }

    public function get_itemIngredientByItemId(){
        $keyword = $this->request->getGet('id');
        $groups = new AppsModel();
        $data = $groups->getItemIngredientbyItemId($keyword);
        return $this->response->setJSON($data);
    }

    public function get_foodmenu_category(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getFoodMenuCategory($keyword);
        return $this->response->setJSON($data);
    }

    public function getFoodMenuCategoryByFoodMenu(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getFoodMenuCategoryByFoodMenu($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getFoodMenuCategoryByStore(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getFoodMenuCategorybyStore($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getDepartment(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getDepartment($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getStore(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getStore($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getEmployeeGroup(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getEmployeeGroup($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getEmployee(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getEmployee($keyword);
        return $this->response->setJSON($getCat);
    }

}