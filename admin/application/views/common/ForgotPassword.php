<body class="main-bg">
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
                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Forgot Password with Nyalkaran</span></h6>
            </div>
           
                
        
            <div class="card-body collapse in">
                <div class="card-block">
                    <?php if(($this->session->flashdata('error'))){ ?>
                <div class="alert alert-danger" id="errorMessage">
                <strong> <?php echo $this->session->flashdata('error'); ?></strong> 
                </div>
                <?php } ?>
                   
                    <form class="form-horizontal form-simple" method="post" action="<?php echo base_url();?>home/forgotpassword" id="frm_forgot">
                          <P  style="font-size:15px;">Enter your e-mail address below to reset your password.</P>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" name="EmailAddress" class="form-control " placeholder="Type your Email address">
                            <div class="form-control-position">
                                <i class="icon-envelop"></i>
                            </div>
                            <p id="emailerror"></p>
                        </fieldset>
                      
                        <fieldset class="form-group row">
                            <div class="col-md-4 col-xs-12 text-xs-center text-md-left">
                              
                                  <a href="<?php echo base_url() ; ?>" name="back"  class="btn btnlogin btn-block"  role="button" style="color:#fff!important" >Back</a>
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
</body>
    <?php $this->load->view('common/js'); ?>

    <script>

    $("#frm_forgot").validate(
    {
    rules:{       
        EmailAddress:{
            required: true,
            email: true
        },       
       
    },
    messages:{
     EmailAddress:"Email Address is required"
    },
    errorPlacement: function (error, element) {
            console.log('dd', element.attr("name"))
            if (element.attr("name") == "EmailAddress") {
                error.appendTo("#emailerror");
            } else {
                error.insertAfter(element)
            }
        }
    
});
$(function() { 
    setTimeout(function() {
  $('#errorMessage').fadeOut('fast');
}, 3000);
   
});

</script>