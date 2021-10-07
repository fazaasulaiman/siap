<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class PenundaanModel extends Model
{
    protected $table = "penundaan";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['users_id','tglSurat', 'tglKejadian', 'nama','kewarganegaraan','gender','tglLahir','tempatLahir','noSurat','noPaspor','dokumen','pesawat'];
}