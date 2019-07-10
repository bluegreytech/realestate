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
					<?php if($ProjectId==1)
					{
						echo	"Edit Project";
					}
					else{
					echo	"Add Project";
					}
					?>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<a href="<?php echo base_url();?>Project/Projectlist/" class="btn btn-primary" style="float:right">Back to Project List</a>
				</div>
				</h4>
				<div class="card-body collapse in">
					<div class="card-block">
				
						<form class="form" method="post" enctype="multipart/form-data" id="form_assesment" action="<?php echo base_url();?>Project/Projectadd">
					
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>
							
								<div class="form-group">
								<input type="hidden"   value="<?php echo $ProjectId; ?>" name="ProjectId">
									<label>Project Title</label>
									<input type="text" class="form-control" placeholder="Project Title" name="ProjectTitle" value="<?php echo $ProjectTitle;?>" minlength="5" maxlength="200">
								</div>

								<div class="form-group">
									<label>Project Description</label>
									<input type="text" class="form-control" placeholder="Project Description" name="ProjectDescription" value="<?php echo $ProjectDescription;?>" minlength="5" maxlength="200">
								</div>

								<div class="form-group">
									<label>Price</label>
									<input type="text" class="form-control" placeholder="Price" name="Price" value="<?php echo $Price;?>" minlength="5" maxlength="200">
								</div>

								<div class="form-group">
									<label>Project Image</label>
									<input type="text" class="form-control" placeholder="Project Image" name="ProjectImage" value="<?php echo $ProjectImage;?>" minlength="5" maxlength="200">
								</div>

								<div class="form-group">
									<label>Project Image</label>
									<input type="text" class="form-control" placeholder="Project Image" name="ProjectStatus" value="<?php echo $ProjectStatus;?>" minlength="5" maxlength="200">
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
					
								<?php if($ProjectId!=''){?>
									<button type="submit" name="updateAdmin" class="btn btn-primary">
										<i class="icon-check2"></i> Update
									</button>
								<?php }else{ ?>
									<button type="submit" name="addAdmin" class="btn btn-primary">
									<i class="icon-check2"></i> Add
									</button>
								<?php } ?>
								
							
								<a href="<?php echo base_url(); ?>Project/Projectlist" name="CancelUser" class="btn btn-danger">
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

 
					                    CKEDITOR.replace('editor1');
					                

</script>