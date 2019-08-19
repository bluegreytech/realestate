    <!-- main menu-->
    <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <!--div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round"/>
      </div-->
      <!-- / main menu header-->
      <!-- main menu content-->
      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
           <li class="nav-item">
            <a href="<?php echo base_url(); ?>home/dashboard">
              <i class="icon-dashboard"></i><span data-i18n="nav.dash.main" class="menu-title">Dashboard</span>
            </a>
            
          </li> 
          <?php if($this->session->userdata('AdminId')==1){ ?>
            
        <li class="nav-item">
            <a>
              <i class="icon-user"></i><span data-i18n="nav.dash.main" class="menu-title">Admin</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>Admin/AddAdmin" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i> Add Admin</a>
              </li>
              <li>
              <li>
                <a href="<?php echo base_url(); ?>Admin/Adminlist" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of Admin</a>
              </li>
            </ul>
          </li> 
          <?php } ?>       
          <li class="nav-item">
            <a>
              <i class="icon-tasks"></i><span data-i18n="nav.dash.main" class="menu-title">Project</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>Project/Projectadd" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i> Add projects</a>
              </li>
              <li>
              <li>
                <a href="<?php echo base_url(); ?>Project/Projectlist" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of Projects </a>
              </li>
            </ul>
          </li>

           <li class="nav-item">
            <a>
              <i class="icon-cog"></i><span data-i18n="nav.dash.main" class="menu-title">Project Details</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>project/projectadd" data-i18n="nav.dash.main" class="menu-item"><i class="icon-tasks"></i>Project Specification</a>
                    <ul class="menu-content">
                      <li>
                      <a href="<?php echo base_url(); ?>project/add_specification" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i>Add Project Specification</a>
                      </li>
                      <li>
                      <a href="<?php echo base_url(); ?>project/list_specification" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of Specification </a>
                      </li>
                    </ul>
              </li>
               <li>
                   <a href="<?php echo base_url(); ?>project/list_planlayout" data-i18n="nav.dash.main" class="menu-item"><i class="icon-map-o"></i> Plan & Layouts </a>
                    <ul class="menu-content">
                      <li>
                      <a href="<?php echo base_url(); ?>project/add_planlayout" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i>Add Plan & Layouts</a>
                      </li>
                      <li>
                      <a href="<?php echo base_url(); ?>project/list_planlayout" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of Plan & Layouts </a>
                      </li>
                    </ul>
              </li>
              <li>
                <a href="<?php echo base_url(); ?>project/list_gallery" data-i18n="nav.dash.main" class="menu-item"><i class="icon-image"></i> Project Gallery </a>
                    <ul class="menu-content">
                      <li>
                      <a href="<?php echo base_url(); ?>project/add_gallery" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i>Add Gallery</a>
                      </li>
                      <li>
                      <a href="<?php echo base_url(); ?>project/list_gallery" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of Gallery</a>
                      </li>
                    </ul>
              </li>
               <li>
                <a href="<?php echo base_url(); ?>project/list_projectslider" data-i18n="nav.dash.main" class="menu-item"><i class="icon-image"></i> Project Silder </a>
                    <ul class="menu-content">
                      <li>
                      <a href="<?php echo base_url(); ?>project/add_projectslider" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i>Add project slider</a>
                      </li>
                      <li>
                      <a href="<?php echo base_url(); ?>project/list_projectslider" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of Project slider</a>
                      </li>
                    </ul>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a>
              <i class="icon-users"></i><span data-i18n="nav.dash.main" class="menu-title">Users</span>
            </a>
            <ul class="menu-content">
            <!--   <li>
                <a href="<?php //echo base_url(); ?>User/Useradd" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i> Add User </a>
              </li> -->
              <li>
                <a href="<?php echo base_url(); ?>User/Userlist" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i> List of Users </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a>
              <i class="icon-users"></i><span data-i18n="nav.dash.main" class="menu-title">User Refer </span>
            </a>
            <ul class="menu-content">
            <!--   <li>
                <a href="<?php //echo base_url(); ?>User/Useradd" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i> Add User </a>
              </li> -->
              <li>
                <a href="<?php echo base_url(); ?>User/Userrefer_list" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i> List of User Refer </a>
              </li>
            </ul>
          </li>
           <li class="nav-item">
            <a>
              <i class="icon-bell-o"></i><span data-i18n="nav.dash.main" class="menu-title">Broadcast Notification</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>broadcast/add_broadcast" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i>Add Broadcast</a>
              </li>
              <li>
              <li>
                <a href="<?php echo base_url(); ?>broadcast/broadcastlist" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of Notification</a>
              </li>
            </ul>
          </li>
           <li>
                <a href="<?php echo base_url(); ?>home/add_pages" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file"></i> Page Setting </a>
                    
              </li>
        </ul>
      </div>
      <!-- /main menu content-->
      <!-- main menu footer-->
      <!-- include includes/menu-footer-->
      <!-- main menu footer-->
    </div>
    <!-- / main menu-->