<?php

if (!function_exists('hmvcView')) {
    function hmvcView(string $module, string $view, array $data = [], array $options = [])
    {
        $modulesPath = APPPATH . 'Modules/';
        $viewPath = "{$module}/Views/{$view}";
        $fullPath = $modulesPath . $viewPath . '.php';
        if (!file_exists($fullPath)) {
            throw new RuntimeException("HMVC view not found: {$fullPath}");
        }
        $adjustedViewPath = '../Modules/' . $viewPath;
        return view($adjustedViewPath, $data, $options);
    }
}

if (!function_exists('responseM')) {
    function responseM(bool $success, string $message, array $data = [])
    {
        $result = [];
        if($success){
            $result = ["status"=>true,"message"=>$message,"data"=>$data];
        }else{
            $result = ["status"=>false,"message"=>$message];
        }
        return $result;
        
    }
}

if (!function_exists('setUserLogin')) {
    function setUserLogin($data = null){
        $sessionUser = ["user_login"=>$data];
        session()->set($sessionUser);
        if(session()->get("user_login")){
            return true;
        }else{
            return false;
        }
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin(){
        $super = false;
        if(session()->get("user_login")){
            if(session()->get("user_login")->designation=="superadmin"){
                $super = true;
            }else{
                $super = false;
            }
        }else{
            $super = false;
        }
        return $super;
    }
}

if (!function_exists('isAdminApps')) {
    function isAdminApps(){
        $super = false;
        if(session()->get("user_login")){
            if(session()->get("user_login")->designation=="adminapps"){
                $super = true;
            }else{
                $super = false;
            }
        }else{
            $super = false;
        }
        return $super;
    }
}