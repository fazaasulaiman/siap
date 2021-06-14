<?php

namespace App\Validation;

use App\Models\UsersModel;
use App\Models\PenolakanModel;

class CustomRules
{

    // Rule is to validate mobile number digits
    public function isRegister(string $str, string $fields, array $data)
    {
        $users = new UsersModel();
        $dataUser = $users->where([
            'username' => $data['username'],
        ])->first();
        if ($dataUser) {
            return true;
        }
        return false;
    }
    public function isLogin(string $str, string $fields, array $data)
    {
        $users = new UsersModel();
        $encrypter = \Config\Services::encrypter();
        $dataUser = $users->where([
            'username' => $data['username'],
        ])->first();
        if (!$dataUser) {
            return false;
        }
        $dataUser->password = $encrypter->decrypt(base64_decode($dataUser->password));
        if ($data['password'] == $dataUser->password) {
            session()->set([
                'id' => $dataUser->id,
                'username' => $dataUser->username,
                'keterangan' => $dataUser->keterangan,
                'level' => $dataUser->level,
                'logged_in' => TRUE
            ]);
            return true;
        }
        return false;
    }
    public function isAdmin(string $str, string $fields, array $data)
    {
        if(session()->get('level') == 'admin'){
            return true;
        }
        return false;
    }
    public function isSeksi(string $str, string $fields, array $data)
    {
        if(session()->get('level') == 'seksi'){
            return true;
        }
        return false;
    }
    public function isYourData(string $str, string $fields, array $data)
    {
        $penolakan = new PenolakanModel();
        $dataPenolakan = $penolakan->where([
            'id' => $data['id'],
        ])->first();
        //session()->get('id')
        if( session()->get('id') == $dataPenolakan->users_id){
            return true;
        }
        return false;
    }
    
}
