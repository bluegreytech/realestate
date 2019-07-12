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
					<a href="<?php echo base_url();?>Project/Projectlist/" class="btn btn-black" style="float:right">Back to Project List</a>
				</div>
				</h4>
				<div class="card-body collapse in">
					<div class="card-block">
				
						<form class="form" method="post" enctype="multipart/form-data" id="form_assesment" action="<?php echo base_url();?>Project/Projectadd">
					
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>
							
								<div class="form-group">
								<input type="hidden" value="<?php echo $ProjectId; ?>" name="ProjectId">
									<label>Project Title</label>
									<input type="text" class="form-control" placeholder="Project Title" name="ProjectTitle" value="<?php echo $ProjectTitle;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Project Short Description</label>
									<input type="text" class="form-control" placeholder="Project Title" name="ProjectTitle" value="<?php echo $ProjectTitle;?>" minlength="5" maxlength="200">
								</div>


								<div class="form-group">
									<label>Project Long Description</label>
									<textarea  class="ckeditor" placeholder="Project Description" name="ProjectDescription" minlength="5" maxlength="200"><?php echo $ProjectDescription;?></textarea>
								</div>

								<div class="form-group">
									<label>Price</label>
									<input type="text" class="form-control" placeholder="Price" name="Price" value="<?php echo $Price;?>" minlength="5" maxlength="200">
								</div>

									<div class="form-group  uploadfrm">
									<label>Profile Image</label>
									<p><span class="btn btn-black btn-file">
										<input type="hidden" name="pre_profile_image" value="<?php echo $ProjectImage;?>">
									Upload profile image <input type="file" name="ProjectImage" id="ProjectImage" onchange="readURL(this);">
									</span></p>									
									<span id="profileerror"></span>
								</div>
									<div class="preview">
									
									<?php if($ProjectId){ ?>
										<img id="blah" src="<?php echo base_url()?>upload/admin/<?php echo $ProjectImage;?>" class="img-thumbnail border-0" style="display: block;  width: 100px; height: 100px;">

									<?php } else{?>
									<img id="blah" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
									<?php } ?>
								</div>

								<?php  if($IsActive!=''){ ?>
                                
								<div class="form-group">
									<label>Status</label>
									<div class="input-group">
										<label class="display-inline-block custom-control custom-radio ml-1">
											<?php //echo $IsActive; ?>
											<input type="radio" name="IsActive" value="Active"
												<?php if($IsActive=="Active") { echo "checked"; } ?>
												 class="custom-control-input">																					<span class="custom-control-indicator"></span>																	<span class="custom-control-description ml-0">Active</span>
													</label>
													<label class="display-inline-block custom-control custom-radio">						<input type="radio" name="IsActive" value="Inactive"  <?php if($IsActive=="Active") { echo "checked"; } ?> class="custom-control-input">
													<span class="custom-control-indicator"></span>class="custom-control-description ml-0">Inactive</span>
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

				<?php }?>


							<div class="form-actions">
									 <button class="btn btn-black " type="submit"><i class="icon-ok"></i> <?php echo ($ProjectId!='')?'Update':'Submit' ?></button>
							
									<input type="button" name="cancel" class="btn btn-default" value="Cancel" onClick="location.href='<?php echo base_url(); ?>admin/<?php echo $redirect_page; ?>'">
								
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

						ProjectTitle:{
								required: true,
								},
						Sdesc:{
								required: true,
							  },
						ldesc: {
								required: true,
						
							},
							price: {
								required: true,
						
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