<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class PenolakanModel extends Model
{
    protected $table = "penolakan";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['users_id','tglSurat', 'tglKejadian', 'nama','kewarganegaraan','gender','tglLahir','noPaspor','penolakan','dokumen','bapen'];
}