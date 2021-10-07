<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Waskat extends Migration
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
			'noSurat'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'noRegistrasi'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
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
				'null'       	 => true,
			],
			'tempatLahir'          => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
				'null'       	 => true,
			],
			'tglLahir'          => [
				'type'           => 'DATE',
			],
			'pesawat'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'noPaspor'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'dokumen'       => [
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
		$this->forge->createTable('waskat');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('waskat');
	}
}
