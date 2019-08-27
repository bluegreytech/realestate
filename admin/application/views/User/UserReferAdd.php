<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php 
	 $this->load->view('common/header');
	 $this->load->view('common/sidebar');
?>
 <div class="app-content content container-fluid">
    <div class="content-wrapper">
        
      <div class="content-body"><!-- Basic form layout section start -->
<section id="basic-form-layouts">
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">
					Edit Refer User
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<a href="<?php echo base_url();?>User/Userrefer_list/" class="btn btn-black" style="float:right">Back to Refer List</a>
				</div>
				</h4>
				<div class="card-body collapse in">
					<div class="card-block">
				
						<form class="form" method="post" enctype="multipart/form-data" id="add_user" action="<?php echo base_url();?>User/UserReferAdd">
					
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i> Refered By</h4>
									<div class="form-group">
									<input type="hidden" value="<?php echo $refer_id; ?>" name="refer_id">
									<input type="hidden" value="<?php echo $UsersId; ?>" name="UsersId">
								
								</div>
								
									<label class="col-md-3">Refer user Name</label>
									<label class="col-md-3"><span><?php if($FullName){  echo ucfirst($FullName); }else{ echo "-" ; }  ?></span></label>
									<label class="col-md-3">Refer User ContactNo </label>
									<label class="col-md-3"><span><?php if($UserContact){ echo $UserContact; }else{ echo "-"; }  ?></span></label>
									<label class="col-md-3">Refer user Email</label>
									<label class="col-md-3"><span><?php if($EmailAddress) { echo $EmailAddress; }else{ echo "-"; } ?></span></label>
									
									<label class="col-md-3">Refer user Address</label>
									<label class="col-md-3"><span><?php if($Project_name && $House_no){ echo  $House_no.' '.$Project_name; }else{ echo "-";}  ?></span></label>
								

									<h4 class="form-section"><i class="icon-clipboard4"></i> Refered To</h4>
									<div class="col-md-12">
									<label class="col-md-3">User Name</label>
									<label class="col-md-3"><span><?php if($name){ echo ucfirst($name); }else{ echo "-" ; } ?></span></label>
									<label class="col-md-3">ContactNo </label>
									<label class="col-md-3"><span><?php if($mobileno ){ echo $mobileno; }else{ echo "-" ;} ?></span></label>
									<label class="col-md-3">Email</label>
									<label class="col-md-3"><span><?php if($email){ echo $email; }else{ echo "-";}  ?></span></label>
										<label class="col-md-3">Property</label>
									<label class="col-md-3"><span><?php if($property){ echo $property; }else{ echo "-";}  ?></span></label>
									
									<label class="col-md-3">Status</label>

									<label class="col-md-3"> 
										<select class="form-control" name="status" id="status">
											<option disabled="" selected="">Please select</option>
											<?php if($status=='Refered') {  ?>
												<option value="Refered" <?php if($status=='Refered'){ echo "selected"; } ?>>Refered</option>
												<option value="Inprogress" <?php if($status=='Inprogress'){ echo "selected"; } ?>>In progress</option>
												<option value="Declined" <?php if($status=='Declined'){ echo "selected"; } ?>>Declined</option>
												<option value="Closed" <?php if($status=='Closed'){ echo "selected"; } ?>>Closed</option>
											<?php }elseif ($status=='Inprogress') { ?>
												<option value="Inprogress" <?php if($status=='Inprogress'){ echo "selected"; } ?>>In progress</option>
												<option value="Declined" <?php if($status=='Declined'){ echo "selected"; } ?>>Declined</option>
												<option value="Closed" <?php if($status=='Closed'){ echo "selected"; } ?>>Closed</option>
										
											<?php }elseif ($status=='Declined') { ?>
											
												<option value="Declined" <?php if($status=='Declined'){ echo "selected"; } ?>>Declined</option>
												
										
											<?php }elseif ($status=='Closed') { ?>
												<option value="Closed" <?php if($status=='Closed'){ echo "selected"; } ?>>Closed</option>
											<?php } ?>
										</select>
                                    </label>
								</div>
						
							  <div class="form-group"  style="display:none;" id="closingpoints">


							  		<label >Closing points</label>
									<input type="text" value="" name="closing_points" class="form-control" >								
								</div>
								<div class="form-group">
								  	<label>Comments</label>
										<textarea  value="" name="comments" class="form-control"></textarea>
								</div>
								<div class="clearfix"></div>
							 <hr>

							<div class="form-action">
							<button class="btn btn-black " type="submit"  <?php if($status=='Closed'){echo "disabled";}?>><i class="icon-ok"></i> <?php echo ($refer_id!='')?'Update':'Submit' ?></button>
							
								<input type="button" name="cancel" class="btn btn-default" value="Cancel" onClick="location.href='<?php echo base_url(); ?>user/<?php echo $redirect_page; ?>'">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		
			
	</div>
</section>
<!-- // Basic form layout section end -->
        </div>
      </div>
    </div>
	<?php 
 $this->load->view('common/footer');
?>

<script>

$(document).ready(function()
{jQuery.validator.addMethod("specialChars", function( value, element ) {
        var regex = new RegExp("^[0-9-!@#$%*?]");
        var key = value;

        if (!regex.test(key)) {
           return false;
        }
        return true;
    }, "please use only Numbers and special characters");
	
       $('#add_user').validate({
	       
			rules:{
				closing_points:{
					specialChars:true
				}
			
			 }, 
    });
});

 //CKEDITOR.replace('editor1');
 var dataClosed=$('select[name=status]').val();
  if(dataClosed === 'Closed') {
        	$("#closingpoints").css('display','block');
        }

 function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah').css('display', 'block');
                    $('#blah').attr('src', e.target.result);
                };
             reader.readAsDataURL(input.files[0]);
            }
        }	

        $(function(){
        	
        $('select[name=status]').change(function() {
		
        if($(this).val() === 'Closed') {

        	$("#closingpoints").css('display','block');
          
        }
    });

});	                

</script>