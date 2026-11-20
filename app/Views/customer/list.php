<section name="customer-list">
    <div class="mt-2 mx-4 item-header">
        <h4 class="black-font">Customer</h4>
        <a href="<?php echo base_url('customer/create')?>" class="btn btn-default">ADD</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered black-font" id="customer-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Address</th>
                    <th>GST No</th>
                    <th>Mail ID</th>
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

        $(document).on('change','.toggleSwitch',function(){
            var id=$(this).attr('id');
            var statusProp=$(this).prop('checked');
            var status=0;
            if(statusProp==true){
                status=1;
            }
            $.ajax({
                url:'<?php echo base_url('customer/updateStatus')?>',
                dataType:'JSON',
                type:'POST',
                data:{status,id},
                success:function(res){
                    alert('Status Updated!');
                    datatableLoad();
                }
            });
        });
    });
    function datatableLoad(){
        if ($.fn.DataTable.isDataTable('#customer-list-table')) {
            $('#customer-list-table').DataTable().destroy();
        }
        var editUrl='<?php echo base_url('customer/edit')?>';
        var viewUrl='<?php echo base_url('customer/view')?>';
        var url='<?php echo base_url('customer/lists?ajax=1')?>';
        $('#customer-list-table').DataTable({
            ajax:{
                url:url,
                type:'GET',
                dataSrc: 'list'
            },
            order:[[0,'desc']],
            columns:[
                {data:'id'},
                {data:'name'},
                {data:'address'},
                {data:'gst_no'},
                {data:'mail_id'},
                {
                    data:null,
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        var check='';
                        if(row.status && row.status==1){
                            check='checked';
                        }
                        return `
                            <div class="form-check form-switch">
                                <input class="form-check-input toggleSwitch" type="checkbox" `+check+` id="`+row.id+`">
                            </div>
                        `;
                    }
                },
                {
                    data:'id',
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        var editUrlFinal=editUrl+'/'+row.id;
                        var viewUrlFinal=viewUrl+'/'+row.id;
                        return `
                            <a href="`+viewUrlFinal+`" class="btn btn-default">View</a>
                        `;
                    }
                }
            ]
        });
    }
</script>