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
						<a href="AdminList" class="btn btn-primary" style="float:right;">Back to Admin list</a>
					</h4>
					
				</div>
				
				<div class="card-body collapse in">
					<div class="card-block">
						<form class="form" method="post" enctype="multipart/form-data" id="add_admin">
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i>Admin</h4>

									<div class="form-group">
								<input type="hidden"   value="<?php echo $AdminId; ?>" name="AdminId">
									<label>Full Name</label>
									<input type="text" class="form-control" placeholder="Full Name" name="FullName" value="<?php echo $FullName;?>" minlength="5" maxlength="200">
								</div>

								

									<div class="form-group">
									<label>Mobile No.</label>
									<input type="text" class="form-control" placeholder="Mobile no." name="AdminContact" value="<?php echo $AdminContact;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Email Address</label>
									<input type="text" class="form-control" placeholder="Email Address" name="EmailAddress" value="<?php echo $EmailAddress;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="text" class="form-control" placeholder="Email Address" name="EmailAddress" value="<?php echo $EmailAddress;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Confrim password</label>
									<input type="text" class="form-control" placeholder="Email Address" name="EmailAddress" value="<?php echo $EmailAddress;?>" minlength="5" maxlength="200">
								</div>

								<div class="form-group">
									<label>Profile Image</label>
									<input type="file" class="form-control" placeholder="Profile Image" name="ProfileImage" value="<?php echo $ProfileImage;?>" minlength="5" maxlength="200">
								</div>

								
								<div class="form-group">
									<label>Address</label>
									<textarea type="text" class="form-control" placeholder="Address"  name="Address" id="Address" ></textarea>
								</div>

								<!-- <div class="form-group ">
									<label>Profile Image</label>
									<input type="hidden" value="<?php //echo  $ProfileImage ?>" name="pre_profile_image" >
									<p><span class="btn btn-primary btn-file">
									Upload profile image <input type="file" name="ProfileImage" id="profileimage" onchange="readURL(this);">
									</span></p>									
									<span id="profileerror"></span>
								</div> -->
								
								<div class="preview">
									<img id="blah" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
								</div>

								<div class="form-group">
											<label>Status</label>
											<div class="input-group">
												<label class="display-inline-block custom-control custom-radio ml-1">
													<input type="radio" name="IsActive" value="1" checked="" class="custom-control-input">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description ml-0">Active</span>
												</label>
												<label class="display-inline-block custom-control custom-radio">
													<input type="radio" name="IsActive" value="0" class="custom-control-input">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description ml-0">Inactive</span>
												</label>
											</div>
								</div>
								<div class="form-actions">
								<input  type="submit" name="save" class="btn btn-primary" value="Add">
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
 <script>
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