<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UsersModel;

class UserSeeder extends Seeder
{
	public function run()
	{
		$encrypter = \Config\Services::encrypter();
		$users = new UsersModel();
		$data = [
			'username' => 'adminsiap',
			'password'    => 'pekalongan',
			'level'    => 'admin',
			'keterangan'    => 'admin siap',
		];

		$chipper = base64_encode($encrypter->encrypt($data['password']));
		$data['password'] = $chipper;
		$users->insert($data);
	}
}
