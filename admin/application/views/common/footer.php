<?php
          // if($this->session->userdata('EmailAddress'))
          // {
  ?>
  <footer class="footer footer-static footer-light navbar-border" style="position: fixed;bottom: 0;width: 100%;">
      <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright  &copy; <?php echo date('Y');?> <a href="https://bluegreytech.com/" target="_blank" class="text-bold-800 grey darken-2">  Bluegrey Technologies  </a>, All rights reserved. </span>
        <!--span class="float-md-right d-xs-block d-md-inline-block">Hand-crafted & Made with <i class="icon-heart5 pink"></i></span--></p>
    </footer>
<?php
  //}
?>
    <!-- BEGIN VENDOR JS-->
  <?php  $this->load->view('common/js');?>


<SCRIPT>
    $(document).ready(function() {
    $('#example').DataTable( {
       
    } );
} );
</SCRIPT>