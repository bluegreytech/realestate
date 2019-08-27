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
					<?php if($UserId==1)
					{
						echo "Edit User";
					}
					else{
					echo	"Add User";
					}
					?>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<a href="<?php echo base_url();?>User/Userlist/" class="btn btn-black" style="float:right">Back to User List</a>
				</div>
				</h4>
				<div class="card-body collapse in">
					<div class="card-block">
				
						<form class="form" method="post" enctype="multipart/form-data" id="add_user" action="<?php echo base_url();?>User/Useradd">
					
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>
							
								<div class="form-group">
								<input type="hidden"   value="<?php echo $UserId; ?>" name="UserId">
									<label>Full Name</label>
									<input type="text" class="form-control" placeholder="Full Name" name="FullName" value="<?php echo $FullName;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Email Address</label>
									<input type="text" class="form-control" placeholder="Email Address" name="EmailAddress" value="<?php echo $EmailAddress;?>" readonly="">
								</div>
								<div class="form-group">
									<label>Project name</label>
									<input type="text" class="form-control" placeholder="Project name" name="Project_name" value="<?php echo $Project_name;?>" >
								
								</div>
								<div class="form-group">
									<label>House No</label>
									<input type="text" class="form-control" placeholder="house no" name="House_no" value="<?php echo $House_no; ?>" >
									
								</div>
								
								<div class="form-group">
									<label>Mobile no.</label>
									<input type="text" class="form-control" placeholder="Mobile no." name="UserContact" value="<?php echo $UserContact; ?>"  readonly>
								</div>
								<!-- <div class="form-group  uploadfrm">
									<label>Profile Image</label>
									<p><span class="btn btn-black btn-file">
										<input type="hidden" class="form-control" name="pre_profile_image" value="<?php echo $ProfileImage;?>">
									Upload profile image <input type="file" name="ProfileImage" id="profileimage" onchange="readURL(this);">
									</span></p>									
									<span id="profileerror"></span>
								</div>
								
								<div class="preview">
									<?php if($UserId){ ?>
										<img id="blah" src="<?php //echo base_url()?>upload/user/<?php //echo $ProfileImage;?>" class="img-thumbnail border-0" style="display: block;  width: 100px; height: 100px;">

									<?php } else{?>
									<img id="blah" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
									<?php } ?>
								</div> -->

								<?php  if($IsActive!=''){ ?>
                                
								<div class="form-group">
									<label>Status</label>
										<div class="input-group">								<label class="display-inline-block custom-control custom-radio ml-1">										<?php //echo $IsActive; ?>							<input type="radio" name="IsActive" value="Active"
											<?php if($IsActive=="Active") { echo "checked"; } ?>
											 class="custom-control-input">					
											 <span class="custom-control-indicator"></span>
											 <span class="custom-control-description ml-0">Active</span>										</label>										<label class="display-inline-block custom-control custom-radio">					<input type="radio" name="IsActive" value="Inactive"  <?php if($IsActive=="Inactive") { echo "checked"; } ?> 
												class="custom-control-input">					<span class="custom-control-indicator"></span>										
												<span class="custom-control-description ml-0">Inactive</span>								</label></div>
											</div>
									<?php } else { ?>
									<div class="form-group">
										<label>Status</label>									<div class="input-group">								<label class="display-inline-block custom-control custom-radio ml-1">							<input type="radio" name="IsActive" value="Active" checked="" class="custom-control-input">		
										<span class="custom-control-indicator"></span>		<span class="custom-control-description ml-0">Active</span>	</label>										<label class="display-inline-block custom-control custom-radio">										<input type="radio" name="IsActive" value="Inactive"
										class="custom-control-input">						
										<span class="custom-control-indicator"></span>		<span class="custom-control-description ml-0">Inactive</span></label>
										</div>
								</div>
							<?php } ?>
							<div class="form-actions">
							 <button class="btn btn-black " type="submit"><i class="icon-ok"></i> <?php echo ($UserId!='')?'Update':'Submit' ?></button>
							
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
{
	
       $('#add_user').validate({

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
				UserContact:{
					required:true,
					maxlength:15,
					minlength:10,
				},        
				EmailAddress:{
					required:true,
					email:true,             
				},
				Addresses:{
						required:true,
				}				
				
				// ProfileImage:{
				// 	accept: "jpg|jpeg|png|bmp",
				// 	filesize: 2097152  
				// },
			 }, 
    });
});

 //CKEDITOR.replace('editor1');

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