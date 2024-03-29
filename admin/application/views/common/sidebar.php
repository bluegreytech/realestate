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
            <a href="<?php echo base_url(); ?>home/dashboard"  class="<?php echo ($activeTab == "dashboard") ? "active" : ""; ?>">
              <i class="icon-dashboard"></i><span data-i18n="nav.dash.main" class="menu-title">Dashboard</span>
            </a>
            
          </li> 
          <?php if($this->session->userdata('AdminId')==1){ ?>
            
        <li class="nav-item <?php echo ($activeTab == "AddAdmin"|| $activeTab == "Adminlist") ? "open" : ""; ?>">
            <a class="<?php echo ($activeTab == "AddAdmin" || $activeTab == "Adminlist") ? "active" : ""; ?>">
              <i class="icon-user"></i><span data-i18n="nav.dash.main" class="menu-title">Admin</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>Admin/AddAdmin" data-i18n="nav.dash.main" class="menu-item  <?php echo ($activeTab == "AddAdmin") ? "active" : ""; ?>" ><i class="icon-plus"></i> Add Admin</a>
              </li>
              <li>
              <li>
                <a href="<?php echo base_url(); ?>Admin/Adminlist" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "Adminlist") ? "active" : ""; ?>"><i class="icon-file-text2"></i>List of Admin</a>
              </li>
            </ul>
          </li> 
          <?php } ?>       
          <li class="nav-item <?php echo($activeTab == "Projectadd"||$activeTab =="Projectlist") ? "open" : ""; ?>">
            <a class="<?php echo ($activeTab == "Projectadd" || $activeTab == "Projectlist") ? "active" : ""; ?>">
              <i class="icon-tasks"></i><span data-i18n="nav.dash.main" class="menu-title">Project</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>Project/Projectadd" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "Projectadd") ? "active" : ""; ?>"><i class="icon-plus"></i> Add projects</a>
              </li>
              <li>
              <li>
                <a href="<?php echo base_url(); ?>Project/Projectlist" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "Projectlist") ? "active" : ""; ?>"><i class="icon-file-text2"></i>List of Projects </a>
              </li>
            </ul>
          </li>
          <li class="nav-item <?php echo($activeTab =="add_specification"||$activeTab =="list_specification"||$activeTab =="list_planlayout"||$activeTab =="add_planlayout"||$activeTab =="add_gallery"||$activeTab =="list_gallery"||$activeTab =="add_projectslider"||$activeTab =="list_projectslider") ? "open" : ""; ?>">
            <a>
              <i class="icon-cog"></i><span data-i18n="nav.dash.main" class="menu-title">Project Details</span>
            </a>
            <ul class="menu-content">
              <li class="<?php echo ($activeTab == "add_specification"|| $activeTab =="list_specification") ? "open" : ""; ?>">
                <a  data-i18n="nav.dash.main" class="menu-item  <?php echo ($activeTab == "add_specification"|| $activeTab =="list_specification") ? "active" : ""; ?> "><i class="icon-tasks"></i>Project Specification</a>
                    <ul class="menu-content">
                      <li>
                      <a href="<?php echo base_url(); ?>project/add_specification" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "add_specification") ? "active" : ""; ?>"><i class="icon-plus"></i>Add Project Specification</a>
                      </li>
                      <li>
                      <a href="<?php echo base_url(); ?>project/list_specification" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "list_specification") ? "active" : ""; ?>"><i class="icon-file-text2"></i>List of Specification </a>
                      </li>
                    </ul>
              </li>
               <li class="<?php echo ($activeTab == "list_planlayout"|| $activeTab =="add_planlayout") ? "open" : ""; ?>">
                   <a href="<?php echo base_url(); ?>project/list_planlayout" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "list_planlayout"||$activeTab =="add_planlayout") ? "active" : ""; ?>"><i class="icon-map-o"></i> Plan & Layouts </a>
                    <ul class="menu-content">
                      <li>
                      <a href="<?php echo base_url(); ?>project/add_planlayout" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "add_planlayout") ? "active" : ""; ?>"><i class="icon-plus"></i>Add Plan & Layouts</a>
                      </li>
                      <li>
                      <a href="<?php echo base_url(); ?>project/list_planlayout" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "list_planlayout") ? "active" : ""; ?>"><i class="icon-file-text2"></i>List of Plan & Layouts </a>
                      </li>
                    </ul>
              </li>
              <li class="<?php echo ($activeTab == "list_gallery"|| $activeTab =="add_gallery") ? "open" : ""; ?>">
                <a href="<?php echo base_url(); ?>project/list_gallery" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "list_gallery"||$activeTab =="add_gallery") ? "active" : ""; ?>"><i class="icon-image"></i> Project Gallery </a>
                    <ul class="menu-content">
                      <li  >
                      <a href="<?php echo base_url(); ?>project/add_gallery" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "add_gallery") ? "active" : ""; ?>"><i class="icon-plus"></i>Add Gallery</a>
                      </li>
                      <li>
                      <a href="<?php echo base_url(); ?>project/list_gallery" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "list_gallery") ? "active" : ""; ?>"><i class="icon-file-text2"></i>List of Gallery</a>
                      </li>
                    </ul>
              </li>
               <li class="<?php echo ($activeTab == "list_projectslider"|| $activeTab =="add_projectslider") ? "open" : ""; ?>">
                <a href="<?php echo base_url(); ?>project/list_projectslider" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "list_projectslider"||$activeTab =="add_projectslider") ? "active" : ""; ?>"><i class="icon-image"></i> Project Silder </a>
                    <ul class="menu-content">
                      <li>
                      <a href="<?php echo base_url(); ?>project/add_projectslider" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "add_projectslider") ? "active" : ""; ?>"><i class="icon-plus"></i>Add project slider</a>
                      </li>
                      <li>
                      <a href="<?php echo base_url(); ?>project/list_projectslider" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "list_projectslider") ? "active" : ""; ?>"><i class="icon-file-text2"></i>List of Project slider</a>
                      </li>
                    </ul>
              </li>
            </ul>
          </li>
          <li class="nav-item <?php echo($activeTab == "Userlist") ? "open" : ""; ?>">
            <a>
              <i class="icon-users"></i><span data-i18n="nav.dash.main" class="menu-title">Users</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>User/Userlist" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "Userlist") ? "active" : ""; ?> "><i class="icon-file-text2"></i> List of Users </a>
              </li>
            </ul>
          </li>
          <li class="nav-item <?php echo($activeTab == "Userrefer_list") ? "open" : ""; ?>">
            <a>
              <i class="icon-users"></i><span data-i18n="nav.dash.main" class="menu-title">User Refer </span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>User/Userrefer_list" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "Userrefer_list") ? "active" : ""; ?>"><i class="icon-file-text2"></i> List of User Refer </a>
              </li>
            </ul>
          </li>
          <li class="nav-item <?php echo($activeTab == "add_broadcast"|| $activeTab == "broadcastlist") ? "open" : ""; ?>">
            <a>
              <i class="icon-bell-o"></i><span data-i18n="nav.dash.main" class="menu-title">Broadcast Notification</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>broadcast/add_broadcast" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "add_broadcast") ? "active" : ""; ?>"><i class="icon-plus"></i>Add Broadcast</a>
              </li>
              <li>
              <li>
                <a href="<?php echo base_url(); ?>broadcast/broadcastlist" data-i18n="nav.dash.main" class="menu-item <?php echo ($activeTab == "broadcastlist") ? "active" : ""; ?>"><i class="icon-file-text2"></i>List of Notification</a>
              </li>
            </ul>
          </li>
          
            <li class="nav-item <?php echo($activeTab == "add_pages") ? "open" : ""; ?>">
            <a href="<?php echo base_url(); ?>home/add_pages">
              <i class="icon-file"></i><span data-i18n="nav.dash.main" class="menu-title"> Page Setting</span>
            </a>
            
          </li> 
        </ul>
      </div>
      <!-- /main menu content-->
      <!-- main menu footer-->
      <!-- include includes/menu-footer-->
      <!-- main menu footer-->
    </div>
    <!-- / main menu-->