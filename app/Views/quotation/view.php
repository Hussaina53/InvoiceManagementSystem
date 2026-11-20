<section>
    <div class="">
        <div class="m-5 shadow-sm rounded-4 table-responsive">
            <table class="table table-sm black-font">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo !empty($viewData['quotation_no'])?$viewData['quotation_no']:'N/A'?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Customer</td>
                        <td><?php echo !empty($viewData['customer_name'])?$viewData['customer_name']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Quotation Date</td>
                        <td><?php echo !empty($viewData['quotation_date'])?date('d M,Y',strtotime($viewData['quotation_date'])):'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Notes</td>
                        <td><?php echo !empty($viewData['notes'])?$viewData['notes']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <div class="table-responsive table-responsive-nested">
                                <table class="table table-striped table-bordered black-font" id="quotation-list-table">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($viewData['quotation'])){ 
                                            foreach($viewData['quotation'] as $quotation){ ?>
                                        <tr>
                                            <td><?php echo !empty($quotation['item_code'])?$quotation['item_code'].'-'.$quotation['item_name']:'N/A'?></td>
                                            <td><?php echo !empty($quotation['price'])?$quotation['price']:'N/A'?></td>
                                            <td><?php echo !empty($quotation['qty'])?$quotation['qty']:'N/A'?></td>
                                            <td><?php echo !empty($quotation['total_amt'])?$quotation['total_amt']:'N/A'?></td>
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