<section name="invoice-list">
    <div class="mt-2 mx-4 item-header">
        <h4 class="black-font">Invoice</h4>
        <a href="<?php echo base_url('invoice/create')?>" class="btn btn-default">ADD</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered black-font" id="invoice-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Invoice Date</th>
                    <th>Due Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        datatableLoad();

        $(document).on('change','.status-update',function(){
            var id=$(this).data('id');
            var url='<?php echo base_url('invoice/statusUpdate')?>'+'/'+id;
            var status=$(this).val();
            $.ajax({
                url:url,
                type:'POST',
                dataType:'json',
                data:{'status':status},
                success:function(res){
                    if(res.update==1){
                        alert('Status Updated Successfully!');
                    }else{
                        alert('Error!Please try again later');
                    }
                    window.location.href='<?php echo base_url('invoice/lists');?>';
                }
            });
        });

    });
    function datatableLoad(){
        var editUrl='<?php echo base_url('invoice/edit')?>';
        var viewUrl='<?php echo base_url('invoice/view')?>';
        var url='<?php echo base_url('invoice/lists?ajax=1')?>';
        var downloadUrl='<?php echo base_url('invoice/invoicePdf')?>';
        $('#invoice-list-table').DataTable({
            ajax:{
                url:url,
                type:'GET',
                dataSrc: 'list'
            },
            order:[[0,'desc']],
            columns:[
                {data:'id'},
                {data:'invoice_no'},
                {data:'customer_name'},
                {data:'invoice_date'},
                {data:'due_date'},
                {data:'total_amt'},
                {data:'status',
                    render:function(data,type,row){
                        let status_name='';
                        status_name='<select class="form-select status-update" data-id='+row.id+'><option value=1 ';
                        if(data==1){
                            status_name+='selected';
                        }
                        status_name+='>Paid</option><option value=2 ';
                        if(data==2){
                            status_name+='selected';
                        }
                        status_name+='>Pending</option></select>';
                        return status_name;
                    }
                },
                {
                    data:'id',
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        var editUrlFinal=editUrl+'/'+row.id;
                        var viewUrlFinal=viewUrl+'/'+row.id;
                        var downloadUrlFinal=downloadUrl+'/'+row.id;
                        return `
                            <a href="`+viewUrlFinal+`" class="btn btn-default">View</a>
                            <a href="`+downloadUrlFinal+`" class="btn btn-default" target="_blank">Download</a>
                        `;
                    }
                }
            ]
        });
    }
</script>