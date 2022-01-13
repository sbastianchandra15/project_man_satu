<?php
// test($this->current_user,1);
if($this->current_user['loginuser']==1){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <!-- <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya"> -->
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme"><!-- 
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular."> -->
    <title><?php echo $this->current_user['company_name']; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/font-awesome.min.css">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/select2.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/toastr.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsiveTabbed.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive-tabs.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style-responsive-tabs.css" />
    
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.inputmask.bundle.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js" charset="utf-8"></script>

     <script>
      var baseUrl = '<?php echo base_url(); ?>';
      // var APL = '';
    </script>
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="index.html"><img alt="" width="150px" height="58px" src="<?php echo base_url(); ?>assets/images/<?php echo $this->current_user['logo']; ?>">
      </a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?php echo base_url(); ?>master/users/password"><i class="fa fa-cog fa-lg"></i> Setting User</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url(); ?>logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php 
    $amenu    = array();
    $asubmenu = array();


    foreach ($this->current_user['submenu'] as $key => $value) {
      $asubmenu[$value->menu_group][]=$value;
    }
    ?>
    <aside class="app-sidebar">
      <ul class="app-menu">
        <li><a class="app-menu__item <?php echo $this->session->userdata('ses_menu')['active_menu'] == 'Dashboard' ? 'active' : '' ?>" href="<?php echo base_url(); ?>welcome" ><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <?php 
        foreach ($this->current_user['menu'] as $key => $menu) { 
        ?>
        <li class="treeview <?php echo $this->session->userdata('ses_menu')['active_menu'] == $menu->menu_group ? 'is-expanded' : ''; ?>"><a class="app-menu__item" href="<?php echo $menu->url; ?>" data-toggle="treeview"><i class="app-menu__icon <?php echo $menu->icon; ?>"></i><span class="app-menu__label"><?php echo $menu->menu_group; ?></span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
          <?php
          foreach ($asubmenu[$menu->menu_group] as $key => $submenu) { 
          ?>
            <li><a class="treeview-item <?php echo $submenu->url == $this->session->userdata('ses_menu')['active_submenu'] ? 'active' : '' ?>" href="<?php echo base_url().$submenu->url; ?>"><i class="icon fa fa-circle-o"></i> <?php echo $submenu->menu_name; ?></a></li>
          <?php
          }
          ?>
          </ul>
        </li>
        <?php 
        }
        ?>
        <li><a class="app-menu__item <?php echo $this->session->userdata('ses_menu')['active_submenu'] == 'welcome/information' ? 'active' : '' ?>" href="<?php echo base_url(); ?>welcome/information" ><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">Information</span></a></li>
        <li><a class="app-menu__item <?php echo $this->session->userdata('ses_menu')['active_submenu'] == 'welcome/documentation' ? 'active' : '' ?>" href="<?php echo base_url(); ?>welcome/documentation" ><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">documentation</span></a></li>
      </ul>
    </aside>
    <main class="app-content">
    <?php 
      echo $contents; 
    ?>
    </main>
    <!-- Essential javascripts for application to work-->
    
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?php echo base_url(); ?>assets/js/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-dialog.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/responsiveTabbed.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.responsiveTabs.js"></script>
  </body>
</html>
<?php 
}else{
$this->session->set_flashdata('msg','<div class="alert alert-danger text-center"><font size="2">Harap Login Kembali.</font></div>');
redirect('login');
}
?>