<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function showError($id)
    {
        $error_msg = '';
        switch ($id){
            case 1:
                $error_msg = 'UNAUTHORIZED|Access denied';
                break;
            case 2:
                $error_msg = 'SESSION_EXPIRED|Please try again';
                break;
            case 3:
                $error_msg = 'INVALID_TOKEN|Access denied';
                break;
            case 4:
                $error_msg = 'UNAUTHENTICATED|กรุณาเข้าสู่ระบบอีกครั้ง';
                break;
        }
        return $error_msg;
    }
}
