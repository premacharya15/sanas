<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sanas
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Radio+Canada:ital,wght@0,300..700;1,300..700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Playwrite+US+Trad:wght@100..400&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:wght@100..900&family=Jost:ital,wght@0,100..900;1,100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Playwrite+US+Modern:wght@100..400&family=Playwrite+US+Trad:wght@100..400&display=swap');
    </style>
    <?php wp_head(); ?>
</head>
<body <?php if ( is_page_template( 'page-template/myevent.php' ) ) { body_class('inner-page');}else{body_class();} ?>>>
<div class="wl-invitation-header user">
    <div class="container-fluid">
        <div class="inner-container">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-8 w-xsm-6">
                    <button id="header-options" data-redirect="<?php echo esc_url(home_url('/'));?>" class="inner-colum">
                        <div class="wl-header-icon">
                            <i class="fa-solid fa-arrow-left"></i>
                          </div>
                          <?php 
                          if(isset($_GET['card_id']) && !empty($_GET['card_id']))
                          {
                            echo '<h3>'.get_the_title($_GET['card_id']).'</h3>';
                          }
                          else{
                            echo '<h3>Wedding Invitations</h3>';    
                          }
                          ?>                                                      
                    </button>
                </div>
                <div class="col-md-6 col-sm-4 w-xsm-4 text-end">
                    <div class="inner-colum justify-content-end dropdown">
                <?php if(is_user_logged_in()) {
                global $current_user;    
                wp_get_current_user();
                $userID = $current_user->ID;

            global $wp_rewrite;
            if ($wp_rewrite->permalink_structure == '') {
                $perma = "&";
            } else {
                $perma = "/";
            }

            $currentURL = site_url();
            $dashQuery = 'user-dashboard';
            $dashpage = '/?dashboard=';
            $dashboardURL = esc_url($currentURL . $perma . $dashQuery . $dashpage.'main' );
            $myevent = esc_url($currentURL . $perma . $dashQuery . $dashpage.'my-events' );


            $first_char = substr($current_user->user_firstname, 0, 1);

                            ?>                
                            <div class="btn-profile dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
                            	<?php echo ucfirst($first_char); ?>
                            </div>           
                        <img class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" style="display: none;" aria-expanded="true" src="<?php echo  get_template_directory_uri(); ?>/assets/img/login-img.jpg" alt="">

                        <ul class="dropdown-menu p-0" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 42.4px, 0px);">
                            <li><?php echo $current_user->user_login; ?></li>
                            <li><a href="<?php echo site_url().'/my-dashboard/'; ?>"> Dashboard</a></li>
                            <li><a href="<?php echo site_url().'/my-events/'; ?>"> My Events</a></li>
                            <li class="logout-btn"><a href="javascript:void(0);" data-logout-url="<?php echo wp_logout_url(home_url()); ?>">Logout</a></li>
                        </ul>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>    