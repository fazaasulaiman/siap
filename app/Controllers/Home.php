<?php

namespace App\Controllers;

use App\Models\PenolakanModel;
use PDO;

class Home extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->form_validation = \Config\Services::validation();
        $this->db      = \Config\Database::connect();
    }
    public function index()
    {
        return view('dashboard');
    }
    public function login()
    {
        return view('login');
    }
    public function process()
    {
        $data = $this->request->getPost();
        if (!$this->form_validation->run($data, 'login')) {

            echo json_encode(array('status' => false, 'ket' => $this->form_validation->getErrors()));
            exit();
        }
        echo json_encode(array('status' => true));
        exit();
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    public function stat(){
        $penolakan =  $this->db->table('penolakan');
        $penolakan = $penolakan->countAllResults();
        $waskat =  $this->db->table('waskat');
        $waskat = $waskat->countAllResults();
        $penundaan =  $this->db->table('penundaan');
        $penundaan = $penundaan->countAllResults();
        echo json_encode(array('status' => true, 'data' => array('penolakan' => $penolakan,'waskat'=>$waskat,'penundaan'=>$penundaan) ));
        exit();
    }
    public function grafik()
    {
        $data = $this->request->getGet();
        $builder =  $this->db->table($data['arsip']);
        if (!$this->form_validation->run($data, 'grafik')) {

            echo json_encode(array('status' => false, 'ket' => $this->form_validation->getErrors()));
            exit();
        }
        $data['mulai'] = formatdate($data['mulai']);
        $data['selesai'] = formatdate($data['selesai']);
        if ($data['jenis'] != 'tglSurat') {
            $type='pie';
            $title='grafik '.$data['jenis'];
            if($data['jenis'] != 'keterangan'){
                $builder->select("{$data['jenis']} , count({$data['jenis']}) as jumlah");
            
            }else{
                $col = 'users.'.$data['jenis'];
                $builder->select("{$col} as keterangan, count({$col}) as jumlah");
                $builder->join('users', 'users.id =penolakan.users_id');
            }
            $builder->where("DATE(tglSurat) BETWEEN '{$data['mulai']}' AND '{$data['selesai']}'");
            $builder->groupBy($data['jenis']);
            $query = $builder->get();
            if(empty($query->getResult())){
                echo json_encode(array('status' => false, 'ket' => 'Data Tidak Ditemukan'));
                exit();
            } 
            $results = array();
            foreach($query->getResult() as $row){
                $results['label'][]= $row->{$data['jenis']};
                $results['value'][]= $row->jumlah;
                $results['color'][]= randomColour();
                //$row->color = randomColour();
            }
            echo json_encode(array('status' => true, 'data' => $results, 'type' => $type,'title' => $title));
            exit();
        }else{
            $type='line';
            $title='Grafik Jumlah Penolakan';
            $builder->select("{$data['jenis']} , count({$data['jenis']}) as jumlah");
            $builder->where("DATE(tglSurat) BETWEEN '{$data['mulai']}' AND '{$data['selesai']}'");
            $builder->groupBy($data['jenis']);
            $builder->orderBy("{$data['jenis']}", "ASC");
            $query = $builder->get();
            if(empty($query->getResult())){
                echo json_encode(array('status' => false, 'ket' => 'Data Tidak Ditemukan'));
                exit();
            } 
            $results = array();
            foreach($query->getResult() as $row){
                $results['label'][]= tgl_indo($row->{$data['jenis']});
                $results['value'][]= $row->jumlah;
                $results['color'][]= randomColour();
                //$row->color = randomColour();
            }
            echo json_encode(array('status' => true, 'data' => $results, 'type' => $type,'title' => $title));
            exit();
        }
       
    }
}
