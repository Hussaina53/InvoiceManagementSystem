<section name="customer-create">
    <div class="m-5">
        <form id="customer-create-form" class="border rounded p-4 black-font" action="" method="">
            <?php $uri = service('uri');?>
            <input type="hidden" id="url" value="<?php echo $uri->getSegment(2);?>">
            <input type="hidden" id="id" value="<?php echo !empty($uri->getSegment(3))?$uri->getSegment(3):0;?>">
            <div>
                <label for="" class="form-label">Customer Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo isset($viewData['name']) && !empty($viewData['name'])?$viewData['name']:''?>" placeholder="Enter Customer Name" required>
            </div>
            <div>
                <label for="" class="form-label">Address<span class="text-danger">*</span></label>
                <textarea name="address" id="address" class="form-control" required placeholder="Enter Address"><?php echo isset($viewData['address']) && !empty($viewData['address'])?$viewData['address']:''?></textarea>
            </div>
            <div>
                <label for="" class="form-label">GST No:<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="gst_no" id="gst_no" value="<?php echo isset($viewData['gst_no']) && !empty($viewData['gst_no'])?$viewData['gst_no']:''?>" placeholder="Enter GST No." required>
            </div>
            <div>
                <label for="" class="form-label">Email<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="mail_id" id="mail_id" value="<?php echo isset($viewData['mail_id']) && !empty($viewData['mail_id'])?$viewData['mail_id']:''?>" placeholder="Enter Mail Id" required>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-default" id="submit" val="submit">Submit</button>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#customer-create-form').submit(function(e){
            e.preventDefault();
            if($('#url').val()=='create'){
                //create
                var url='<?php echo base_url('customer/create')?>';
                const form = document.getElementById('customer-create-form');
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
                        if(res.add==1){
                            alert('Saved Successfully!');
                        }else{
                            alert('Error!Please try again later');
                        }
                        window.location.href='<?php echo base_url('customer/lists');?>';
                    }
                });
            }else{
                //edit
                var id=$('#id').val();
                var url='<?php echo base_url('customer/edit')?>'+'/'+id;
                const form = document.getElementById('customer-create-form');
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
                        window.location.href='<?php echo base_url('customer/lists');?>';
                    }
                });
            }
        });
        
    });
</script>