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
              <i class="icon-users"></i><span data-i18n="nav.dash.main" class="menu-title">Users</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>User/Useradd" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i> Add User </a>
              </li>
              <li>
                <a href="<?php echo base_url(); ?>User/Userlist" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i> List of Users </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- /main menu content-->
      <!-- main menu footer-->
      <!-- include includes/menu-footer-->
      <!-- main menu footer-->
    </div>
    <!-- / main menu-->