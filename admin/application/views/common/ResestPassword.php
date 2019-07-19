
 <?php $this->load->view('common/css'); ?>
  <div class="app-content content container-fluid">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><section class="flexbox-container">
    <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 m-0">
            <div class="card-header no-border">
                <div class="card-title text-xs-center">
                    <div class="p-1"><img src="<?php echo base_url(); ?>default/images/logo/logo.png" alt="branding logo" width="70%"></div>
                </div>
                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Forgot Password with Topstarlogistics</span></h6>
            </div>
           
            <?php if(($this->session->flashdata('error'))){ ?>
        <div class="alert alert-danger" id="errorMessage">
        <strong> <?php echo $this->session->flashdata('error'); ?></strong> 
        </div>
        <?php } ?>
        
            <div class="card-body collapse in">
                <div class="card-block">
                       <?php $attributes = array('name'=>'frm_reset','id'=>'frm_restpwd','class'=>'reset-form');
                        echo form_open('home/reset_password/'.$code,$attributes); ?>
                    
                        <fieldset class="form-group position-relative has-icon-left">
                        <input type="hidden"   value="<?php echo $AdminId; ?>" name="AdminId">
                            <input type="hidden"   value="<?php echo $code; ?>" name="code">
                            <input type="password" name="Password" class="form-control  " placeholder="Password" id="Password">
                            <div class="form-control-position">
                                <i class="icon-key3"></i>
                                
                            </div>
                             <p id="pwderror"></p>
                        </fieldset>
                         <fieldset class="form-group position-relative has-icon-left">
                            <input type="password" name="Confrim_password" class="form-control  " placeholder="Confrim password">
                             <div class="form-control-position">
                                <i class="icon-key3"></i>
                              
                            </div>
                              <p id="cpwderror"></p>
                        </fieldset>
                      
                        
                        <fieldset class="form-group row">
                            <div class="col-md-4 col-xs-12 text-xs-center text-md-left">
                                <a href="<?php echo base_url(); ?>" name="back"  class="btn btn-grey btn-block"  role="button" >Back</a>
                            </div>
                             <div class="col-md-4 col-xs-12 text-xs-center text-md-left">
                             </div>
                            <div class="col-md-4 col-xs-12 text-xs-center text-md-right">  
                            <input type="submit" name="submit" class="btn btnlogin btn-block" value="Submit"></div>
                        </fieldset>
                    </form>
                </div>
            </div>
          
        </div>
    </div>
</section>

        </div>
      </div>
    </div>

    <?php $this->load->view('common/js'); ?>

    <script>
$(function() { 
    setTimeout(function() {
  $('#errorMessage').fadeOut('fast');
}, 3000);
   
});

 $("#frm_restpwd").validate(
    {
    rules:{       
        Password:{
            required: true,            
        },  
        Confrim_password:{
            required: true,
            equalTo:"#Password",
        },      
       
    },
    // messages:{
    //  EmailAddress:"Email Address is required",
    // },
    errorPlacement: function (error, element) {
            console.log('dd', element.attr("name"))
            if (element.attr("name") == "Password") {
                error.appendTo("#pwderror");
            } else if (element.attr("name") == "Confrim_password") {
                  error.appendTo("#cpwderror");
              
            }else{
                  error.insertAfter(element)
            }
        }
    
});

</script>