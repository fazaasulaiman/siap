<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class WaskatModel extends Model
{
    protected $table = "waskat";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['users_id','tglSurat', 'tglKejadian', 'nama','kewarganegaraan','gender','tglLahir','tempatLahir','noRegistrasi','noSurat','noPaspor','dokumen','pesawat'];
}