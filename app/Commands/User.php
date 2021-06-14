<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\UsersModel;

class User extends BaseCommand
{
    protected $group       = 'admin';
    protected $name        = 'admin:add';
    protected $description = 'Tambah Admin Baru.';

    public function run(array $params)
    {
        try {
            if(empty($params[0]) || empty($params[1])){
                throw new \Exception("Username dan Password Harus Diisi.");
            }
            $encrypter = \Config\Services::encrypter();
            $validation = \Config\Services::validation();
            $users = new UsersModel();
            $data = [
                'username' => $params[0],
                'password'    => $params[1],
                'conf_password'    => $params[1],
                'level'    => 'admin',
                'keterangan'    => 'admin siap',
            ];
            if (!$validation->run($data, 'register')) {
                throw new \Exception(implode(', ',$validation->getErrors()));
            }
            $chipper = base64_encode($encrypter->encrypt($data['password']));
            $data['password'] = $chipper;
            $users->insert($data);
            CLI::write(CLI::color('Sukses Menambahkan Admin', 'green'));
            CLI::write('Username: ' . CLI::color($data['username'], 'blue'));
            CLI::write('Password: ' . CLI::color($params[1], 'blue'));
            CLI::write('Level: ' . CLI::color('Admin', 'blue'));
        } catch (\Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'yellow'));
        }
    }
}
