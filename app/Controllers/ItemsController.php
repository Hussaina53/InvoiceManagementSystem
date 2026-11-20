<?php

namespace App\Controllers;
use App\Models\ItemsModel;

class ItemsController extends BaseController
{

    public function __construct()
    {
        $this->ItemsModel=new ItemsModel();
        // return view('welcome_message');
    }

    public function list()
    {
        if(isset($_GET['ajax']) && !empty($_GET['ajax']) && $_GET['ajax']==1){
            $data['list']=$this->ItemsModel->getList();
            echo json_encode($data);
            exit;
        }
        $data['view']='items/list.php';
        $this->loadView($data);
    }

    public function create()
    {
        $postData=$this->request->getPost();
        if(!empty($postData['submit']) && $postData['submit']=='submit' && !empty($postData['method']) && $postData['method']=='create'){
            // print_r($postData);
            $data['add']=$this->ItemsModel->saveData($postData);
            echo json_encode($data);
            exit;
        }
        $data['view']='items/add.php';
        $this->loadView($data);
    }

    public function view($id)
    {
        $data['viewData']=$this->ItemsModel->viewData($id);
        $data['view']='items/view.php';
        $this->loadView($data);
    }

    public function edit($id)
    {
        $postData=$this->request->getPost();
        if(!empty($postData['submit']) && $postData['submit']=='submit' && !empty($postData['method']) && $postData['method']=='edit'){
             // print_r($postData);
            $data['update']=$this->ItemsModel->updateData($id,$postData);
            echo json_encode($data);
            exit;
        }
        $data['viewData']=$this->ItemsModel->viewData($id);
        $data['view']='items/add.php';
        $this->loadView($data);
    }

    public function updateStatus()
    {
        $postData=$this->request->getPost();
        if(isset($postData['id']) && !empty($postData['id'])){
            $id=$postData['id'];
            $postData['updateStatus']=1;
            $data['update']=$this->ItemsModel->updateData($id,$postData);
            echo json_encode($data);
            exit;
        }
    }

    public function checkItemCodeExist(){
        $postData=$this->request->getPost();
        if(isset($postData['item_code']) && !empty($postData['item_code'])){
            $data['item']=$this->ItemsModel->checkItemCodeExist($postData);
            echo json_encode($data);
            exit;
        }
    }

}
