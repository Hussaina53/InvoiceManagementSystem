<section name="items-list">
    <div class="mt-2 mx-4 item-header">
        <h4 class="black-font">Items</h4>
        <div class="mt-2 text-end mx-4">
            <a href="<?php echo base_url('items/create')?>" class="btn btn-default">ADD</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered black-font w-100" id="item-list-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Price</th>
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
                url:'<?php echo base_url('items/updateStatus')?>',
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
        if ($.fn.DataTable.isDataTable('#item-list-table')) {
            $('#item-list-table').DataTable().destroy();
        }
        var editUrl='<?php echo base_url('items/edit')?>';
        var viewUrl='<?php echo base_url('items/view')?>';
        var url='<?php echo base_url('items/lists?ajax=1')?>';
        $('#item-list-table').DataTable({
            ajax:{
                url:url,
                type:'GET',
                dataSrc: 'list'
            },
            order:[[0,'desc']],
            columns:[
                {data:'id'},
                {data:'item_code'},
                {data:'item_name'},
                {data:'description'},
                {data:'price'},
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