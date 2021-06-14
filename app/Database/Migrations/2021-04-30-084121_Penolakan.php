<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penolakan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 100,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'users_id'          => [
				'type'           => 'INT',
				'constraint'     => 100,
				'unsigned'       => true
			],
			'tglSurat'          => [
				'type'           => 'DATE',
			],
			'tglKejadian'          => [
				'type'           => 'DATE',
			],
			'nama'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'kewarganegaraan'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'gender'       => [
				'type'           => 'ENUM',
				'constraint'     => ['Laki-laki', 'Perempuan'],
			],
			'tglLahir'          => [
				'type'           => 'DATE',
			],
			'noPaspor'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'penolakan'       => [
				'type'           => 'ENUM',
				'constraint'     => ['Denda', 'Non Denda'],
			],
			'dokumen'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'bapen'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'created_at' => [
				'type'           => 'DATETIME',
				'null'       	 => true,
			],
			'updated_at' => [
				'type'           => 'DATETIME',
				'null'       	 => true,
			]

		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('users_id','users','id');
		$this->forge->createTable('penolakan');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('penolakan');
	}
}
