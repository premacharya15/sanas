<?php
if (!function_exists('sanas_header_function')) {

function sanas_header_function() {

$loginEnable  = sanas_options('sanas_header_login_button_enable');
$loginText    = sanas_options('sanas_header_login_button_text');

$class_fixed = 'wl-header';
if(is_page_template( 'page-template/myevent.php')
|| is_page_template( 'page-template/wishlist.php')
|| is_page_template( 'page-template/todolist.php')
|| is_page_template( 'page-template/my-vendors.php')
|| is_page_template( 'page-template/vendor-list.php')
|| is_page_template( 'page-template/mycontact.php')
|| is_page_template( 'page-template/my-profile.php')
|| is_page_template( 'page-template/my-dashboard.php')
|| is_page_template( 'page-template/budget.php')
) {
  $class_fixed = 'position-fixed';
}

global $current_user;    

wp_get_current_user();
$userID = $current_user->ID;

$first_char = substr($current_user->user_firstname, 0, 1);
?>
  <header class="main-header <?php echo esc_attr($class_fixed);?>">
    <div class="container">
      <div class="header-top">
        <div class="row align-items-center">
          <?php do_action('sanas_header_logo');?>
          <div class="col d-flex align-items-center justify-content-end gap-3">
          <?php if (is_user_logged_in()) { 
               $logout_url = wp_logout_url(home_url());
            ?>
            <div class="user">
              <div class="inner-colum justify-content-end dropdown">
                  <div class="btn-profile dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
                      <?php
                      $profile_picture = get_user_meta($userID, 'profile_picture', true);
                      if (!empty($profile_picture)) {
                          echo '<img class="user-profile-image" src="' . esc_url($profile_picture) . '" alt="Profile Picture">';
                      } else {
                          echo ucfirst($first_char);
                      }
                      ?>
                  </div>                
                <img class="btn btn-secondary dropdown-toggle" style="display:none;" data-bs-toggle="dropdown" aria-expanded="false"
                  src="<?php echo get_template_directory_uri(); ?>/assets/img/login-img.jpg" alt="login-person">
                <ul class="dropdown-menu p-0">
                  <li class="profile-name-user" style="text-transform: capitalize;"><a href="<?php echo home_url(); ?>/my-profile"><?php echo $current_user->user_firstname; ?></a></li>
                  <li><a href="<?php echo home_url(); ?>/my-dashboard">Dashboard</a></li>
                  <li><a href="<?php echo home_url(); ?>/my-events"> My Events</a></li>
                  <li class="logout-btn">
                    <a href="javascript:void(0);" class="logout-link" data-logout-url="<?php echo $logout_url; ?>">Logout</a>
                  </li>
                </ul>
              </div>
            </div>
           <?php } else {                         
                        
                  //if ($loginEnable && !empty($loginText)) 
                  //{
                  ?>
                  <div class="main-menu-btn text-end">
                    <a href="#" class="btn btn-primary login-in sanas-login-popup">Sign In / Sign Up</a>
                  </div>
            <?php //} 
              }
             ?>
          </div>
          <div class="col text-end">
            <div class="header-right-end">
              <span class="line-1"></span>
              <span class="line-2"></span>
              <span class="line-3"></span>
            </div>
          </div>
        </div>
      </div>
      <nav class="main-menu">
            <?php
                if (has_nav_menu( 'sanas-main-menu' )) {
                  wp_nav_menu( array(
                  'theme_location' => 'sanas-main-menu',
                  'container' => 'ul',
                  'menu_class' => 'main-menu-list', ));
                }
                else {
                   echo '<div class="no-main-menu"><ul class="not no-menu text-right"><li><a  href="' . esc_url( home_url( '/' ) ) . 'wp-admin/nav-menus.php">' . 
                   esc_html__( 'Set Primary Menu.', 'sanas' ) . '</a></li></ul></div>';
                }
            ?>
<?php  /* ?>
          <li class="menu-item-children"><a href="https://www.sanashub.com/" target="_blank">Desi Vendors</a></li>
<?php */ ?>
      </nav>
    </div>
  </header>
<?php } }
add_action('sanas_header','sanas_header_function');

