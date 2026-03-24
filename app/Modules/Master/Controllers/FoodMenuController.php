<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use Modules\API\Models\AppsModel;
use Modules\Master\Models\FoodMenuCategoryModel;
use Modules\Master\Models\FoodMenuModel;
use Config\Services;
use Modules\Master\Models\FoodMenuIngredientModel;
use Modules\Master\Models\ItemsModel;
use Modules\Master\Models\WarehouseModel;

class FoodMenuController extends BaseController
{   
    private $module = 'Master'; // Module name

    public function index(){
       $units = new FoodMenuModel();
        $keyword = $this->request->getGet('keyword');
		$data = $units->getPaginated(10, $keyword);
        $data['title'] = "Food Menu List";
        return hmvcView($this->module, 'foodmenu_list', $data);
    }


    public function generate_foodMenuCode(){
        $itemsCode = becko_foodmenu_code(8,true);
        $message = "successfully Generate Food Menu Code";
        $data['items_code'] = $itemsCode;
        return $this->respond($itemsCode);
    }
    public function create(){
		$data['title'] = "Food Menu";
        $data['generate_code'] = becko_foodmenu_code(8,true); 
        return hmvcView($this->module, 'foodmenu_create', $data);
    }

    public function create_process(){
        $foodMenu = new FoodMenuModel();
        $post = $this->request->getPost();
        $post['active'] = 1;
        $message = "Successfully";
        $category = explode(",",$post['input_category']);
        $add_foodmenu =[
            "code"          =>$post['code'],
            "name"          =>$post['name'],
            "display_name"  =>$post['display_name'],
            "description"   =>$post['description'],
            "as_modifiers"  => isset($post['modifiers']) ? 1 : 0,
            "premade"       => isset($post['premade']) ? 1 : 0,
            "enable_stock"  => isset($post['enable_stock']) ? 1 : 0,
            "active"        => (int)$post['active'],
            "sell_price"    => floatval(str_replace(".", "", $post['sell_price'])),
            "alert_qty"     => (float)$post['alert_qty'],
        ];
        if($_FILES['imagefile']['size'] > 0){
                $rulesImages = [
                    'imagefile' => [  
                        'label' => 'Image File',  
                        'rules' => 'uploaded[imagefile]'  
                            . '|is_image[imagefile]'  
                            . '|mime_in[imagefile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'  
                            . '|max_size[imagefile,2000]'  
                            . '|max_dims[imagefile,1000,768]',  
                    ],
                ];
                if ($this->validate($rulesImages)) {
                    $image = $this->request->getFile('imagefile');
                    $filename = $image->getRandomName();
                    Services::image()
                        ->withFile($image)
                        ->fit( 480, 480,'center')
                        ->save(ROOTPATH .'/public/uploads/'. $filename);
                    //$image->move(WRITEPATH . '/public/uploads');
                    $add_foodmenu['picture'] = "/uploads/".$filename;
                }else{
                    $error = $this->validator->getErrors();
                    return error_response($error['imagefile'],400);
                }
                
            }
        $save = $foodMenu->save($add_foodmenu);
        if(!$save) {
            return error_response(json_encode($foodMenu->errors()),400);
        }
        $itemID = $foodMenu->getInsertID();
        $categoryID =[];
        foreach ($category as $item) {
            $set = [
                'foodmenu_id' => $itemID,
                'category_id' => $item
            ];
            array_push($categoryID,$set);
        }
        $foodMenu->insertFoodMenuCategoryMap($itemID,$categoryID);
        $data['food'] = $add_foodmenu;
        $data['redirect'] = "master/food_menu";
        return json_response($data,200,$message);
    }

    public function edit($id = null){
		$data['title'] = "Food Menu";
        $menu = new FoodMenuModel();
        $where = ['id'=>$id];
        $getMenu = $menu->getFind($where)[0];
        $data['title'] = "Edit Food Menu ".$getMenu->description;
        $data['foodmenu'] = $getMenu;
        $apis = new AppsModel();
        $getCat = $apis->getFoodMenuCategoryByFoodMenu($id);
        $data['cata'] = $getCat;
        //dd($data);
        return hmvcView($this->module, 'foodmenu_edit', $data);
    }

