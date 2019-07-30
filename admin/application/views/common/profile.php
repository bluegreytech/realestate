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
			    <?php if(($this->session->flashdata('successmsg'))){ ?>
        <div class="alert alert-success" id="successMessage">
        <strong> <?php echo $this->session->flashdata('successmsg'); ?></strong> 
        </div>
    <?php } ?>
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form">Edit Profile 
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
				
				</div></h4>
				<div class="card-body collapse in">
					<div class="card-block">
						<form class="form" method="post" id="form_profile" action="<?php echo base_url();?>home/profile/" enctype="multipart/form-data">
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i>Requirements</h4>
								<div class="form-group">
									<label>Full Name</label>								
									<input type="text" class="form-control" value="<?php echo $full_name; ?>" placeholder="Full Name" name="full_name" >
								</div>
								<div class="form-group">
									<label>Email ID</label>								
									<input type="text" class="form-control" value="<?php echo $EmailAddress; ?>" placeholder="Email" name="EmailAddress"  readonly>
								</div>
								<div class="form-group">
									<label>Mobile No.</label>								
									<input type="text" class="form-control" value="<?php echo $contact; ?>" placeholder="Mobile No." name="AdminContact" >
								</div>
							<!-- 	<div class="form-group">
									<label>Profile Image</label>
									<input type='hidden' value="<?php echo $ProfileImage; ?>" name="pre_profile_image">								
									<input type="file" class="form-control"  placeholder="Mobile No." name="profile_image" >
								</div> -->
								<div class="form-group  uploadfrm">
									<label>Profile Image</label>
									<p><span class="btn btn-black btn-file">
										<input type="hidden" name="pre_profile_image" value="<?php echo $ProfileImage;?>">
									Upload profile image <input type="file" name="profile_image" id="profile_image" onchange="readURL(this);">
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
									<!--  <label class="radio-inline">							
										<input type="radio"  name="IsActive" value="Active" <?php if($IsActive=='Active') {echo "checked";  }?>> Active
									</label>

									<label class="radio-inline">	
										<input type="radio" name="IsActive" value="Inactive" <?php if($IsActive=='Inactive') {echo "checked";  }?>> Inactive
									</label> -->
								</div>
								<hr>
                              <div class="form-group">								
									<input type="submit" class="btn btn-black" value="Update" name="btnupdate" minlength="2" maxlength="50">
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
	<?php 
$this->load->view('common/footer');	
?>

<script>
$(function() { 
    setTimeout(function() {
  $('#successMessage').fadeOut('fast');
}, 3000);
   
});
$.validator.addMethod('filesize', function (value, element, param) {
	return this.optional(element) || (element.files[0].size <= param)
	} ,'File size must be equal to or less then 2MB');
$(document).ready(function()
{
	$("#form_profile").validate(
	{
	rules: {
	EmailAddress: {
		required: true,
		email:true,
	},
	first_name:{
		required: true,
	},
	last_name:{
		required: true,
	},
	phone:{
		required:true,
		digits:true,
		minlength:10,
		maxlength:15,
	},
	profile_image:{
					extension: "JPG|jpeg|png|bmp",
					filesize: 2097152,   
				},
	},
	 errorPlacement: function (error, element) {
            console.log('dd', element.attr("name"))
            if (element.attr("name") == "profile_image") {
                error.appendTo("#profileerror");
            } else{
                  error.insertAfter(element)
            }
        }

	});
});

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