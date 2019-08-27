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
			<div class="col-md-4">
				<div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="media">
                                <div class="media-body text-xs-left">
                                    <h3 class="pink"><?php  echo $referral_point; ?></h3>
                                    <span>Referral Points</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-trophy pink font-large-2 float-xs-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	
			</div>
			<div class="col-md-4">
				<div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="media">
                                <div class="media-body text-xs-left">
                                    <h3 class="pink"><?php  echo $closing_point; ?></h3>
                                    <span>Closing Points</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-trophy pink font-large-2 float-xs-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	
			</div>
			<div class="col-md-4">
				<div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <div class="media">
                                <div class="media-body text-xs-left">
                                    <h3 class="pink"><?php echo  $redeem_point; ?></h3>
                                    <span>Redeem Points</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-trophy pink font-large-2 float-xs-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>


		<div class="col-md-12">

			
			<div class="card">
				<div class="card-header">
					
					<div class="card-body collapse in">
						<div class="card-block">
							<div class="from-group" id="commentsbox">
								<label for="comments">Enter Your Comment</label>
								<textarea name="comments" id="comments" class="form-control" ></textarea>
							</div>&nbsp;
							<div class="from-group">
							    <a href="javascript:void(0)" class="btn btn-black" style="float:center"  onclick="redeemdata('<?php echo $UsersId; ?>')" data-toggle="tooltip" title="Add Redeem Points"  id="btnredeem">Redeem points</a>
							    </div>

							    <p class="msg" id="msg">There are no referral points</p >

							    <a href="javascript:void(0)" class="btn btn-black" style="float:center"  onclick="donedata('<?php echo $UsersId; ?>')" data-toggle="tooltip" title="Done" id="btndone">Done</a>
						
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">

			
			<div class="card">
				  <div class="card-header">
                <h4 class="card-title">List of Points
                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
               <!--  <a href="<?php //echo base_url();?>User/Useradd/" class="btn btn-black" style="float:right">Add User</a> -->
                </h4>
            </div>
            <div class="card-body collapse in">
                <div class="table-responsive">
                    <table id="example" class="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Sr No</th>
                                <th>Comment</th>
                                <th>Points</th>
                                <th>Type of points</th>
								
                            </tr>
                        </thead>
						<tbody>
                        <?php
                                $i=1;
                                if($result){                             
                                foreach($result as $row)
                                {
                            ?>
                            <tr>
                            
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->comment; ?></td>
                                    <td><?php echo $row->redeem_point; ?></td>
                                    <td><?php echo $row->redeem_type; ?></td>
                                 
                                  
                                </tr>      
                                <?php
                                $i++;
                                    } }
                                ?>           
                        </tbody>

                    </table>
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
	closing_point='<?php echo $closing_point; ?>';
	referral_point='<?php echo $referral_point; ?>';
	redeem_point='<?php echo $redeem_point; ?>';
//alert(referral_point);
$("#btnredeem").hide();
$("#commentsbox").hide();
if(closing_point!='' && closing_point!='0' || referral_point!="" && referral_point!='0' ){
	
	$("#btnredeem").show();
	$("#commentsbox").show();
	
	$("#btndone").hide();
	$("#msg").hide();
}else if(redeem_point!='' && redeem_point!='0'){
	$("#btndone").show();
	$("#msg").hide();
	$("#commentsbox").show();
}else{
	$("#msg").show();
	$("#btndone").hide();
}


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

function redeemdata(id){  
	//alert(id);
	comments=$('#comments').val();
	//alert(comments);
	//return false;
	closing_point='<?php echo $closing_point; ?>';
	referral_point='<?php echo $referral_point; ?>';
           
                url="<?php echo base_url();?>"
                $.ajax({
                url: url+"/user/redeem_pointsdata/",
                type: "post",
                data: {id:id,closing_point:closing_point,referral_point:referral_point,comments:comments} ,
                success: function (response){  
               		console.log(response);           
                	document.location.href = url+'user/loyalty_point/'+id;                  

            },
            error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
            }
            })
           

       // });
    
   

}

function donedata(id){  
		//alert(redeem_point);
		comments=$('#comments').val();
		//alert(comments);

                url="<?php echo base_url();?>"
                $.ajax({
                url: url+"/user/done_pointsdata/",
                type: "post",
                data: {id:id,redeem_point:redeem_point,comments:comments} ,
                success: function (response){  
               		console.log(response);    
               		//return false;       
                	document.location.href = url+'user/loyalty_point/'+id;                  

            },
            error: function(jqXHR, textStatus, errorThrown) {
                 console.log(textStatus, errorThrown);
            }
            })
           

       // });
    
   

}		                

</script>