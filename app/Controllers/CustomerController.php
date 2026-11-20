<?php

namespace App\Controllers;
use App\Models\CustomerModel;

class CustomerController extends BaseController
{

    public function __construct()
    {
        $this->CustomerModel=new CustomerModel();
        // return view('welcome_message');
    }

    public function list()
    {
        if(isset($_GET['ajax']) && !empty($_GET['ajax']) && $_GET['ajax']==1){
            $data['list']=$this->CustomerModel->getList();
            echo json_encode($data);
            exit;
        }
        $data['view']='customer/list.php';
        $this->loadView($data);
    }

    public function create()
    {
        $postData=$this->request->getPost();
        if(!empty($postData['submit']) && $postData['submit']=='submit' && !empty($postData['method']) && $postData['method']=='create'){
            // print_r($postData);
            $data['add']=$this->CustomerModel->saveData($postData);
            echo json_encode($data);
            exit;
        }
        $data['view']='customer/add.php';
        $this->loadView($data);
    }

    public function view($id)
    {
        $data['viewData']=$this->CustomerModel->viewData($id);
        $data['view']='customer/view.php';
        $this->loadView($data);
    }

    public function edit($id)
    {
        $postData=$this->request->getPost();
        if(!empty($postData['submit']) && $postData['submit']=='submit' && !empty($postData['method']) && $postData['method']=='edit'){
             // print_r($postData);
            $data['update']=$this->CustomerModel->updateData($id,$postData);
            echo json_encode($data);
            exit;
        }
        $data['viewData']=$this->CustomerModel->viewData($id);
        $data['view']='customer/add.php';
        $this->loadView($data);
    }

    public function updateStatus()
    {
        $postData=$this->request->getPost();
        if(isset($postData['id']) && !empty($postData['id'])){
            $id=$postData['id'];
            $postData['updateStatus']=1;
            $data['update']=$this->CustomerModel->updateData($id,$postData);
            echo json_encode($data);
            exit;
        }
    }

}
