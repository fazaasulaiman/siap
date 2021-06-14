<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\UsersModel;

class UserChange extends BaseCommand
{
    protected $group       = 'admin';
    protected $name        = 'admin:edit';
    protected $description = 'Ubah Password Admin.';

    public function run(array $params)
    {
        try {
            if (empty($params[0]) || empty($params[1])) {
                throw new \Exception("Username dan Password Harus Diisi.");
            }
            $encrypter = \Config\Services::encrypter();
            
            $change = [
                'username' => $params[0],
                'password'    => $params[1],
            ];
            $chipper = base64_encode($encrypter->encrypt($params[1]));
            $change['password'] = $chipper;
            $users = new UsersModel();
            $users->update($change, ['username' => $params[0]]);
            
            CLI::write(CLI::color('Sukses Merubah Password', 'green'));
            CLI::write('Username: ' . CLI::color($change['username'], 'blue'));
            CLI::write('Password: ' . CLI::color($params[1], 'blue'));
            CLI::write('Level: ' . CLI::color('Admin', 'blue'));
        } catch (\Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'yellow'));
        }
    }
}
