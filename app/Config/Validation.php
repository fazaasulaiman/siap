<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use App\Validation\CustomRules;
class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
		CustomRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $login = [
		'username' => [
			'rules' => 'required|min_length[4]|max_length[20]|isRegister[username]',
			'errors' => [
				'required' => '{field} Harus diisi',
				'min_length' => '{field} Minimal 4 Karakter',
				'max_length' => '{field} Maksimal 20 Karakter',
				'isRegister' => '{field} Tidak Ditemukan'
			]
		],
		'password' => [
			'rules' => 'required|min_length[4]|max_length[50]|isLogin[password]',
			'errors' => [
				'required' => '{field} Harus diisi',
				'min_length' => '{field} Minimal 4 Karakter',
				'max_length' => '{field} Maksimal 50 Karakter',
				'isLogin' => 'Kombinasi Username & Password Salah'
			]
		],

	];
	public $register = [
		'username' => [
			'rules' => 'required|min_length[4]|max_length[20]|is_unique[users.username]',
			'errors' => [
				'required' => '{field} Harus diisi',
				'min_length' => '{field} Minimal 4 Karakter',
				'max_length' => '{field} Maksimal 20 Karakter',
				'is_unique' => 'Username sudah digunakan sebelumnya'
			]
		],
		'password' => [
			'rules' => 'required|min_length[4]|max_length[50]',
			'errors' => [
				'required' => '{field} Harus diisi',
				'min_length' => '{field} Minimal 4 Karakter',
				'max_length' => '{field} Maksimal 50 Karakter',
			]
		],
		'conf_password' => [
			'rules' => 'required|matches[password]',
			'errors' => [
				'required' => 'Konfirmasi Password Harus diisi',
				'matches' => 'Konfirmasi Password tidak sesuai dengan password',
			]
		],
		'keterangan' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'Harus Dipilih',
			]
		],
	];
	public $bapen = [
		'bapen'    => [
			'rules'  => 'uploaded[bapen]|max_size[bapen,5000]|ext_in[bapen,pdf]',
			'errors' => [
				'uploaded' => 'Dokumen Bapen Harus Dilampirkan.',
				'max_size' => 'Maksimal size 5 MB',
				'ext_in' => 'File Harus Berupa PDF'
			]
		],
		'id' => [
			'rules' => 'isAdmin[id]',
			'errors' => [
				'isAdmin' => 'Akses Ditolak'
			]
		]
	];
	public $removePenolakan = [
		
		'id' => [
			'rules' => 'isSeksi[id]|isYourData[id]',
			'errors' => [
				'isSeksi' => 'Hanya untuk user seksi',
				'isYourData' => 'Hanya Untuk User Seksi Yang berwenang',
			]
		]
	];
	public $penolakan = [
		'tglSurat' => [
			'rules'  => 'required|valid_date[d/m/Y]',
			'errors' => [
				'required' => 'Tanggal Tidak Boleh Kosong.',
				'valid_date' => 'Format Tanggal Surat Harus dd/mm/yyyy'
			]
		],
		'tglKejadian'    => [
			'rules'  => 'required|valid_date[d/m/Y]',
			'errors' => [
				'required' => 'Tanggal Kejadian Tidak Boleh Kosong.',
				'valid_date' => 'Format Tanggal Kejadian Harus dd/mm/yyyy'
			]
		],
		'nama'    => [
			'rules'  => 'required|max_length[100]',
			'errors' => [
				'required' => 'Nama Tidak Boleh Kosong.',
				'max_length' => 'Maksimal 100 karakter'
			]
		],
		'kewarganegaraan'    => [
			'rules'  => 'required',
			'errors' => [
				'required' => 'Kewarganegaraan Tidak Boleh Kosong.'
			]
		],
		'gender'    => [
			'rules'  => 'required|in_list[Laki-Laki,Perempuan]',
			'errors' => [
				'required' => 'Jenis Kelamin Tidak Boleh Kosong.',
				'in_list' => 'Silahkan Pilih Jenis Kelamin Yang Tersedia'
			]
		],
		'tglLahir'    => [
			'rules'  => 'required|valid_date[d/m/Y]',
			'errors' => [
				'required' => 'Tanggal Lahir Tidak Boleh Kosong.',
				'valid_date' => 'Format Tanggal Lahir Harus dd/mm/yyyy'
			]
		],
		'noPaspor'    => [
			'rules'  => 'required|max_length[100]|min_length[5]',
			'errors' => [
				'required' => 'No Paspor Tidak Boleh Kosong.',
				'max_length' => 'Maksimal 100 karakter',
				'min_length' => 'Minimal 5 karakter'
			]
		],
		'penolakan'    => [
			'rules'  => 'required|in_list[Denda,Non Denda]',
			'errors' => [
				'required' => 'Jenis Penolakan Tidak Boleh Kosong.',
				'in_list' => 'Silahkan  Pilih Jenis Penolakan Yang Tersedia'
			]
		],
		'dokumen'    => [
			'rules'  => 'uploaded[dokumen]|max_size[dokumen,5000]|ext_in[dokumen,pdf]',
			'errors' => [
				'uploaded' => 'Dokumen Harus Dilampirkan.',
				'max_size' => 'Maksimal size 5 MB',
				'ext_in' => 'File Harus Berupa PDF'
			]
		],
	];
}
