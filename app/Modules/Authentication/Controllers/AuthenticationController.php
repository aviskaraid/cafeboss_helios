<?php

namespace Modules\Authentication\Controllers;

use App\Controllers\BaseController;
use Modules\Authentication\Models\AuthModel;
use Modules\Master\Models\UsersModel;

class AuthenticationController extends BaseController
{   
    private $module = 'Authentication'; // Module name

    public function login(){
        helper(['form']);
        $data = [
            'title' => 'Login',
            'message' => 'Please enter Your Account '
        ];
        return hmvcView($this->module, 'login', $data);
    }

    public function login_process(){
           if ($this->request->getMethod() === 'POST') {
                $post = $this->request->getJSON();
                $rules = config('Validation')->login; // Get rules from config
                if (!$this->validate($rules)) {
                   $data['errors'] =  $this->validator->getErrors();
                    return json_response($data,400,"error Validasi");
                }
                $auth = new AuthModel();
                $process = $auth->processLoginEmail($post);
                if(!$process['status']){
                    $message = $process['message'];
                    $data['success'] = $process['status'];
                    return json_response($data,200,$message);
                }else{
                    $user = new UsersModel();
                    $where = ['id'=>$process['data']['user']->id];
                    $getUser = $user->getFind($where)[0];
                    $getGroup = $auth->getAuthGroups($getUser->id);
                    $getUser->groups = $getGroup['data']['groups'];
                    $set = setUserLogin($getUser);
                    if($set){
                        setcookie('user_login_id', $getUser->id,0,"/");
                        $redirectUrl = session()->get('redirect_url'); // Get the stored URL
                        if ($redirectUrl) {
                            $data['success'] = $process['status'];
                            $message = $process['message'];
                            $data['redirect'] = $redirectUrl;
                            return json_response($data,200,$message);
                        } else {
                            $data['success'] = $process['status'];
                            $message = $process['message'];
                            return json_response($data,200,$message);
                        }
                    }else{
                        $session = session(); // Get the current session instance
                        $session->destroy(); // Destroy all session data
                        $message = "Failed Login";
                        $data['success'] = false;
                        $data['redirect'] = "authentication/login";
                        return json_response($data,200,$message);
                    }
                }              
           }else{
                 return error_response("Not Allowed Method",400);
           }
           
    }

    public function register(){
        $data = [
            'title' => 'Register',
            'message' => 'Please complete the registration form.'
        ];
        return hmvcView($this->module, 'register', $data);
    }

    public function logout(){
        $session = session(); // Get the current session instance
        $session->destroy(); // Destroy all session data
        setcookie("user_access", "", time() - 3600, "/");
        setcookie("user_login_id", "", time() - 3600, "/");
        setcookie("user_menu", "", time() - 3600, "/"); 
        return redirect()->to(base_url('authentication/login')); // Redirect to the login page or any other desired page
    }
}