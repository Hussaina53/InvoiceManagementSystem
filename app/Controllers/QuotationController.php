<?php

namespace App\Controllers;
use App\Models\QuotationModel;
// use App\Models\InvoiceModel;
use App\Models\CustomerModel;
use App\Models\ItemsModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class QuotationController extends BaseController
{

    public function __construct()
    {
        $this->QuotationModel=new QuotationModel();
        $this->CustomerModel=new CustomerModel();
        $this->ItemsModel=new ItemsModel();
        // return view('welcome_message');
    }

    public function list()
    {
        if(isset($_GET['ajax']) && !empty($_GET['ajax']) && $_GET['ajax']==1){
            $data['list']=$this->QuotationModel->getList();
            echo json_encode($data);
            exit;
        }
        $data['view']='quotation/list.php';
        $this->loadView($data);
    }

    public function create()
    {
        $postData=$this->request->getPost();
        $data['customerList']=$this->CustomerModel->getList();
        $data['itemList']=$this->ItemsModel->getList();
        $data['checkLastQuo']=$this->QuotationModel->checkLastQuo();
        if(!empty($data['checkLastQuo'])){
            $lastDigits = (int)substr($data['checkLastQuo']->quotation_no, -5);
            $addDigit=$lastDigits+1;
            $addNos=(string)$addDigit;
            $addString='';
            // 00001
            if(strlen($addNos)==1){
                $addString='0000'.$addNos;
            }else if(strlen($addNos)==2){
                $addString='000'.$addNos;
            }else if(strlen($addNos)==3){
                $addString='00'.$addNos;
            }else if(strlen($addNos)==4){
                $addString='0'.$addNos;
            }else{
                $addString=$addNos;
            }
        }else{
            $addString='00001';
        }
        $data['quo_no']='QUO'.date('y').'-'.$addString;
        // var_dump($addString);exit;
        if(!empty($postData['submit']) && $postData['submit']=='submit' && !empty($postData['method']) && $postData['method']=='create'){
            // echo "<pre>";print_r($postData);
            $postArray=array();
            foreach ($postData['items'] as $key => $item) {
                $postArray[$key]['item'] = $item;
                $postArray[$key]['rate'] =$postData['rate'][$key];
                $postArray[$key]['qty'] =$postData['qty'][$key];
                $postArray[$key]['amount'] =$postData['amount'][$key];
            }
            unset($postData['items']);
            unset($postData['rate']);
            unset($postData['qty']);
            unset($postData['amount']);
            $postData['postArr']=$postArray;
            $data['add']=$this->QuotationModel->saveData($postData);
            echo json_encode($data);
            exit;
        }
        $data['view']='quotation/add.php';
        $this->loadView($data);
    }

    public function view($id)
    {
        $data['viewData']=$this->QuotationModel->viewData($id);
        // echo "<pre>";print_r($data);exit;
        $data['view']='quotation/view.php';
        $this->loadView($data);
    }

    public function edit($id)
    {
        $postData=$this->request->getPost();
        if(!empty($postData['submit']) && $postData['submit']=='submit' && !empty($postData['method']) && $postData['method']=='edit'){
            // print_r($postData);
            $data['update']=$this->QuotationModel->updateData($id,$postData);
            echo json_encode($data);
            exit;
        }
        $data['viewData']=$this->QuotationModel->viewData($id);
        $data['view']='quotation/add.php';
        $this->loadView($data);
    }

    public function quotationPdf($id){
        $data['viewData']=$this->QuotationModel->viewData($id);
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('quotation/quotation_pdf',$data);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $invName='quotation-'.date('y-m-d H:i:s').'.pdf';
        $dompdf->stream($invName, [
            'Attachment' => true
        ]);
        exit;
    }

    public function statusUpdate($id){
        $postData=$this->request->getPost();
        $data['update']=$this->QuotationModel->updateStatus($id,$postData);
        echo json_encode($data);
    }
//End
}
