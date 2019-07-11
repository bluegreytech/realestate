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
						echo	"Edit User";
					}
					else{
					echo	"Add User";
					}
					?>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<a href="<?php echo base_url();?>User/Userlist/" class="btn btn-primary" style="float:right">Back to User List</a>
				</div>
				</h4>
				<div class="card-body collapse in">
					<div class="card-block">
				
						<form class="form" method="post" enctype="multipart/form-data" id="form_assesment" action="<?php echo base_url();?>User/Useradd">
					
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>
							
								<div class="form-group">
								<input type="hidden"   value="<?php echo $UserId; ?>" name="UserId">
									<label>Full Name</label>
									<input type="text" class="form-control" placeholder="Full Name" name="FullName" value="<?php echo $FullName;?>" minlength="5" maxlength="200">
								</div>

								<div class="form-group">
									<label>Email Address</label>
									<input type="text" class="form-control" placeholder="Email Address" name="EmailAddress" value="<?php echo $EmailAddress;?>" minlength="5" maxlength="200">
								</div>

								<div class="form-group">
									<label>Address</label>
									<input type="text" class="form-control" placeholder="Address" name="Addresses" value="<?php echo $Addresses;?>" minlength="5" maxlength="200">
								</div>

								<!-- <div class="form-group">
									<label>Profile Image</label>
									<input type="text" class="form-control" placeholder="Profile Image" name="ProfileImage" value="<?php //echo $ProfileImage;?>" minlength="5" maxlength="200">
								</div> -->

								<div class="form-group  uploadfrm">
									<label>Profile Image</label>
									<p><span class="btn btn-primary btn-file">
									Upload profile image <input type="file" name="ProfileImage" id="profileimage" onchange="readURL(this);">
									</span></p>									
									<span id="profileerror"></span>
								</div>
								
								<div class="preview">
									<img id="blah" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
								</div>

								<div class="form-group">
									<label>Contact</label>
									<input type="text" class="form-control" placeholder="Contact" name="UserContact" value="<?php echo $UserContact;?>" minlength="5" maxlength="200">
								</div>

								<?php  if($IsActive!=''){ ?>
                                
								<div class="form-group">
																				<label>Status</label>
																				<div class="input-group">
																								<label class="display-inline-block custom-control custom-radio ml-1">
																								<?php //echo $IsActive; ?>
																												<input type="radio" name="IsActive" value="Active"
		<?php if($IsActive=="Active") { echo "checked"; } ?>
		 class="custom-control-input">
																												<span class="custom-control-indicator"></span>
																												<span class="custom-control-description ml-0">Active</span>
																								</label>
																								<label class="display-inline-block custom-control custom-radio">
																												<input type="radio" name="IsActive" value="Inactive"  <?php if($IsActive=="Active") { echo "checked"; } ?>                                                  
		class="custom-control-input">
																												<span class="custom-control-indicator"></span>
																												<span class="custom-control-description ml-0">Inactive</span>
																								</label>
																				</div>
								</div>
				<?php } else { ?>
								<div class="form-group">
																				<label>Status</label>
																				<div class="input-group">
																								<label class="display-inline-block custom-control custom-radio ml-1">                                                                                
																												<input type="radio" name="IsActive" value="Active"
	 checked="" 
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

				<?php }?>


							<div class="form-actions">
					
								<?php if($UserId!=''){?>
									<button type="submit" name="updateAdmin" class="btn btn-primary">
										<i class="icon-check2"></i> Update
									</button>
								<?php }else{ ?>
									<button type="submit" name="addAdmin" class="btn btn-primary">
									<i class="icon-check2"></i> Add
									</button>
								<?php } ?>
								
							
								<a href="<?php echo base_url(); ?>User/Userlist" name="CancelUser" class="btn btn-danger">
								Cancel
								</a>
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
		$("#form_assesment").validate(
		{
			rules: {

						StreamTypeId: {
								required: true,
													},
						ProgramId: {
								required: true,
													},
						AssesmentName: {
								required: true,
							//	pattern: /^[a-zA-Z0-9\s\-\ ]+$/,
							//	minlength: 5,
													},

						},

						messages: {

						StreamTypeId: {
						required: "Plesae select stream",

										},
						ProgramId: {
						required: "Plesae select program",

										},
						AssesmentName: {
						required: "Please enter assesment name",
						pattern : "Enter only characters and numbers and \"space , \" -",
						minlength: "Please enter at least 5 and maximum to 200 letters!",
										},
					
					
						}
				
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