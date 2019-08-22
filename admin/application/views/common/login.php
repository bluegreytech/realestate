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
                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Login with Nyalkaran</span></h6>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                      <?php if(($this->session->flashdata('error'))){ ?>
            <div class="alert alert-danger" id="errorMessage">
                 <strong> <?php echo $this->session->flashdata('error'); ?></strong> 
            </div>
        <?php } ?>
              <?php if(($this->session->flashdata('success'))){ ?>
            <div class="alert alert-success" id="successMessage">
            <strong> <?php echo $this->session->flashdata('success'); ?></strong> 
            </div>
        <?php } ?>
                    <form class="form-horizontal form-simple" method="post"  href="<?php echo base_url()?>/home/login" id="frm_login">
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" name="EmailAddress" class="form-control " placeholder="Type your Email address">
                            <div class="form-control-position">
                                <i class="icon-head"></i>
                                <p id="emailerror"></p>
                            </div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="password"  name="Password" class="form-control "  placeholder="Type your password">
                            <div class="form-control-position">
                                <i class="icon-key3"></i>
                                  <p id="pwderror"></p>
                            </div>
                        </fieldset>
                       
                        <input type="submit" name="logins" class="btn btnlogin btn-lg btn-block" value="LOGIN">
                    </form>
                </div>
            </div>
            <div class="card-footer">
                    <p class="text-center m-0" ><a href="<?php echo base_url();?>home/forgotpassword/" class="card-link">Forgot Password?</a></p>
                  
          
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
$(function() { 
    setTimeout(function() {
  $('#errorMessage').fadeOut('fast');
}, 3000);
   
});
$(function() { 
    setTimeout(function() {
  $('#successMessage').fadeOut('fast');
}, 3000);
   
});
//alert();
   $("#frm_login").validate(
    {
    rules:{       
        EmailAddress:{
            required: true,
            email: true
        },
        Password:{
            required: true,         
        },
      
       
    },
    errorPlacement: function (error, element) {

         console.log('dd', element.attr("name"))
            if (element.attr("name") == "remember_me") {
                error.appendTo("#remerror");
            } else {
                error.insertAfter(element)
            }
        }
    
});

</script>