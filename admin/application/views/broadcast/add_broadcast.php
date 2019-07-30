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
					<?php if($broadcastid==1)
					{
						echo	"Edit Broadcast";
					}
					else{
					echo	"Add Broadcast";
					}
					?>
					<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
					<a href="<?php echo base_url();?>broadcast/broadcastlist/" class="btn btn-black" style="float:right">Back to Broadcast List</a>
				</div>
				</h4>
				<div class="card-body collapse in">
					<div class="card-block">
				
						<form class="form" method="post" enctype="multipart/form-data" id="frm_project" action="<?php echo base_url();?>broadcast/add_broadcast">
					
							<div class="form-body">
								<h4 class="form-section"><i class="icon-clipboard4"></i> Requirements</h4>
							
								<div class="form-group">
								<input type="hidden" value="<?php echo $broadcastid; ?>" name="broadcastid">
									<label>Broadcast Title</label>
									<input type="text" class="form-control" placeholder="Broadcast Title" name="broadcastitle" value="<?php echo $broadcastitle;?>" minlength="5" maxlength="200">
								</div>
								<div class="form-group">
									<label>Broadcast  Description</label>
									<textarea type="text" class="form-control" placeholder="Project Short Description" name="broadcastdesc" rows="5" ><?php echo $broadcastdesc; ?></textarea>
								</div>
							
							

								<div class="form-group">
									<label>Broadcast Image</label>
									<p><span class="btn btn-black btn-file">
									<input type="hidden" name="pre_broadcast_image" value="<?php echo $broadcastimage;?>">
									Upload broadcast image <input type="file" name="BroadcastImage" id="BroadcastImage" onchange="readURLimg(this);">
									</span></p>									
									<span id="profileerrorimg"></span>
								</div>
								<div class="preview">									
									<?php if($broadcastimage){ ?>
									<img id="blahimg" src="<?php echo base_url()?>upload/broadcastimage/<?php echo $broadcastimage ;?>" class="img-thumbnail border-0" style="display: block;  width: 100px; height: 100px;">
									<?php } else{?>
									<img id="blahimg" src="" class="img-thumbnail border-0" style="display: none;  width: 100px; height: 100px;">
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
												 class="custom-control-input">															
												 <span class="custom-control-indicator">
												 </span>
												 <span class="custom-control-description ml-0">Active</span>
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
									 <button class="btn btn-black " type="submit"><i class="icon-ok"></i> <?php echo ($broadcastid!='')?'Update':'Submit' ?></button>
							
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

						broadcastitle:{
								required: true,
								},
						
						broadcastdesc:{
								required: true,
							  },
							  
						Projectstatus:{
								required: true,
						
							},
						BroadcastImage:{
							extension:'jpeg|png|jpg',
							filesize : 2000000,	
						}
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