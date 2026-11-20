<section>
    <div class="">
        <div class="m-5 shadow-sm rounded-4 table-responsive">
            <table class="table table-sm black-font">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo !empty($viewData['invoice_no'])?$viewData['invoice_no']:'N/A'?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Customer</td>
                        <td><?php echo !empty($viewData['customer_name'])?$viewData['customer_name']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Issue Date</td>
                        <td><?php echo !empty($viewData['invoice_date'])?date('d M,Y',strtotime($viewData['invoice_date'])):'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Due Date</td>
                        <td><?php echo !empty($viewData['due_date'])?date('d M,Y',strtotime($viewData['due_date'])):'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <?php
                        $viewData['pay_name']='';
                        if(!empty($viewData['pay_method'])){
                            if($viewData['pay_method']==1){
                                $viewData['pay_name']='Cash';
                            }else if($viewData['pay_method']==2){
                                $viewData['pay_name']='Cheque';
                            }else{
                                $viewData['pay_name']='Credit';
                            }
                        }
                        ?>
                        <td><?php echo !empty($viewData['pay_name'])?$viewData['pay_name']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <?php
                        $viewData['status_name']='';
                        if(!empty($viewData['status'])){
                            if($viewData['status']==1){
                                $viewData['status_name']='Paid';
                            }else{
                                $viewData['status_name']='Pending';
                            }
                        }
                        ?>
                        <td><?php echo !empty($viewData['status_name'])?$viewData['status_name']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Notes</td>
                        <td><?php echo !empty($viewData['notes'])?$viewData['notes']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="table-responsive table-responsive-nested">
                                <table class="table table-striped table-bordered black-font" id="invoice-list-table">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($viewData['invoices'])){ 
                                            foreach($viewData['invoices'] as $invoice){ ?>
                                        <tr>
                                            <td><?php echo !empty($invoice['item_code'])?$invoice['item_code'].'-'.$invoice['item_name']:'N/A'?></td>
                                            <td><?php echo !empty($invoice['price'])?$invoice['price']:'N/A'?></td>
                                            <td><?php echo !empty($invoice['qty'])?$invoice['qty']:'N/A'?></td>
                                            <td><?php echo !empty($invoice['total_amt'])?$invoice['total_amt']:'N/A'?></td>
                                        </tr>
                                        <?php }} ?>
                                        <tr>
                                            <td>Discount(<?php echo !empty($viewData['discount_percentage'])?$viewData['discount_percentage'].'%':0 .'%'?>)</td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo !empty($viewData['discount_amt'])?$viewData['discount_amt']:0?></td>
                                        </tr>
                                        <tr>
                                            <td>Tax(<?php echo !empty($viewData['gst_total_percentage'])?$viewData['gst_total_percentage'].'%':0 .'%'?>)</td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo !empty($viewData['gst_total_amt'])?$viewData['gst_total_amt']:0?></td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                            <th><?php echo !empty($viewData['total_amt'])?$viewData['total_amt']:0?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6 ms-5 text-end">
            <!-- <a href="<?php echo base_url('customer/edit/'.$viewData['id'])?>" class="btn btn-default">Edit</a> -->
        </div>
    </div>
</section>