<?php

namespace App\Controllers;
use App\Models\ItemsModel;
use App\Models\CustomerModel;
use App\Models\InvoiceModel;
use App\Models\QuotationModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->ItemsModel=new ItemsModel();
        $this->CustomerModel=new CustomerModel();
        $this->InvoiceModel=new InvoiceModel();
        $this->QuotationModel=new QuotationModel();
        // return view('welcome_message');
    }

    public function dashboard()
    {
        $data['item']=$this->ItemsModel->getCounts();
        $data['customer']=$this->CustomerModel->getCounts();
        $data['invoice']=$this->InvoiceModel->getCounts();
        $data['quotation']=$this->QuotationModel->getCounts();
        // echo "<pre>";print_r($data);exit;
        $data['view']='dashboard.php';
        $this->loadView($data);
    }
}
