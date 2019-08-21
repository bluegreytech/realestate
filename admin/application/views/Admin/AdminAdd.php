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
						<h4 class="card-title" id="basic-layout-form">Add Admin
						<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
						<a href="<?php echo base_url();?>admin/adminlist" class="btn btn-black" style="float:right;">Back to Admin list</a>
					</h4>
					
				</div>
				
				<div class="card-body collapse in">
					<div class="card-block">
						 <?php // Change the css classes to suit your needs    

				        $attributes = array('class' => 'form', 'id' => 'add_admin','name'=>'admin', 'enctype'=>'multipart/form-data');
				        echo form_open_multipart('admin/addadmin', $attributes); ?>
						<!-- <form class="form"    method="post" enctype="multipart/form-data" id="add_admin"> -->
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i>Admin</h4>

									<div class="form-group">
								<input type="hidden"   value="<?php echo $AdminId; ?>" name="AdminId">
									<label>Full Name</label>
									<input type="text" class="form-control" placeholder="Full Name" name="FullName" id="FullName" value="<?php echo $FullName;?>" minlength="5" maxlength="200">
								</div>
									<div class="form-group">
									<label>Mobile No.</label>
									<input type="text" class="form-control" placeholder="Mobile no." name="AdminContact" value="<?php echo $AdminContact;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Email Address</label>
									<input type="text" class="form-control" placeholder="Email Address" name="EmailAddress" id="EmailAddress" value="<?php echo $EmailAddress;?>" minlength="5" maxlength="200">
								</div>
									<?php if($AdminId==''){ ?>
								<div class="form-group">
									<label>Password</label>
									<input type="password" class="form-control" placeholder="******" name="password" id="password" value="<?php echo $Password;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Confrim password</label>
									<input type="password" class="form-control" placeholder="******" name="cpassword" id="cpassword" value="" minlength="5" maxlength="200">
								</div>
							<?php } ?>

								<!-- <div class="form-group">
									<label>Profile Image</label>
									<input type="file" class="form-control" placeholder="Profile Image" name="ProfileImage"  id="ProfileImage" value="<?php //echo $ProfileImage;?>" minlength="5" maxlength="200">
								</div> -->



								
								<div class="form-group">
									<label>Address</label>
									<textarea type="text" class="form-control" placeholder="Address"  name="Address" id="Address" ><?php echo $Address;?></textarea>
								</div>
								<div class="form-group  uploadfrm">
									<label>Profile Image</label>
									<p><span class="btn btn-black btn-file">
										<input type="hidden" name="pre_profile_image" value="<?php echo $ProfileImage;?>">
									Upload profile image <input type="file" name="ProfileImage" id="profileimage" onchange="readURL(this);">
									</span></p>									
									<span id="profileerror"></span>
								</div>
									<div class="preview">
									
									<?php if($ProfileImage){ ?>
										<img id="blah" src="<?php echo base_url()?>upload/admin/<?php echo $ProfileImage;?>" class="img-thumbnail border-0" style="display: block;  width: 100px; height: 100px;">

									<?php } else{?>
									<img id="blah" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
									<?php } ?>
								</div>


								<!-- <div class="form-group ">
									<label>Profile Image</label>
									<input type="hidden" value="<?php //echo  $ProfileImage ?>" name="pre_profile_image" >
									<p><span class="btn btn-primary btn-file">
									Upload profile image <input type="file" name="ProfileImage" id="profileimage" onchange="readURL(this);">
									</span></p>									
									<span id="profileerror"></span>
								</div> -->
								
							

							<?php if($IsActive!=''){ ?>
                                
								<div class="form-group">
									<label>Status</label>
									<div class="input-group">
										<label class="display-inline-block custom-control custom-radio ml-1" >
										<input type="radio" name="IsActive" value="Active"
										<?php if($IsActive=="Active") { echo "checked"; } ?>
										class="custom-control-input"  >
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">Active</span>
										</label>

										<label class="display-inline-block custom-control custom-radio">
											<input type="radio" name="IsActive" value="Inactive"  <?php if($IsActive=="Inactive") { echo "checked"; } ?>  class="custom-control-input">
											<span class="custom-control-indicator" ></span>
											<span class="custom-control-description ml-0">Inactive</span>
										</label>
									</div>
								</div>
								<?php } else { ?>

								<div class="form-group">
									<label>Status</label>
									<div class="input-group">
										<label class="display-inline-block custom-control custom-radio ml-1">                           
										<input type="radio" name="IsActive" value="Active" checked="" 
											class="custom-control-input">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description ml-0">Active</span>
										</label>
										<label class="display-inline-block custom-control custom-radio">
											<input type="radio" name="IsActive" value="Inactive"
												class="custom-control-input">
												<span class="custom-control-indicator"></span>
												<span class="custom-control-description ml-0">Inactive</span>
										</label>
									</div>

								</div>
							<?php } ?>
								<div class="form-actions">
								 <button class="btn btn-black " type="submit"><i class="icon-ok"></i> <?php echo ($AdminId!='')?'Update':'Submit' ?></button>
								
								<input type="button" name="cancel" class="btn btn-default" value="Cancel" onClick="location.href='<?php echo base_url(); ?>admin/<?php echo $redirect_page?>'">
							</div>
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
    <?php   $this->load->view('common/footer');
    

    ?>
 <script>
 	$(document).ready(function() {  
 	
    $.validator.addMethod("noSpace", function(value, element) {        
            return value.indexOf(" ") < 0 && value != ""; 
        }, "No space please and don't leave it empty");     
     $.validator.addMethod('filesize', function (value, element, param) {
       
    return this.optional(element) || (element.files[0].size <= param)
} ,'File size must be equal to or less then 2MB'); 
  
  $.validator.addMethod("email_check", function(value, element) {

        var response;
        var user_id=$("#EmailAddress").val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('home/email_check'); ?>",
      data:{email:value},  
      async:false,
      success:function(data) {
      	console.log()
          response = data;
      }
    });
    if(response == 0) {
    	alert();
      return false;
    } else if(response == 1) {
      return true;
    }
  }, "Email address is already exist.");

       $('#add_admin').validate({

	        // errorElement: 'span', //default input error message container
	        // errorClass: 'help-inline', // default input error message class
	        // focusInvalid: false, // do not focus the last invalid input
	        // ignore: "",
	        // success: function(label,element) {
	        //     // label.parent().removeClass('error');
	        //     // label.remove();
	        // },
			rules: {
				FullName:{              
					required: true,                
					minlength: 3,
					maxlength: 25, 
				},  
				AdminContact:{
					required:true,
					maxlength:15,
					minlength:10,
				},        
				EmailAddress:{
					required:true,
					email:true,  
					email_check:true,           
				},				
				password: {
					noSpace: true,
					required: true,
					minlength: 8,
					maxlength: 16,
				},
				cpassword: {                 
					required: true,                                  
					equalTo: "#password"
				},
				ProfileImage:{
					extension: "JPG|jpeg|png|bmp",
					filesize: 2097152,   
				},
			 },
			 errorPlacement: function (error, element) {
            console.log('dd', element.attr("name"))
            if (element.attr("name") == "ProfileImage") {
                error.appendTo("#profileerror");
            } else{
                  error.insertAfter(element)
            }
        } 
    });
});

 	 
 </script>
 <script type="text/javascript">
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
 </script>