<?php

namespace App\Controllers;

use App\Models\PenolakanModel;
use Irsyadulibad\DataTables\DataTables;

class Penolakan extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->form_validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        return view('penolakan/arsip');
    }
    public function input()
    {
        return view('penolakan/input');
    }
    public function arsip()
    {
        return view('penolakan/arsip');
    }
    public function arsipJson()
    {

        // $data = $this->request->getPost();
        // var_dump($data);
        // exit();
        $dataTable = DataTables::use('penolakan')
            ->select('users.username,penolakan.id,penolakan.nama,penolakan.kewarganegaraan,penolakan.gender,penolakan.noPaspor,penolakan.penolakan,penolakan.dokumen,penolakan.bapen,penolakan.tglKejadian,penolakan.tglSurat')
            ->join('users', 'users.id = penolakan.users_id', 'INNER JOIN')
            ->addColumn('dokumen', function ($query) {
                return '<a href="../upload/dokumen/' . $query->dokumen . '?' . time() . '" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
            })
            ->addColumn('bapen', function ($query) {
                if (!empty($query->bapen)) {
                    return '<a href="../upload/bapen/' . $query->bapen . '?' . time() . '" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                }
                return '';
            })
            ->addColumn('seksi', function ($query) {
                return ucfirst($query->username);
            })
            ->addColumn('tglKejadian', function ($query) {
                return tgl_indo($query->tglKejadian);
            })
            ->addColumn('tglSurat', function ($query) {
                return tgl_indo($query->tglSurat);
            });
        if($this->session->get('level') != 'lainnya'){
            $dataTable->addColumn('aksi', function ($query) {
                if ($this->session->get('level') == 'admin') {
                    $html = '<div class="btn-group dropleft">
                        <button type="button" class="btn btn-secondary fa fa-cog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu">
                        <button class="dropdown-item" type="button" onclick="upload(' . "'" . $query->id . "'" . ',' . "'" . $query->nama . "'" . ')">Upload</button>
                        <button class="dropdown-item" type="button" onclick="hapus(' . "'" . $query->id . "'" . ',' . "'" . $query->nama . "'" . ')">Hapus</button>
                        </div>
                    </div>';
                }elseif ($this->session->get('level') == 'seksi' && $this->session->get('username') == $query->username) {
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


        if (!$this->form_validation->run($data, 'penolakan')) {

            echo json_encode(array('status' => false, 'text' => $this->form_validation->getErrors()));
            exit();
        }
        $data['tglSurat'] = formatdate($data['tglSurat']);
        $data['tglKejadian'] = formatdate($data['tglKejadian']);
        $data['tglLahir'] = formatdate($data['tglLahir']);
        $data['users_id'] = $this->session->get('id');
        $penolakan = new PenolakanModel();
        $dokumen->move(ROOTPATH . 'public/upload/dokumen', preg_replace('/\s+/', '_', $data['nama']) . '(' . $data['tglSurat'] . ').' . $dokumen->guessExtension(),true);
        $data['dokumen'] = $dokumen->getName();
        $penolakan->insert($data);
        echo json_encode(array('status' => true));
        exit();
    }
    public function bapenProcess(){
        $bapen= $this->request->getFile('bapen');
        $data = $this->request->getPost();
        $data['bapen'] = $bapen;
        if (!$this->form_validation->run($data, 'bapen')) {

            echo json_encode(array('status' => false, 'text' => $this->form_validation->getErrors()));
            exit();
        }
        $penolakan = new PenolakanModel();
        $bapen->move(ROOTPATH . 'public/upload/bapen', preg_replace('/\s+/', '_', $data['nama']).'(ids=' . $data['id'] . ').'.$bapen->guessExtension(),true);
        $data['bapen'] = $bapen->getName();
        $penolakan->update($data['id'],$data);
        echo json_encode(array('status' => true));
        exit();
        
    }
    public function remove()
    {
        $data = $this->request->getPost();
        if (!$this->form_validation->run($data, 'removePenolakan')) {

            echo json_encode(array('status' => false, 'text' => $this->form_validation->getErrors()));
            exit();
        }
        $id = $this->request->getVar('id');
        $penolakan = new PenolakanModel();
        if ($penolakan->find($id)) {
            $dokumen = $penolakan->find($id)->dokumen;
            $penolakan->delete($id);
            echo json_encode(array("status" => TRUE));
            $path = ROOTPATH . 'public/upload/dokumen/'.$dokumen;
            chmod($path, 0777);
            unlink($path);
            exit();
        } else {
            echo json_encode(array("status" => false));
            exit();
        }
    }
}
