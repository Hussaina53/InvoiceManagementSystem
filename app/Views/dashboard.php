<section name="dashboard" class="dashboard-class">
    <div class="row">
        <div class="col mx-2 mt-2 d-flex gap-3 responsive-col">
            <div class="card flex-fill justify-content-center align-items-center">
                    <a class="black-font text-decoration-none justify-items-center" href="<?php echo base_url('items/lists');?>">
                        <div class="dash-header">Items</div>
                        <div class="body"><?php echo !empty($item['item_count'])?$item['item_count']:0;?></div>
                    </a>
                </div>
            <div class="card flex-fill justify-content-center align-items-center">
                <a class="black-font text-decoration-none justify-items-center" href="<?php echo base_url('customer/lists');?>">
                    <div class="dash-header">Customer</div>
                    <div class="body"><?php echo !empty($customer['customer_count'])?$customer['customer_count']:0;?></div>
                </a>
            </div>
            <div class="card flex-fill justify-content-center align-items-center">
                <a class="black-font text-decoration-none justify-items-center" href="<?php echo base_url('invoice/lists');?>">
                    <div class="dash-header">Invoice</div>
                    <div class="body"><?php echo !empty($invoice['invoice_count'])?$invoice['invoice_count']:0;?></div>
                </a>
            </div>
            <div class="card flex-fill justify-content-center align-items-center">
                <a class="black-font text-decoration-none justify-items-center" href="<?php echo base_url('quotation/lists');?>">
                    <div class="dash-header">Quotation</div>
                    <div class="body"><?php echo !empty($quotation['quotation_count'])?$quotation['quotation_count']:0;?></div>
                </a>
            </div>
        </div>
    </div>
</section>