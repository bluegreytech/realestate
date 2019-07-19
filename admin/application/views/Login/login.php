
 <?php  $this->load->view('common/header'); ?>
  <div class="app-content content container-fluid">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><section class="flexbox-container">
    <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 m-0">
            <div class="card-header no-border">
                <div class="card-title text-xs-center">
                    <div class="p-1"><img src="<?php echo base_url(); ?>default/images/logo/logo.png" alt="branding logo" width="100%"></div>
                </div>
                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Login with Topstarlogistics1</span></h6>
            </div>
           
       
        
            <div class="card-body collapse in">
                <div class="card-block">
                    <form class="form-horizontal form-simple" method="post">
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" name="EmailAddress" class="form-control form-control-lg input-lg" placeholder="Type your Email address">
                            <div class="form-control-position">
                                <i class="icon-head"></i>
                            </div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="password" required name="Password" class="form-control form-control-lg input-lg"  placeholder="Type your password">
                            <div class="form-control-position">
                                <i class="icon-key3"></i>
                            </div>
                        </fieldset>
                        <fieldset class="form-group row">
                            <!-- <div class="col-md-6 col-xs-12 text-xs-center text-md-left">
                                <fieldset>
                                    <input type="checkbox" id="remember-me" class="chk-remember">
                                    <label for="remember-me"> Remember Me</label>
                                </fieldset>
                            </div> -->
                            <div class="col-md-6 col-xs-12 text-xs-center text-md-right"><a href="recover-password.php" class="card-link">Forgot Password?</a></div>
                        </fieldset>
                        <input type="submit" name="logins" class="btn btn-primary btn-lg btn-block" value="Login">
                    </form>
                </div>
            </div>
            <!--div class="card-footer">
                <div class="">
                    <p class="float-sm-left text-xs-center m-0"><a href="recover-password.html" class="card-link">Recover password</a></p>
                    <p class="float-sm-right text-xs-center m-0">New to Robust? <a href="register-simple.html" class="card-link">Sign Up</a></p>
                </div>
            </div-->
        </div>
    </div>
</section>

        </div>
      </div>
    </div>