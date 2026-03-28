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

    public function get_ItemLocationByItemsId(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getItemsLocation($keyword);
        return $this->response->setJSON($data);
    }

    public function get_ItemByLocation(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getItemsbyLocation($keyword);
        return $this->response->setJSON($data);
    }

    public function get_ItemDetail(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getItemsDetailbyLocation($keyword);
        return $this->response->setJSON($data);
    }

    public function get_ItemIngredient(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getItemsIngredients($keyword);
        return $this->response->setJSON($data);
    }

    public function get_ItemPrice(){
        $keyword = $this->request->getGet('keyword');
        $groups = new AppsModel();
        $data = $groups->getItemsPrice($keyword);
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

    public function getFoodMenuByStore(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getFoodMenu($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getDepartment(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getDepartment($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getSupplier(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getSupplier($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getSupplierByItemsId(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getSupplierbyItem($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getStore(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getStore($keyword);
        return $this->response->setJSON($getCat);
    }


    public function getPosTableArea(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getPosTableArea($keyword);
        return $this->response->setJSON($getCat);
    }

    public function getPosTable(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getPosTable($keyword);
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

    public function getCustomer(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getCustomer($keyword);
        return $this->response->setJSON($getCat);
    }

    public function get_BomFoodMenu(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getBomFoodMenu($keyword);
        return $this->response->setJSON($getCat);
    }

    public function get_CheckParStock(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->check_parstock($keyword);
        return $this->response->setJSON($getCat);
    }

    public function get_StockRequestHeader(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getStockRequestHeader($keyword);
        return $this->response->setJSON($getCat);
    }

    public function get_StockRequestLines(){
         $keyword = $this->request->getGet('keyword');
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getStockRequest($keyword);
        if($this->request->getGet('supplier')!==null){
            $supplier = $this->request->getGet('supplier');
            if($supplier === 'null'){
                $selected = $this->request->getGet('selected');
                if($selected === 'null'){
                    $getCat = $apis->getStockRequest($keyword,null,null);
                }else{
                    $getCat = $apis->getStockRequest($keyword,null, $selected);
                }
            }else{
                $selected = $this->request->getGet('selected');
                if($selected === 'null'){
                    $getCat = $apis->getStockRequest($keyword,$supplier,null);
                }else{
                    $getCat = $apis->getStockRequest($keyword,$supplier,$selected); 
                }
            }
        }
        return $this->response->setJSON($getCat);
    }

    public function get_TaktikalBySupplier(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getTaktikalBySupplier($keyword);
        return $this->response->setJSON($getCat);
    }

    public function get_TaktikalById(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getTaktikalById($keyword);
        return $this->response->setJSON($getCat);
    }

    public function get_PurchaseRequestHeader(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getPurchaseRequestHeader($keyword);
        return $this->response->setJSON($getCat);
    }

    public function get_PurchaseRequestLines(){
       $keyword = $this->request->getGet('keyword');
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getPR = $apis->getPurchaseRequest($keyword);
        if($this->request->getGet('supplier')!==null){
            $supplier = $this->request->getGet('supplier');
            if($supplier === 'null'){
                $selected = $this->request->getGet('selected');
                if($selected === 'null'){
                    $getPR = $apis->getPurchaseRequest($keyword,null,null);
                }else{
                    $getPR = $apis->getPurchaseRequest($keyword,null, $selected);
                }
            }else{
                $selected = $this->request->getGet('selected');
                if($selected === 'null'){
                    $getPR = $apis->getPurchaseRequest($keyword,$supplier,null);
                }else{
                    $getPR = $apis->getPurchaseRequest($keyword,$supplier,$selected); 
                }
            }
        }
        return $this->response->setJSON($getPR);
    }

    public function get_PurchaseOrderHeader(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getCat = $apis->getPurchaseOrderHeader($keyword);
        return $this->response->setJSON($getCat);
    }

    public function get_PurchaseOrderLines(){
       $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $getPR = $apis->getPurchaseOrder($keyword);
        if($this->request->getGet('warehouse')!==null){
            $warehouse = $this->request->getGet('warehouse');
            if($warehouse === 'null'){
                $selected = $this->request->getGet('selected');
                if($selected === 'null'){
                    $getPR = $apis->getPurchaseOrder($keyword,null,null);
                }else{
                    $getPR = $apis->getPurchaseOrder($keyword,null, $selected);
                }
            }else{
                $selected = $this->request->getGet('selected');
                if($selected === 'null'){
                    $getPR = $apis->getPurchaseOrder($keyword,$warehouse,null);
                }else{
                    $getPR = $apis->getPurchaseOrder($keyword,$warehouse,$selected); 
                }
            }
        }
        return $this->response->setJSON($getPR);
    }

    public function post_updatePendingSR(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updatePending_SR($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_updateApproveSR(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updateApprove_SR($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_updateDeclineSR(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updateDecline_SR($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_updatePendingPR(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updatePending_PR($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_updateApprovePR(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updateApprove_PR($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_updateDeclinePR(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updateDecline_PR($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_updatePendingPO(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updatePending_PO($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_updateApprovePO(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updateApprove_PO($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_updateDeclinePO(){
        $keyword = $this->request->getJSON(true);
        $apis = new AppsModel();
        $res = $apis->post_updateDecline_PO($keyword['id']);
        return $this->response->setJSON($res);
    }

    public function post_removePRItem(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $res = $apis->post_remove_item_PR($keyword);
        return $this->response->setJSON($res);
    }

    public function post_removePOItem(){
        $keyword = $this->request->getGet('keyword');
        $apis = new AppsModel();
        $res = $apis->post_remove_item_PO($keyword);
        return $this->response->setJSON($res);
    }

}