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
              <i class="icon-blogger"></i><span data-i18n="nav.dash.main" class="menu-title">Admin</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>Adminuser/Adminadd" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i> Add Admin</a>
              </li>
              <li>
              <li>
                <a href="<?php echo base_url(); ?>Adminuser/Adminlist" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of admin</a>
              </li>
            </ul>
          </li>        
          <li class="nav-item">
            <a>
              <i class="icon-blogger"></i><span data-i18n="nav.dash.main" class="menu-title">Projects</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>Program/Programadd" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i> Add projects</a>
              </li>
              <li>
              <li>
                <a href="<?php echo base_url(); ?>Program/Programlist" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i>List of Projects </a>
              </li>
            </ul>
          </li>
       
        
          <li class="nav-item">
            <a>
              <i class="icon-blogger"></i><span data-i18n="nav.dash.main" class="menu-title">Users</span>
            </a>
            <ul class="menu-content">
              <li>
                <a href="<?php echo base_url(); ?>Userrole/Userroleadd" data-i18n="nav.dash.main" class="menu-item"><i class="icon-plus"></i> Add User </a>
              </li>
              <li>
                <a href="<?php echo base_url(); ?>Userrole/Userrolelist" data-i18n="nav.dash.main" class="menu-item"><i class="icon-file-text2"></i> List of Users </a>
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