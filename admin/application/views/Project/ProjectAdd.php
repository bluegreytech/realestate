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
				
						<form class="form" method="post" enctype="multipart/form-data" id="frm_project" action="<?php echo base_url();?>Project/Projectadd">
					
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>
							
								<div class="form-group">
								<input type="hidden" value="<?php echo $ProjectId; ?>" name="ProjectId">
									<label>Project Title</label>
									<input type="text" class="form-control" placeholder="Project Title" name="ProjectTitle" value="<?php echo $ProjectTitle;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Project Short Description</label>
									<textarea type="text" class="form-control" placeholder="Project Short Description" name="Projectsdesc" rows="5" ><?php echo $Projectsdesc; ?></textarea>
								</div>
								<div class="form-group">
									<label>Project Status</label>
									<select name="Projectstatus" class="form-control" id="projectstatus">
										<option selected="" disabled="">Please select</option>
										<option value="Ongoing" <?php if($ProjectStatus=='Ongoing'){ echo "selected"; }?> >Ongoing Project</option>
										<option value="Past" <?php if($ProjectStatus=='Past'){ echo "selected"; }?>>Past Project</option>
										<option value="Upcoming" <?php if($ProjectStatus=='Upcoming'){ echo "selected"; }?> >Upcoming Project</option>
									</select>
								</div>

								<div class="form-group">
									<label>Project Amenities</label>
									<textarea  class="ckeditor" placeholder="Project Long Description" name="Projectldesc" ><?php echo $Projectldesc;?></textarea>
								</div>

								<!--<div class="form-group">
									<label>Price</label>
									<input type="text" class="form-control" placeholder="Price" name="Price" value="<?php //echo $Price;?>" minlength="5" maxlength="200">
								</div> -->

								<div class="form-group">
										<label>Project logo</label>
										<p><span class="btn btn-black btn-file">
											<input type="hidden" name="pre_project_logo" value="<?php echo $Projectlogo;?>">
										Upload project logo <input type="file" name="Projectlogo" id="Projectlogo" onchange="readURL(this);">
										</span></p>									
										<span id="profileerrorlogo"></span>
								</div>
								<div class="preview">									
								<?php if($Projectlogo){ ?>
								<img id="blahlogo" src="<?php echo base_url()?>upload/projectlogo/<?php echo $Projectlogo;?>" class="img-thumbnail border-0" style="display: block;  width: 100px; height: 100px;">
								<?php } else{?>
								<img id="blahlogo" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
								<?php } ?>
								</div>

								<div class="form-group">
									<label>Project Image</label>
									<p><span class="btn btn-black btn-file">
									<input type="hidden" name="pre_project_image" value="<?php echo $ProjectImage;?>">
									Upload project image <input type="file" name="ProjectImage" id="ProjectImage" onchange="readURLimg(this);">
									</span></p>									
									<span id="profileerrorimg"></span>
								</div>
								<div class="preview">									
									<?php if($ProjectImage){ ?>
									<img id="blahimg" src="<?php echo base_url()?>upload/projectimage/<?php echo $ProjectImage;?>" class="img-thumbnail border-0" style="display: block;  width: 100px; height: 100px;">
									<?php } else{?>
									<img id="blahimg" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
									<?php } ?>
								</div>

								<div class="form-group">
									<label>Project Brochure</label>
									<p><span class="btn btn-black btn-file">
									<input type="hidden" name="pre_project_brochure" value="<?php echo $Project_brochure;?>">
									Upload project brochure <input type="file" name="Projectbrochure" id="Projectbrochure" onchange="readURLbroch(this);">
									</span></p>									
									<span id="profileerrorbroch"></span>
								</div>
								<div class="preview">									
									<?php if($Project_brochure){   ?>
									<img id="blahbroch" src="<?php echo base_url()?>upload/projectbrochure/<?php echo $Project_brochure;?>" class="img-thumbnail border-0" style="display: block;  width: 100px; height: 100px;">
									<?php } else{   ?>
									<img id="blahbroch" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
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
													<label class="display-inline-block custom-control custom-radio"><input type="radio" name="IsActive" value="Inactive"  <?php if($IsActive=="Inactive") { echo "checked"; } ?> class="custom-control-input">
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
									 <button class="btn btn-black " type="submit"><i class="icon-ok"></i> <?php echo ($ProjectId!='')?'Update':'Submit' ?></button>
							
									<input type="button" name="cancel" class="btn btn-default" value="Cancel" onClick="location.href='<?php echo base_url(); ?>project/<?php echo $redirect_page; ?>'">
								
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
		$("#frm_project").validate(
		{
			 ignore: []  ,
			rules: {

						ProjectTitle:{
								required: true,
								},
						
						Projectsdesc:{
								required: true,
							  },
							  
						Projectstatus:{
								required: true,
						
							},
						IsActive:{
								required: true,
						
							},

						},
						messages: {			
					
						}				
		});
});

 
	// CKEDITOR.replace('editor1');
function readURL(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blahlogo').css('display', 'block');
                    $('#blahlogo').attr('src', e.target.result);
                };
             reader.readAsDataURL(input.files[0]);
            }
        }		
        function readURLimg(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blahimg').css('display', 'block');
                    $('#blahimg').attr('src', e.target.result);
                };
             reader.readAsDataURL(input.files[0]);
            }
        }
         function readURLbroch(input) {
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blahbroch').css('display', 'block');
                    $('#blahbroch').attr('src', e.target.result);
                };
             reader.readAsDataURL(input.files[0]);
            }
        }				                

</script>