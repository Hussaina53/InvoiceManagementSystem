<section name="invoice-create">
    <div class="m-5">
        <div class="d-flex justify-content-between">
            <h3 class="black-font">New Invoice(<?php echo $inv_no; ?>)</h3>
            <input type="text" class="invoice_no hide" value="<?php echo $inv_no; ?>">
            <div>
                <!-- <a href="#" class="btn btn-primary pdf_preview">Preview PDF</a> -->
                <select class="form-select status" name="status" id="">
                    <option value="0">Status</option>
                    <option value="1">Paid</option>
                    <option value="2">Pending</option>
                </select>
            </div>
        </div>
        <form id="invoice-create-form" class="border rounded p-4 black-font" action="" method="POST">
            <?php $uri = service('uri');?>
            <input type="hidden" id="url" value="<?php echo $uri->getSegment(2);?>">
            <input type="hidden" id="id" value="<?php echo !empty($uri->getSegment(3))?$uri->getSegment(3):0;?>">
            <div class="row">
                <div class="col mx-4 mt-2 d-flex gap-5 billing-details">
                    <div class="card colour-card col-4 flex-fill justify-content-center align-items-left px-5 pb-4 pt-3">
                        <div class="header-text">
                            <p class="fw-bold bill-details">Bill To</p>
                        </div>
                        <div class="body col-12">
                            <label for="" class="form-label">Customer Name<span class="text-danger">*</span></label>
                            <select class="form-select" name="customer_id" id="customer_select" required>
                                <option value="">Select customer</option>
                                <?php if(isset($customerList) && !empty($customerList)){
                                    foreach($customerList as $customer){?>
                                        <option value="<?php echo $customer['id']?>" data-address="<?php echo $customer['address']?>" data-email="<?php echo $customer['mail_id']?>"><?php echo $customer['name'].'-'.$customer['gst_no']?></option>
                                <?php } }?>
                            </select>
                            <label for="" class="form-label">Email Address</label>
                            <input type="text" class="form-control" id="mail_id" readonly>
                            <label for="" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" readonly>
                        </div>
                    </div>
                    <div class="card colour-card col-4 flex-fill justify-content-center align-items-left px-5 py-5">
                        <div class="header-text
                        ">
                            <p class="fw-bold inv-details">Invoice Details</p>
                        </div>
                        <div class="body col-12">
                            <label for="" class="form-label">Issue Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="issue_date" required>
                            <label for="" class="form-label">Due Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="due_date" required>
                            <label for="" class="form-label">Payment method</label>
                            <select class="form-select" name="pay_method" id="">
                                <option value="1">Cash</option>
                                <option value="2">Cheque</option>
                                <option value="3">Credit</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mx-2 mt-2">
                <h4>LINE ITEMS</h4>
                <div class="rounded-3 border overflow-hidden m-3 p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered black-font mb-0" id="line_item_table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Rate(Per each)</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr id="item_row" class="line-row">
                                    <!-- <td width="45%" data-label="Description"> -->
                                    <td class="desc-class" data-label="Description">
                                        <select class="form-select" name="items[]" id="item_select">
                                            <option value="0">Select Items</option>
                                            <?php if(isset($itemList) && !empty($itemList)){
                                                foreach($itemList as $item){?>
                                                    <option value="<?php echo $item['id']?>" data-rate="<?php echo $item['price']?>"><?php echo $item['item_code'].'-'.$item['item_name']?></option>
                                            <?php } }?>
                                        </select>
                                    </td>
                                    <td width="12%" data-label="Rate(Per each)">
                                    <!-- <td data-label="Rate(Per each)"> -->
                                        <input type="number" class="form-control" name="rate[]" id="rate" readonly>
                                    </td>
                                    <td data-label="Qty">
                                        <input type="text" class="form-control" name="qty[]" id="qty">
                                    </td>
                                    <td data-label="Amount">
                                        <input type="text" class="form-control amount-class" name="amount[]" id="amount" readonly>
                                    </td>
                                    <td id="minus_btn"></td>
                                </tr>
                                <tr id="add_more_btn_row">
                                    <td>
                                        <a href="#" class="button btn-primary" id="add_more_btn">Add more</a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="row mx-2 mt-2">
                <h4>NOTES</h4>
                <div class="col-12 d-flex gap-5 notes-div">
                    <div class="col-8 col-4 flex-fill justify-content-center align-items-left">
                        <textarea class="textarea item-desc rounded-3 colour-card" name="notes" id="" placeholder="Payment due within 30 days of the issue date. Bank transfer preferred — details on file. Thank you for your business!"></textarea>
                    </div>
                    <div class="card col-4 flex-fill align-items-left p-4 colour-card">
                        <div class="body">
                            <div class="sub_total flex-class">
                                <p>Sub Total</p>
                                <span id="sub_total_val">0</span>
                            </div>
                            <div class="discount flex-class">
                                <p>Discount(%)</p>
                                <span><input type="text" name="discount" class="form-control discount_percent"></span>
                            </div>
                            <div class="discount_amt flex-class">
                                <p>Discount Amount(-)</p>
                                <span id="discount_amnt">0</span>
                            </div>
                            <div class="tax flex-class">
                                <p>Tax(%)</p>
                                <span><input type="text" name="tax" class="form-control tax_percent"></span>
                            </div>
                            <div class="tax_amount flex-class">
                                <p>Tax Amount(+)</p>
                                <span id="tax_amnt">0</span>
                            </div>
                        </div>
                        <div class="footer-class pt-2 border-top border-dark">
                            <div class="total flex-class">
                                <p>Total due</p>
                                <span class="total_val">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="button" class="btn btn-default" id="discard" val="discard">Discard</button>
                <button type="submit" class="btn btn-default" id="submit" val="submit">Save Draft</button>
                <!-- <button type="button" class="btn btn-default" id="save_send" val="save_send">Save & Send</button> -->
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    function removeRow(btn){
        if ($('#line_item_table tbody tr').length > 1) {
            $(btn).closest('tr').remove();
            var amounts=getAllAmounts();
            var subtotal=calculateSubtotal(amounts);
            getTotal();
        }
    }

    function calculateSubtotal(amounts) {

        var subtotal=0;
        // $(amounts).each(function () {
        //     subtotal+=parseFloat(amounts);
        // });
        // alert(subtotal);
        $.each(amounts, function(index, value) {
            subtotal += parseFloat(value) || 0;
        });
        // alert(subtotal);
        $('#sub_total_val').text(subtotal);
        // return subtotal;
    }

    function getAllAmounts() {

        var amounts = [];

        $('.amount-class').each(function () {
            amounts.push(parseFloat($(this).val()) || 0);
        });

        console.log(amounts);
        return amounts;
        // alert(subtotal);
        // return subtotal;
    }

    function getTotal(){
        var tax=parseFloat($('#tax_amnt').text())||0;
        var discount=parseFloat($('#discount_amnt').text())||0;
        var sub_total=parseFloat($('#sub_total_val').text())||0;
        var total=(sub_total+tax)-discount;
        // alert(total);
        $('.total_val').text(total.toFixed(2));
    }

    $(document).ready(function(){
        $(document).on('change','#customer_select',function(){
            var mail_id = $('#customer_select option:selected').data('email');
            $('#mail_id').val(mail_id);
            var address = $('#customer_select option:selected').data('address');
            $('#address').val(address);
        });
        $(document).on('change','#item_select',function(){
            // var rate = $('#item_select option:selected').data('rate');
            // $('#rate').val(rate);
            // $('#qty').val(1);
            var $row = $(this).closest('tr');
            var rate = $(this).find('option:selected').data('rate');
            $row.find('#rate').val(rate);
            // $row.find('#qty').val(1);
        });
        $(document).on('input','#item_select,#qty',function(){
            var $row = $(this).closest('tr');
            var rate = parseFloat($row.find('#item_select option:selected').data('rate')) || 0;
            var qty  = parseFloat($row.find('#qty').val()) || 0;
            $row.find('#amount').val(rate * qty);
            var amounts=getAllAmounts();
            var subtotal=calculateSubtotal(amounts);
            getTotal();
        });

        $(document).on('click','#add_more_btn',function(e){
            e.preventDefault();
            var item_list=<?php echo json_encode($itemList)?>;
            console.log(item_list);
            var item_select='';
            $.each(item_list, function(key, value){
                item_select +='<option value="'+value['id']+'" data-rate="'+value['price']+'">'+value['item_code']+'-'+value['item_name']+'</option>'
            });
            // var row_id=0;
            var row_id_no=$('#tbody tr').length;
            var row_id = 'row_' + (row_id_no);
            var minus_btn_new='<svg onclick="removeRow(this)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'+
                '<line x1="5" y1="12" x2="19" y2="12"/>'+
                '</svg>';
            var row='<tr id='+row_id+'>'+
                        '<td width="45%">'+
                            '<select class="form-select" name="items['+row_id_no+']" id="item_select">'+
                                '<option value="1">Select Items</option>'+
                                    item_select+
                            '</select>'+
                        '</td>'+
                        '<td width="12%">'+
                            '<input type="number" class="form-control" name="rate['+row_id_no+']" id="rate" readonly>'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" class="form-control" name="qty['+row_id_no+']" id="qty">'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" class="form-control amount-class" name="amount['+row_id_no+']" id="amount" readonly>'+
                        '</td>'+
                        '<td id="minus_btn_new">'+minus_btn_new+'</td>'+
                    '</tr>';
            // Insert the new row right before the "Add more" row
            $('#add_more_btn_row').before(row);
        });

        $(document).on('change','.discount_percent',function(){
            var discount_percent=parseFloat($(this).val())||0;
            var sub_total=parseFloat($('#sub_total_val').text())||0;
            var discount=sub_total*(parseFloat(discount_percent)/100);
            var discount_amount=discount.toFixed(2);
            $('#discount_amnt').text(discount_amount);
            getTotal();
        });

        $(document).on('change','.tax_percent',function(){
            var tax_percent=parseFloat($(this).val())||0;
            var sub_total=parseFloat($('#sub_total_val').text())||0;
            var tax=sub_total*(parseFloat(tax_percent)/100);
            var tax_amount=tax.toFixed(2);
            $('#tax_amnt').text(tax_amount);
            getTotal();
        });

        $(document).on('click','#discard',function(){
            var a=confirm('Are you sure to discard this invoice?');
            if(a===true){
                location.href = '<?php echo base_url('invoice/lists')?>';
            }
        });

        $('#invoice-create-form').submit(function(e){
            e.preventDefault();
            if($('.status').val()==0){
                alert('Please select status!');
                return false;
            }
            if($('#item_select').val()==0){
                alert('Please select atleast 1 item for billing!');
                return false;
            }
            if($('#url').val()=='create'){
                //create
                var url='<?php echo base_url('invoice/create')?>';
                const form = document.getElementById('invoice-create-form');
                var formData=new FormData(form);
                formData.append('submit','submit');
                formData.append('method',$('#url').val());
                formData.append('gst_total_percentage',$('.tax_percent').val());
                formData.append('gst_total_amt',$('#tax_amnt').text());
                formData.append('discount_percentage',$('.discount_percent').val());
                formData.append('discount_amt',$('#discount_amnt').text());
                formData.append('total_amt',$('.total_val').text());
                formData.append('invoice_no',$('.invoice_no').val());
                formData.append('status',$('.status').val());
                $.ajax({
                    url:url,
                    type:'POST',
                    dataType:'json',
                    processData:false,
                    contentType:false,
                    data:formData,
                    success:function(res){
                        if(res.add==1){
                            alert('Saved Successfully!');
                        }else{
                            alert('Error!Please try again later');
                        }
                        window.location.href='<?php echo base_url('invoice/lists');?>';
                    }
                });
            }else{
                //edit
                var id=$('#id').val();
                var url='<?php echo base_url('invoice/edit')?>'+'/'+id;
                const form = document.getElementById('invoice-create-form');
                var formData=new FormData(form);
                formData.append('submit','submit');
                formData.append('method',$('#url').val());
                $.ajax({
                    url:url,
                    type:'POST',
                    dataType:'json',
                    processData:false,
                    contentType:false,
                    data:formData,
                    success:function(res){
                        if(res.update==1){
                            alert('Updated Successfully!');
                        }else{
                            alert('Error!Please try again later');
                        }
                        window.location.href='<?php echo base_url('invoice/lists');?>';
                    }
                });
            }
        });
        
    });
</script>