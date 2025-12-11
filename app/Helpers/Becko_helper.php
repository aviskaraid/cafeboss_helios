<?php

if (!function_exists('getApps')) {
    function getApps() {

        // QUERY BUILDER
        $db = \Config\Database::connect();
        $builder = $db->table('apps');
        $builder->where('id', 1);
        $query = $builder->get();
        return $query->getRow();
    }
}

if (!function_exists('becko_user_code')) {
    function becko_user_code(int $length = 8, bool $capitalize = false){
        $db = \Config\Database::connect();
        $userCode = "";
        for ($i=0; $i <20 ; $i++) { 
            $userCode = generateRandomString($length,$capitalize);
            $builder = $db->table('users');
            $builder->where('code', $userCode);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $userCode;
    }
}

if (!function_exists('becko_department_code')) {
    function becko_department_code(int $length = 8, bool $capitalize = false){
        $db = \Config\Database::connect();
        $userCode = "";
        for ($i=0; $i <20 ; $i++) { 
            $userCode = generateRandomString($length,$capitalize);
            $builder = $db->table('departments');
            $builder->where('code', $userCode);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $userCode;
    }
}

if (!function_exists('becko_warehouse_code')) {
    function becko_warehouse_code(int $length = 8, bool $capitalize = false){
        $db = \Config\Database::connect();
        $userCode = "";
        for ($i=0; $i <20 ; $i++) { 
            $userCode = generateRandomString($length,$capitalize);
            $builder = $db->table('warehouse');
            $builder->where('code', $userCode);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $userCode;
    }
}

if (!function_exists('becko_employeegrouop_code')) {
    function becko_employeegrouop_code(int $length = 8, bool $capitalize = false){
        $db = \Config\Database::connect();
        $userCode = "";
        for ($i=0; $i <20 ; $i++) { 
            $userCode = generateRandomString($length,$capitalize);
            $builder = $db->table('employee_groups');
            $builder->where('code', $userCode);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $userCode;
    }
}

if (!function_exists('becko_employee_code')) {
    function becko_employee_code(int $length = 8, bool $capitalize = false){
        $db = \Config\Database::connect();
        $userCode = "";
        for ($i=0; $i <20 ; $i++) { 
            $userCode = generateRandomString($length,$capitalize);
            $builder = $db->table('employees');
            $builder->where('code', $userCode);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $userCode;
    }
}

if (!function_exists('becko_rnd_code')) {
    function becko_rnd_code(int $length = 8, bool $capitalize = false){
        $db = \Config\Database::connect();
        $userCode = "";
        for ($i=0; $i <20 ; $i++) { 
            $userCode = generateRandomString($length,$capitalize);
            $builder = $db->table('rnd');
            $builder->where('code', $userCode);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $userCode;
    }
}

if (!function_exists('becko_stores_code')) {
    function becko_stores_code(int $length = 8, bool $capitalize = false){
        $db = \Config\Database::connect();
        $userCode = "";
        for ($i=0; $i <20 ; $i++) { 
            $userCode = generateRandomString($length,$capitalize);
            $builder = $db->table('stores');
            $builder->where('code', $userCode);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $userCode;
    }
}

if (!function_exists('becko_activation_code')) {
    function becko_activation_code(int $length = 10, bool $capitalize = false){
        $db = \Config\Database::connect();
        $activationNumber = "";
        for ($i=0; $i <20 ; $i++) { 
            $activationNumber = generateRandomString($length,$capitalize);
            $builder = $db->table('apps');
            $builder->where('activation_code', $activationNumber);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $activationNumber;
    }
}

if (!function_exists('becko_items_code')) {
    function becko_items_code(int $length = 10, bool $capitalize = false){
        $db = \Config\Database::connect();
        $codeNumber = "";
        for ($i=0; $i <20 ; $i++) { 
            $codeNumber = generateRandomString($length,$capitalize);
            $builder = $db->table('items');
            $builder->where('code', $codeNumber);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $codeNumber;
    }
}

if (!function_exists('becko_foodmenu_code')) {
    function becko_foodmenu_code(int $length = 10, bool $capitalize = false){
        $db = \Config\Database::connect();
        $codeNumber = "";
        for ($i=0; $i <20 ; $i++) { 
            $codeNumber = generateRandomString($length,$capitalize);
            $builder = $db->table('foodmenu');
            $builder->where('code', $codeNumber);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $codeNumber;
    }
}

if (!function_exists('becko_code')) {
    function becko_code(int $length = 10, bool $capitalize = false){
        $db = \Config\Database::connect();
        $code = "";
        for ($i=0; $i <20 ; $i++) { 
            $code = generateRandomString($length,$capitalize);
            $builder = $db->table('apps');
            $builder->where('code', $code);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $code;
    }
}

if (!function_exists('becko_business_code')) {
    function becko_business_code(int $length = 10, bool $capitalize = false){
        $db = \Config\Database::connect();
        $code = "";
        for ($i=0; $i <20 ; $i++) { 
            $code = generateRandomString($length,$capitalize);
            $builder = $db->table('business');
            $builder->where('code', $code);
            if($builder->countAllResults()>0){
                continue;
            }else{
                break;
            }
        }
        return $code;
    }
}

function generateRandomString($length = 10, bool $Capitalize = false) {
    $source = "";
    $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $number = '012345678901234567890123456789';
    $charsLength = strlen($char);
    $numbersLength = strlen($number);
    $randomStringChar = '';
    $randomStringNumber = '';
    $result = "";
    for ($i = 0; $i < 14; $i++) {
        $randomStringChar .= $char[mt_rand(0, $charsLength - 1)];
    }
        for ($i = 0; $i < 14; $i++) {
        $randomStringNumber .= $number[mt_rand(0, $numbersLength - 1)];
    }
    switch ($Capitalize) {
        case true:
            $source =   $randomStringNumber.strtoupper($randomStringChar);
            break;
        default:
            $source =   $randomStringNumber.ucwords($randomStringChar);
            break;
    }
    $resultLength = strlen($source);
    for ($i = 0; $i < $length; $i++) {
        $result .= $source[mt_rand(0, $resultLength - 1)];
    }
    return $result;
}

if (!function_exists('content_wrap')){
    function content_wrap($text,int $length){
    $limit = $length;
    $trimmed_text = mb_strimwidth($text, 0, $limit, "...");
    return $trimmed_text; // Output: This is a long piece of te...
    }
}

if(!function_exists('call_api')){
    function call_api(string $url= "",string $method=""){
        $client = service('curlrequest');

        try {
            $response = $client->get($url);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();

            if ($statusCode === 200) {
                $data = json_decode($body);
                return $data;
            } else {
                return;
//                echo "API Call Failed with status code: " . $statusCode;
            }

        } catch (\Exception $e) {
            return;
  //          echo "Error making API call: " . $e->getMessage();
        }
    }
}

if (!function_exists('call_external_api')) {
        function call_external_api(string $url, array $data = [], string $method = 'GET')
        {
            $client = \Config\Services::curlrequest(); // Or \Config\Services::httpclient() for a more modern approach

            try {
                $response = null;
                if ($method === 'GET') {
                    $response = $client->get($url, ['query' => $data]);
                } elseif ($method === 'POST') {
                    $response = $client->post($url, ['json' => $data]); // Or 'form_params' for form data
                }
                // Add other methods like PUT, DELETE as needed

                if ($response && $response->getStatusCode() === 200) {
                    return json_decode($response->getBody());
                } else {
                    // Handle error or log the response
                    return null;
                }
            } catch (\Exception $e) {
                // Handle exceptions (e.g., network issues)
                log_message('error', 'API call failed: ' . $e->getMessage());
                return null;
            }
        }
    }


if (!function_exists('live_user_menu')) {
    function live_user_menu(){
        $menus = [];
        if(get_cookie("user_menu")){
            $menus = json_decode(get_cookie("user_menu"),true);
        }else{
            $menus=null;
        }
        return $menus;
    }
}


// BUSINESS

if (!function_exists('business_detail')) {
    function business_detail() {

        // QUERY BUILDER
        $db = \Config\Database::connect();
        $builder = $db->table('business');
        $builder->where('id', 1);
        $query = $builder->get();
        return $query->getRow();
    }
}

if (!function_exists('setup_business')){
    function setup_business($col = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('business_setup');
        if($col != ''){
            $builder->select($col);
        }
        $builder->where('id', 1);
        $query = $builder->get();
        return $query->getRow();
    }
}

if (!function_exists('apps')){
    function apps($col = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('apps');
        if($col != ''){
            $builder->select($col);
        }
        $builder->where('id', 1);
        $query = $builder->get();
        return $query->getRow();
    }
}

if (!function_exists('get_user')) {
    function get_user(int $id) {
        // QUERY BUILDER
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', $id);
        $query = $builder->get();
        return $query->getRow();
    }
}