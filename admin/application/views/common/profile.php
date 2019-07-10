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
					<h4 class="card-title" id="basic-layout-form"><?php if($this->session->userdata('AdminId')==1)
					{
						echo "Edit  Proflie";
					}
					
					?>
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
								<div class="form-group">
									<label>Profile Image</label>
									<input type='hidden' value="<?php echo $ProfileImage; ?>" name="pre_profile_image">								
									<input type="file" class="form-control"  placeholder="Mobile No." name="profile_image" >
								</div>
								<div class="form-group">
									<label>Status</label>
									 <label class="radio-inline">							
										<input type="radio"  name="IsActive" value="Active" <?php if($IsActive=='Active') {echo "checked";  }?>> Active
									</label>

									<label class="radio-inline">	
										<input type="radio" name="IsActive" value="Inactive" <?php if($IsActive=='Inactive') {echo "checked";  }?>> Inactive
									</label>
								</div>
								<hr>
                              <div class="form-group">								
									<input type="submit" class="btn btn-primary" value="Update" name="btnupdate" minlength="2" maxlength="50">
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
	}
	},

	});
});
</script>