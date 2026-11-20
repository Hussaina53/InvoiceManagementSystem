<?php

namespace App\Models;

use CodeIgniter\Model;

class QuotationModel extends Model
{
    protected $table            = 'quotation';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['quotation_no','customer_id','gst_total_percentage','gst_total_amt','quotation_date','discount_percentage','discount_amt','total_amt','notes'];

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
        $builder = $this->db->table('quotation q');
        $builder->select('q.*,c.name as customer_name');
        $builder->join('customers c', 'c.id = q.customer_id');
        $query = $builder->get();
        $result=$query->getResultArray();
        return($result);
    }

    
    public function saveData($postData=array()){
        $result=0;
        // echo "<pre>";print_r($postData);
        $data=[
            'quotation_no'=>$postData['quotation_no'],
            'customer_id'=>$postData['customer_id'],
            'gst_total_percentage'=>$postData['gst_total_percentage'],
            'gst_total_amt'=>$postData['gst_total_amt'],
            'quotation_date'=>$postData['quotation_date'],
            'discount_percentage'=>$postData['discount_percentage'],
            'discount_amt'=>$postData['discount_amt'],
            'gst_total_amt'=>$postData['gst_total_amt'],
            'total_amt'=>$postData['total_amt'],
            'notes'=>$postData['notes']
        ];
        $result=$this->save($data);
        $quo_id=$this->db->insertID();
        if(!empty($postData['postArr'])){
            foreach ($postData['postArr'] as $values) {
                $values['quo_id']=$quo_id;
                $this->quotationLinesSaveData($values);
            }
        }
        return($result);
    }

    public function quotationLinesSaveData($postData=array()){
        $result=0;
        $data=[
            'item_id'=>$postData['item'],
            'quotation_id'=>$postData['quo_id'],
            'qty'=>$postData['qty'],
            'total_amt'=>$postData['amount']
        ];
        $result=$this->db->table('quotation_lines')->insert($data);
        return($result);
    }

    public function updateStatus($id,$postData=array()){
        $result=0;
        $data=[
            'status'=>$postData['status']
        ];
        $result=$this->update($id,$data);
        return($result);
    }

    public function viewData($id){
        $result=array();
        $builder = $this->db->table('quotation q');
        $builder->select('q.*,c.name as customer_name');
        $builder->join('customers c', 'c.id = q.customer_id');
        $query = $builder->where('q.id',$id)->get();
        $result=$query->getRowArray();
        if(!empty($result)){
            $builder1 = $this->db->table('quotation_lines ql');
            $builder1->select('ql.quotation_id,ql.qty,ql.total_amt,i.item_name,i.item_code,i.price');
            $builder1->join('items i', 'i.id = ql.item_id');
            $query1 = $builder1->where('ql.quotation_id',$result['id'])->get();
            $result['quotation']=$query1->getResultArray();
        }
        return($result);
    }

    public function checkLastQuo(){
        $result=array();
        $query=$this->select('quotation.*')->get();
        $result=$query->getLastRow();
        return($result);
    }

    public function getCounts(){
        $result=0;
        $query=$this->select('count(quotation.id) as quotation_count')->get();
        $result=$query->getRowArray();
        // print_r($result);exit;
        return($result);
    }
}
