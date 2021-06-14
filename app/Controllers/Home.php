<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Home extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->form_validation = \Config\Services::validation();
    }
    public function index()
    {
        return view('dashboard');
    }
    public function login()
    {
        return view('login');
    }
    public function process()
    {
        $data = $this->request->getPost();
        if (!$this->form_validation->run($data, 'login')) {

            echo json_encode(array('status' => false, 'ket' => $this->form_validation->getErrors()));
            exit();
        }
        echo json_encode(array('status' => true));
        exit();
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
