<div class="form-group last fileupload">
    <label class="control-label col-md-12"><?=!empty($label) ? $label : 'Image' ?></label>
    <div class="col-md-12">
       <div class="fileinput fileinput-new" data-provides="fileinput">
          <div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 200px;">
             <?php if (!empty($filename)  && file_exists(public_path() . '/uploads/'.@$folder.'/' .$filename)): ?>
                <?php 
                    $path = public_path() . '/uploads/'.@$folder.'/' .$filename;
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                ?>
                <?php if (in_array($ext, array('pdf', 'doc', 'docx'))): ?>
                    <img src="http://qa.ziffdavisb2b.com/ibm/pci/img/ibm/icon_ibm_document.png" id="thumb-img" style="max-width: 60px;" alt="">
                  <?php else: ?>   
                    <img src="/public/uploads/<?=$folder?>/<?=$filename?>" id="thumb-img" alt=""> 
                <?php endif ?>
              
             <?php else: ?>
             <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
             <?php endif ?> 
          </div>
          <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;">
          </div>
          <div>
             <span class="btn default btn-file">
             <span class="fileinput-new">
             Select </span>
             <span class="fileinput-exists">
             Change </span>
             <input type="file" name="<?=@$inputName?>">
             </span>

             <?php if (!empty($filename)  && file_exists(public_path() . '/uploads/'.@$folder.'/' .$filename)): ?>   
                <a data-toggle="modal" href="#myModal<?=$id?>" class="btn btn-danger del_btn" ><i class="fa fa-trash"></i> Delete </a>
                <!-- Modal -->
                <div class="modal fade theme-modal" id="myModal<?=@$id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                   <div class="modal-dialog">
                      <div class="modal-content">
                         <div class="modal-header">
                            <button type="button" style="float: right" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Confirm operation</h4>
                         </div>
                         <div class="modal-body">
                            Do you really want to delete?
                         </div>
                         <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                            <button class="btn btn-success" type="button" onclick="Ajax.deleteImg(this,'{{ $table }}', '{{ $id }}', '<?=$inputName?>')">Delete</button>
                         </div>
                      </div>
                   </div>
                </div>
                <!-- Modal --> 
             <?php else: ?>
             <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Cancel </a>
             <?php endif ?> 
            <?php if (!empty($allowed_types)): ?>
                    <?php       
                        $allowed_types = explode('|', $allowed_types);
                        $at='';
                        foreach ($allowed_types as $key => $value) {
                           $at .="<code>$value</code>";
                        }
                    ?>
                    <span class="help-block">Acceptable Formats<?=$at?></span>
                <?php else: ?>
                    <span class="help-block">Acceptable Formats <code>jpg</code> <code>png</code> <code>gif</code></span>
            <?php endif ?> 
            <?php if (!empty($dim)): ?>
                <span class="help-block">Size, px <code><?=$dim?></code></span>
            <?php endif ?>
          </div>
       </div> 
    </div>
 </div> 