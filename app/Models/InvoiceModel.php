<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'invoice';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['invoice_no','customer_id','gst_total_percentage','gst_total_amt','invoice_date','due_date','discount_percentage','discount_amt','total_amt','notes','status','pay_method'];

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
        $builder = $this->db->table('invoice i');
        $builder->select('i.*,c.name as customer_name');
        $builder->join('customers c', 'c.id = i.customer_id');
        $query = $builder->get();
        $result=$query->getResultArray();
        return($result);
    }

    
    public function saveData($postData=array()){
        $result=0;
        // echo "<pre>";print_r($postData);
        $data=[
            'invoice_no'=>$postData['invoice_no'],
            'customer_id'=>$postData['customer_id'],
            'gst_total_percentage'=>$postData['gst_total_percentage'],
            'gst_total_amt'=>$postData['gst_total_amt'],
            'invoice_date'=>$postData['issue_date'],
            'due_date'=>$postData['due_date'],
            'discount_percentage'=>$postData['discount_percentage'],
            'discount_amt'=>$postData['discount_amt'],
            'gst_total_amt'=>$postData['gst_total_amt'],
            'total_amt'=>$postData['total_amt'],
            'notes'=>$postData['notes'],
            'pay_method'=>$postData['pay_method'],
            'status'=>$postData['status']
        ];
        $result=$this->save($data);
        $inv_id=$this->db->insertID();
        if(!empty($postData['postArr'])){
            foreach ($postData['postArr'] as $values) {
                $values['inv_id']=$inv_id;
                $this->invoiceLinesSaveData($values);
            }
        }
        return($result);
    }

    public function invoiceLinesSaveData($postData=array()){
        $result=0;
        $data=[
            'item_id'=>$postData['item'],
            'inv_id'=>$postData['inv_id'],
            'qty'=>$postData['qty'],
            'total_amt'=>$postData['amount']
        ];
        $result=$this->db->table('invoice_lines')->insert($data);
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
        $builder = $this->db->table('invoice i');
        $builder->select('i.*,c.name as customer_name');
        $builder->join('customers c', 'c.id = i.customer_id');
        $query = $builder->where('i.id',$id)->get();
        $result=$query->getRowArray();
        if(!empty($result)){
            $builder1 = $this->db->table('invoice_lines il');
            $builder1->select('il.inv_id,il.qty,il.total_amt,i.item_name,i.item_code,i.price');
            $builder1->join('items i', 'i.id = il.item_id');
            $query1 = $builder1->where('il.inv_id',$result['id'])->get();
            $result['invoices']=$query1->getResultArray();
        }
        return($result);
    }

    public function checkLastInv(){
        $result=array();
        $query=$this->select('invoice.*')->get();
        $result=$query->getLastRow();
        return($result);
    }

    public function getCounts(){
        $result=0;
        $query=$this->select('count(invoice.id) as invoice_count')->get();
        $result=$query->getRowArray();
        // print_r($result);exit;
        return($result);
    }
}
