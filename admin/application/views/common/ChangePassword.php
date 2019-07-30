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
			    <?php if(($this->session->flashdata('success'))){ ?>
        <div class="alert alert-success" id="successMessage">
        <strong> <?php echo $this->session->flashdata('success'); ?></strong> 
        </div>
    <?php } ?>
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-form"><?php if($this->session->userdata('AdminId')==1)
					{
						echo "Change Password";
					}
					
					?>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
				
				</div></h4>
				<div class="card-body collapse in">
					<div class="card-block">
						<form class="form" method="post" id="form_changepassword" action="<?php echo base_url();?>home/change_password/" enctype="multipart/form-data">
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i>Requirements</h4>
								<div class="form-group">
									<label>Old Password</label>								
									<input type="password" class="form-control"  placeholder="Old Password" name="old_password" id="old_password">
								</div>
									
								<div class="form-group">
								<label>New Password</label>								
									<input type="password" class="form-control"  placeholder="New Password" name="password" id="password">
								</div>
								<div class="form-group">
								<label>Confirm Password</label>								
									<input type="password" class="form-control"  placeholder="Confirm Password" name="cpassword">
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
$(document).ready(function()
{
	$("#form_changepassword").validate(
	{
	rules: {
	old_password:{
		required: true,
		password_check:true,
	},
	password:{
		required: true,
	},
	cpassword:{
		required: true,
		equalTo:"#password",
	},
	},

	});
});
$.validator.addMethod("password_check", function(value, element) {

        var response;
        var user_id=$("#old_password").val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('home/oldpassword_check'); ?>",
      data:{password:value},  
      async:false,
      success:function(data) {
      	console.log()
          response = data;
      }
    });
    if(response == 0) {
      return false;
    } else if(response == 1) {
      return true;
    }
  }, "The old password you have entered is incorrect.");
</script>