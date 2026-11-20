<section name="items-create">
    <div class="m-5">
        <form id="item-create-form" class="border rounded p-4 black-font" action="" method="">
            <?php $uri = service('uri');?>
            <input type="hidden" id="url" value="<?php echo $uri->getSegment(2);?>">
            <input type="hidden" id="id" value="<?php echo !empty($uri->getSegment(3))?$uri->getSegment(3):0;?>">
            <?php 
            $editReadOnly=$uri->getSegment(2)=='edit'?'readonly':'';
            $editReadOnlyColor=$uri->getSegment(2)=='edit'?'style="background-color:lightgray;"':'';
            ?>
            <div>
                <label for="item_code" class="form-label">Item Code<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="item_code" <?php echo $editReadOnly.' '.$editReadOnlyColor;?> id="item_code" value="<?php echo isset($viewData['item_code']) && !empty($viewData['item_code'])?$viewData['item_code']:''?>" placeholder="Enter Item Code" required>
                <span class="code_error d-none text-danger">Item code already exist.</span>
            </div>
            <div>
                <label for="" class="form-label">Item Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="item_name" id="item_name" value="<?php echo isset($viewData['item_name']) && !empty($viewData['item_name'])?$viewData['item_name']:''?>" placeholder="Enter Item Name" required>
            </div>
            <div>
                <label for="" class="form-label">Item Description</label>
                <input type="text" class="form-control" name="desc" id="desc" value="<?php echo isset($viewData['description']) && !empty($viewData['description'])?$viewData['description']:''?>" placeholder="Enter Item Description">
            </div>
            <div>
                <label for="" class="form-label">Price<span class="text-danger">*</span></label>
                <!-- <input type="number" class="form-control" name="price" id="price" value="<?php echo isset($viewData['price']) && !empty($viewData['price'])?$viewData['price']:''?>" placeholder="Enter Price" required> -->
                <input type="number" step="any" inputmode="decimal" min=0 class="form-control" name="price" id="price" value="<?php echo isset($viewData['price']) && !empty($viewData['price'])?$viewData['price']:''?>" placeholder="Enter Price" required>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-default" id="submit" val="submit">Submit</button>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#item-create-form').submit(function(e){
            e.preventDefault();
            if($('#url').val()=='create'){
                //create
                var url='<?php echo base_url('items/create')?>';
                const form = document.getElementById('item-create-form');
                var formData=new FormData(form);
                let item_code = formData.get('item_code');
                let check_code=checkitemExist(item_code);
                // alert(check_code);return false;
                if(check_code==false){
                    return false;
                }
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
                        window.location.href='<?php echo base_url('items/lists');?>';
                    }
                });
            }else{
                //edit
                var id=$('#id').val();
                var url='<?php echo base_url('items/edit')?>'+'/'+id;
                const form = document.getElementById('item-create-form');
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
                        window.location.href='<?php echo base_url('items/lists');?>';
                    }
                });
            }
        });
        
    });

    function checkitemExist(item_code){
        var url='<?php echo base_url('items/checkItemCodeExist')?>';
        var result=true;
        $.ajax({
            url:url,
            type:'POST',
            dataType:'json',
            data:{'item_code':item_code},
            async: false,
            success:function(res){
                if (res.item != null) {
                    alert('Item Code already exist!');
                    $('.code_error').removeClass('d-none');
                    result=false;
                }
            }
        });
        return result;
    }
</script>