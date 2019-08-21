<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Nyalkaran  Group</title>
    
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>default/images/ico/favicon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/css/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/css/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/css/colors.css">
    <!-- END ROBUST CSS-->

    <!-- BEGIN DATA TABLE CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/css/jquery.dataTables.min.css">
    <!-- END DATA TABLE CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/css/core/menu/menu-types/vertical-overlay-menu.css">
   <!--  <link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>default/css/pages/login-register.html"> -->
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>default/assets/css/style.css">
    <!-- END Custom CSS-->
     <script src="<?php echo base_url(); ?>default/assets/ckeditor/ckeditor.js" type="text/javascript"></script>
  </head>
 
  <?php
 // echo $this->session->userdata('EmailAddress');
        if(check_admin_authentication()){ 
          // {
          //  echo "gfgf";die;
  ?>
                    <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">
                    <!-- navbar-fixed-top-->
                                    <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
                                    <div class="navbar-wrapper">
                                      <div class="navbar-header">
                                        <ul class="nav navbar-nav">
                                          <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a></li>
                                          <li class="nav-item"><a class="navbar-brand nav-link"><img alt="branding logo" src="<?php echo base_url(); ?>default/images/logo/head-logo.png" data-expand="<?php echo base_url(); ?>default/images/logo/head-logo.png" data-collapse="<?php echo base_url(); ?>default/images/logo/head-logo.png" class="brand-logo" ></a></li>
                                          <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
                                        </ul>
                                      </div>
                                      <div class="navbar-container content container-fluid">
                                        <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                                            <?php $admin_profile=  get_one_admin($this->session->userdata('AdminId')); 
                                           // echo "<pre>";print_r($admin_profile);die;
                                            ?>

                                          <ul class="nav navbar-nav float-xs-right">
                                            <li class="dropdown dropdown-user nav-item">

                                              <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                                              <!--   <span class="avatar avatar-online"><i> -->
                                                 <?php  if(($admin_profile->ProfileImage!='' && file_exists(base_path().'/upload/admin/'.$admin_profile->ProfileImage))){ ?>
                                     
                                                <img src="<?php echo base_url().'upload/admin/'.$admin_profile->ProfileImage; ?>" class="avatar" alt="">
                                                <?php }else{ ?>
                                             <img src="<?php echo base_url().'upload/no_image/user_no_image.png'; ?>" class="avatar" alt=""> 
                                                <?php } ?>
                                           <!--   </i></span> -->
                                              <span class="user-name"><?php echo ucfirst($admin_profile->FullName); ?></span>
                                              </a>
                                               <div class="dropdown-menu dropdown-menu-right">
                                                <a href="<?php echo base_url();?>home/profile" class="dropdown-item"><i class="icon-user"></i> Profile</a>
                                                  <a href="<?php echo base_url();?>home/change_password" class="dropdown-item"><i class="icon-key3"></i> Change Password</a> 
                                                 <a href="<?php echo base_url();?>home/logout" class="dropdown-item"><i class="icon-power3"></i> Logout</a> 
                                              </div>                    
                                             
                                            </li>

                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </nav>
                <?php 
                  }
       ?>         
 
                 

    