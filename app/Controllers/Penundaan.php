<?php

namespace App\Controllers;

use App\Models\penundaanModel;
use Irsyadulibad\DataTables\DataTables;

class Penundaan extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->form_validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        return view('penundaan/arsip');
    }
    public function input()
    {
        return view('penundaan/input');
    }
    public function arsip()
    {
        return view('penundaan/arsip');
    }
    public function arsipJson()
    {
        $dataTable = DataTables::use('penundaan')
            ->select('users.username,penundaan.id,penundaan.nama,penundaan.kewarganegaraan,penundaan.gender,penundaan.noSurat,penundaan.noPaspor,penundaan.pesawat,penundaan.dokumen,penundaan.tglKejadian,penundaan.tglSurat')
            ->join('users', 'users.id = penundaan.users_id', 'INNER JOIN')
            ->addColumn('dokumen', function ($query) {
                return '<a href="../upload/penundaan/' . $query->dokumen . '?' . time() . '" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
            })
            ->addColumn('seksi', function ($query) {
                return ucfirst($query->username);
            })
            ->addColumn('tglSurat', function ($query) {
                return tgl_indo($query->tglSurat);
            });
        if($this->session->get('level') == 'seksi'){
            $dataTable->addColumn('aksi', function ($query) {
               if ($this->session->get('level') == 'seksi' && $this->session->get('username') == $query->username) {
                    $html = '<div class="btn-group dropleft">
                        <button type="button" class="btn btn-secondary fa fa-cog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu">
                        <button class="dropdown-item" type="button" onclick="hapus(' . "'" . $query->id . "'" . ',' . "'" . $query->nama . "'" . ')">Hapus</button>
                        </div>
                    </div>';
                }else{
                    $html = '&nbsp;';
                }
                return $html;
            });
        }
        if ($this->request->getPost('customFilter') == 'true') {

            parse_str($this->request->getPost('cari'), $data);
            unset($data["csrf_test_name"]);
            $filter = array_filter($data);
            if (!empty($filter['tglSurat'])) {
                $filter['tglSurat'] = date("Y-m-d", strtotime($filter['tglSurat']));
            }
            if (!empty($filter['tglKejadian'])) {
                $filter['tglKejadian'] = date("Y-m-d", strtotime($filter['tglKejadian']));
            }
            $dataTable->like($filter);
        }
        return $dataTable
            ->hideColumns(['id'])
            ->rawColumns(['aksi', 'dokumen', 'bapen'])
            ->make(true);
    }
    public function process()
    {
        $dokumen = $this->request->getFile('dokumen');
        $data = $this->request->getPost();
        $data['dokumen'] = $dokumen;
        if (!$this->form_validation->run($data, 'penundaan')) {

            echo json_encode(array('status' => false, 'text' => $this->form_validation->getErrors()));
            exit();
        }
        $data['tglSurat'] = formatdate($data['tglSurat']);
        $data['tglKejadian'] = formatdate($data['tglKejadian']);
        $data['tglLahir'] = formatdate($data['tglLahir']);
        $data['users_id'] = $this->session->get('id');
        $penundaan = new PenundaanModel();
        $dokumen->move(ROOTPATH . 'public/upload/penundaan', preg_replace('/\s+/', '_', $data['nama']) . '(' . $data['noSurat'] . ').' . $dokumen->guessExtension(),true);
        $data['dokumen'] = $dokumen->getName();
        $penundaan->insert($data);
        echo json_encode(array('status' => true));
        exit();
    }
    public function remove()
    {
        $data = $this->request->getPost();
        if (!$this->form_validation->run($data, 'removePenundaan')) {

            echo json_encode(array('status' => false, 'text' => $this->form_validation->getErrors()));
            exit();
        }
        $id = $this->request->getVar('id');
        $penundaan = new penundaanModel();
        if ($penundaan->find($id)) {
            $dokumen = $penundaan->find($id)->dokumen;
            $penundaan->delete($id);
            echo json_encode(array("status" => TRUE));
            $path = ROOTPATH . 'public/upload/penundaan/'.$dokumen;
            chmod($path, 0777);
            unlink($path);
            exit();
        } else {
            echo json_encode(array("status" => false));
            exit();
        }
    }
}
