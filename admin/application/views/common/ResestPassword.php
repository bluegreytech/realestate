
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
                    <div class="p-1"><img src="<?php echo base_url(); ?>default/images/logo/logo-blue.png" alt="branding logo" width="100%"></div>
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
                    <form   method="post" class="form-horizontal" action="<?php echo base_url();?>home/resetpassword">
                        <fieldset class="form-group position-relative has-icon-left">
                        <input type="text"   value="<?php echo $AdminId; ?>" name="AdminId">
                            <input type="text"   value="<?php echo $code; ?>" name="code">
                            <input type="text" name="Password" class="form-control form-control-lg input-lg" placeholder="Type your password">
                            <div class="form-control-position">
                                <i class="icon-head"></i>
                            </div>
                        </fieldset>
                      
                        <input type="submit" name="add" class="btn btn-primary btn-lg btn-block" value="Login">
                    </form>
                </div>
            </div>
            <div class="card-footer">
                <div class="">
                    <p class="float-sm-left text-xs-center m-0"><a href="<?php echo base_url();?>Login" class="card-link">Back to Login</a></p>
                    <p class="float-sm-right text-xs-center m-0">New to Register? <a href="register-simple.html" class="card-link">Sign Up</a></p>
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

</script>