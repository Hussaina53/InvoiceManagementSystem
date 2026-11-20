<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','address','gst_no','mail_id','status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function __construct(){
        $this->db=\Config\Database::connect();
    }

    public function getList(){
        $result=array();
        $query=$this->select('customers.*')->get();
        $result=$query->getResultArray();
        return($result);
        //old method to load db class 1st,then calling data from table
        // $builder=$this->db->table('items')->select('*');
        // $query=$builder->get();
        // print_r($query);
    }

    
    public function saveData($postData=array()){
        $result=0;
        $data=[
            'name'=>$postData['name'],
            'address'=>$postData['address'],
            'gst_no'=>$postData['gst_no'],
            'mail_id'=>$postData['mail_id'],
            'status'=>1
        ];
        $result=$this->save($data);
        return($result);
    }

    public function updateData($id,$postData=array()){
        $result=0;
        $data=[];
        if(isset($postData['updateStatus']) && !empty($postData['updateStatus'])){
            $data=[
                'status'=>!empty($postData['status'])?$postData['status']:0
            ];
        }else{
            $data=[
                'name'=>$postData['name'],
                'address'=>$postData['address'],
                'gst_no'=>$postData['gst_no'],
                'mail_id'=>$postData['mail_id'],
                'status'=>1
            ];
        }
        $result=$this->update($id,$data);
        return($result);
    }

    public function viewData($id){
        $result=array();
        $query=$this->select('customers.*')->where('id',$id)->get();
        $result=$query->getRowArray();
        return($result);
    }

    public function getCounts(){
        $result=0;
        $query=$this->select('count(customers.id) as customer_count')->get();
        $result=$query->getRowArray();
        // print_r($result);exit;
        return($result);
    }
}
