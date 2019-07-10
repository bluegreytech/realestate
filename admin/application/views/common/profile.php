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
					<h4 class="card-title" id="basic-layout-form"><?php if($this->session->userdata('UserId')==1)
					{
						echo "Edit  Proflie";
					}
					
					?>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
				
				</div></h4>
				<div class="card-body collapse in">
					<div class="card-block">
						<form class="form" method="post" id="form_profile" action="<?php echo base_url();?>Login/profile/">                      
                        
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>                             
                               
								<div class="form-group">
									<label>First Name</label>								
									<input type="text" class="form-control" value="<?php echo $first_name; ?>" placeholder="First Name" name="first_name" >
								</div>
									<div class="form-group">
									<label>Last Name</label>								
									<input type="text" class="form-control" value="<?php echo $last_name; ?>" placeholder="Last Name" name="last_name">
								</div>
								<div class="form-group">
									<label> Email</label>								
									<input type="text" class="form-control" value="<?php echo $EmailAddress; ?>" placeholder="Email" name="EmailAddress"  readonly>
								</div>
								<div class="form-group">
									<label>Phone</label>								
									<input type="text" class="form-control" value="<?php echo $phone; ?>" placeholder="Phone" name="phone" >
								</div>
								<div class="form-group">
									<label>Gender</label>
									 <label class="radio-inline">							
										<input type="radio"  value="male" name="gender" <?php if($gender=='male') {echo "checked";  }?>> Male
									</label>

									<label class="radio-inline">	
										<input type="radio" value="female" name="gender" <?php if($gender=='female') {echo "checked";  }?>> Female
									</label>
								</div>
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