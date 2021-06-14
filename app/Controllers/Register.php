<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Irsyadulibad\DataTables\DataTables;

class Register extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->form_validation = \Config\Services::validation();
    }
    public function index()
    {
        return view('user/seksi_register');
    }
    public function pimpinan()
    {
        return view('user/pimpinan_register');
    }
    public function datatable()
    {
        return DataTables::use('users')
            ->select('id,username, keterangan')
            ->where(['level' => 'seksi'])
            ->addColumn('aksi', function ($query) {
                return '<div class="btn-group"><a class="btn btn-light dropdown-toggle btn-sm" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <span class="caret"></span></a><ul role="menu" class="dropdown-menu pull-right"><li role="presentation"><a role="menuitem" tabindex="-1"  onclick="edit(' . "'" . $query->id . "'" . ',' . "'" . $query->username . "'" . ')"  data-toggle="modal" href="#edit" title="Ubah"><i class="fa fa-edit"></i> Ubah</a></li><li role="presentation"><a role="menuitem" data-toggle="modal" tabindex="-1"  onclick="hapus(' . "'" . $query->id . "'" . ',' . "'" . $query->username . "'" . ')" title="Hapus"><i class="fa fa-times"></i> Hapus</a></li></ul></div>';
            })
            ->hideColumns(['id'])
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function tablePimpinan()
    {
        return DataTables::use('users')
            ->select('id,username, keterangan')
            ->where(['level' => 'lainnya'])
            ->addColumn('aksi', function ($query) {
                return '<div class="btn-group"><a class="btn btn-light dropdown-toggle btn-sm" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <span class="caret"></span></a><ul role="menu" class="dropdown-menu pull-right"><li role="presentation"><a role="menuitem" tabindex="-1"  onclick="edit(' . "'" . $query->id . "'" . ',' . "'" . $query->username . "'" . ')"  data-toggle="modal" href="#edit" title="Ubah"><i class="fa fa-edit"></i> Ubah</a></li><li role="presentation"><a role="menuitem" data-toggle="modal" tabindex="-1"  onclick="hapus(' . "'" . $query->id . "'" . ',' . "'" . $query->username . "'" . ')" title="Hapus"><i class="fa fa-times"></i> Hapus</a></li></ul></div>';
            })
            ->hideColumns(['id'])
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function process($type)
    {
        // if($type == 'seksi'){
        //     $message = 'Seksi pemeriksaan';
        // }
        // if($type == 'pimpinan'){
        //     $message = 'Keterangan';
        // }
        $data = $this->request->getPost();
        if (!$this->form_validation->run($data, 'register')) {

            echo json_encode(array('status' => false, 'ket' => $this->form_validation->getErrors()));
            exit();
        }

        $encrypter = \Config\Services::encrypter();
        $users = new UsersModel();
        $chipper = base64_encode($encrypter->encrypt($this->request->getVar('password')));
        $data['password'] = $chipper;
        $users->insert($data);
        echo json_encode(array("status" => TRUE));
        exit();
    }
    public function remove()
    {
        $id = $this->request->getVar('id');
        $users = new UsersModel();
        if ($users->find($id)) {
            $users->delete($id);
            echo json_encode(array("status" => TRUE));
            exit();
        } else {
            echo json_encode(array("status" => false));
            exit();
        }
    }
    public function edit($id)
    {
        $user = new UsersModel();
        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getPost();
            if (!$this->form_validation->run($data, 'register')) {
                echo json_encode(array("status" => false, 'ket' => $this->form_validation->getErrors()));
                exit();
            }
            $encrypter = \Config\Services::encrypter();
            $chipper = base64_encode($encrypter->encrypt($this->request->getVar('password')));
            $data['password'] = $chipper;
            $user->update($id, $data);
            echo json_encode(array("status" => true));
            exit();
        }
        $encrypter = \Config\Services::encrypter();
        $data['user'] = $user->select('id,username,password,keterangan')->where('id', $id)->first();
        if (!empty($data['user'])) {
            $chipper = base64_decode($data['user']->password);
            $data['user']->password = $encrypter->decrypt($chipper);
            echo json_encode(array("status" => true, "data" => $data['user']));
            exit();
        }
        echo json_encode(array('status' => false));
        exit();
    }
}