    public function changes($id = null){
        $foodMenu = new FoodMenuModel();
        $post = $this->request->getPost();
        $post['active'] = 1;
        $message = "Successfully";
        $category = explode(",",$post['input_category']);
        $edit_foodmenu =[
            "code"          =>$post['code'],
            "name"          =>$post['name'],
            "display_name"  =>$post['display_name'],
            "description"   =>$post['description'],
            "as_modifiers"  => isset($post['modifiers']) ? 1 : 0,
            "premade"       => isset($post['premade']) ? 1 : 0,
            "enable_stock"  => isset($post['enable_stock']) ? 1 : 0,
            "active"        => (int)$post['active'],
            "sell_price"    => floatval(str_replace(".", "", $post['sell_price'])),
            "alert_qty"     => (float)$post['alert_qty'],
        ];
        if($_FILES['imagefile']['size'] > 0){
                $rulesImages = [
                    'imagefile' => [  
                        'label' => 'Image File',  
                        'rules' => 'uploaded[imagefile]'  
                            . '|is_image[imagefile]'  
                            . '|mime_in[imagefile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'  
                            . '|max_size[imagefile,2000]'  
                            . '|max_dims[imagefile,1000,768]',  
                    ],
                ];
                if ($this->validate($rulesImages)) {
                    $image = $this->request->getFile('imagefile');
                    $filename = $image->getRandomName();
                    Services::image()
                        ->withFile($image)
                        ->fit( 480, 480,'center')
                        ->save(ROOTPATH .'/public/uploads/'. $filename);
                    //$image->move(WRITEPATH . '/public/uploads');
                    $edit_foodmenu['picture'] = "/uploads/".$filename;
                }else{
                    $error = $this->validator->getErrors();
                    return error_response($error['imagefile'],400);
                }
            }
        $save = $foodMenu->update($post['foodmenu_id'],$edit_foodmenu);
        if(!$save) {
            return error_response(json_encode($foodMenu->errors()),400);
        }
        $itemID = $post['foodmenu_id'];
        $categoryID =[];
        foreach ($category as $item) {
            $set = [
                'foodmenu_id' => $itemID,
                'category_id' => $item
            ];
            array_push($categoryID,$set);
        }
        $foodMenu->insertFoodMenuCategoryMap($itemID,$categoryID);
        $data['food'] = $edit_foodmenu;
        $data['redirect'] = "master/food_menu";
        $data['category'] = $category;
        return json_response($data,200,$message);
    }

    public function bom($id = null){
        $food = new FoodMenuModel();
        $where = ['id'=>$id];
        $getMenu = $food->getFind($where)[0];
        $data['title'] = "Bill Of Material ".$getMenu->description;
        $data['food'] = $getMenu;
        $bom = new FoodMenuIngredientModel();
        $where = ['foodmenu_id'=>$id];
        $getBom = $bom->getFind($where);
        if(count($getBom)>0){
             $data['bom_exist'] = $getBom;
        }
        //dd($data);
        return hmvcView($this->module, 'foodmenu_bom', $data);
    }
    public function bom_process(){
        $post = $this->request->getPost();  
        $jumlah = $post['qty'];
        $dataArray = [];
        $warehouseId = $post['input_warehouse'];
        foreach ($jumlah as $key => $value) {
             $getItem = new ItemsModel();
             $KeyWordItem = $key."_".$warehouseId;
             $itemBom = $getItem->getItemsDetailbyLocation($KeyWordItem);
             $itemBom->use_stock = $value;
             $insertBom['item_id'] = $itemBom->item_id;
             $insertBom['warehouse_id'] = $warehouseId;
             $insertBom['consumption'] = $value;
             $insertBom['cost'] = $itemBom->item_sell_price;
             $insertBom['total'] = floatval($value)*floatval($itemBom->item_sell_price);
             $insertBom['foodmenu_id'] = $post['foodmenu_id'];
             array_push($dataArray,$insertBom);
         }
        $bom = new FoodMenuIngredientModel();
        $bom->saveBom($dataArray);
        $message = "Successfully";
        $data['bom'] = $dataArray;
        $data['redirect'] = "master/food_menu";
        return json_response($data,200,$message);
    }
}