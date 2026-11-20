<section>
    <div class="row table-responsive">
        <div class="col-6 table-responsive m-5 shadow-sm rounded-4 overflow-hidden">
            <table class="table table-sm black-font">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Item Code</td>
                        <td><?php echo !empty($viewData['item_code'])?$viewData['item_code']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Item Name</td>
                        <td><?php echo !empty($viewData['item_name'])?$viewData['item_name']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Item Description</td>
                        <td><?php echo !empty($viewData['description'])?$viewData['description']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><?php echo !empty($viewData['price'])?$viewData['price']:'N/A'?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input toggleSwitch" type="checkbox" <?php echo $viewData['status']?'checked':'';?> id='<?php echo $viewData['id'];?>'>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6 ms-5 text-end">
            <!-- <a href="<?php echo base_url('items/edit/'.$viewData['id'])?>" class="btn btn-default">Edit</a> -->
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
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
                }
            });
        });
    });
</script>