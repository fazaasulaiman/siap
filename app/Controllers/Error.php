<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Error extends BaseController
{
    
    public function page(){
        echo view('errors/html/error_403.php');
    }
}
