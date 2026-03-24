<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!session('user_login')) {
            session()->set('redirect_url', current_url()); 
			return redirect()->to(site_url('authentication/login'));
		}
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }

    public function PermitFilter(){
        $uri = new \CodeIgniter\HTTP\URI(current_url());
        $segment1 = $uri->getSegment(1);
        $segment2 = $uri->getSegment(2);
        $segment = $segment1;
        if ($segment2!=="") {
            $segment = $segment1;
        }else{
            $segment = $segment1;
        }
        $found = false;
        foreach (session()->get("access") as $string) {
            $parts = preg_split("/[-]/", $string); 
            if (str_contains($segment, $parts[0])) {
                $found = true;
                break; // Exit loop once found
            }
        }
        return $found;
    }
}