<!DOCTYPE html>
<html lang="en">
<!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head> -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        table {
            margin-left:-60px !important;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>

</head>
<body>
    <section>
        <div class="row">
            <div class="col-6 m-5">
                <table class="table table-bordered main-table">
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
                    </tbody>
                </table>
                <table class="table">
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
                            <td>Discount</td>
                            <td></td>
                            <td></td>
                            <td><?php echo !empty($viewData['discount_amt'])?$viewData['discount_amt']:0?></td>
                        </tr>
                        <tr>
                            <td>Tax</td>
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
        </div>
    </section>
</body>
</html>