<?php 
/**
    Template Name: User Dashboard Page
    * The template for displaying all pages
    *
    * This is the template that displays all pages by default.
    * Please note that this is the WordPress construct of pages
    * and that other 'pages' on your WordPress site may use a
    * different template.
    *
    * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
    *
    * @package sanas
*/
get_header('dashboard');
// Get current user
if ( is_user_logged_in() ) {
    $current_user = wp_get_current_user();
    // Check if user has Administrator role
    if (in_array('subscriber', $current_user->roles) || in_array('administrator', $current_user->roles)) {
        if (isset($_GET['dashboard']) && !empty($_GET['dashboard'])) {
            get_template_part('template-parts/dashboard/' . sanitize_text_field($_GET['dashboard']));
        } else {
            get_template_part('template-parts/dashboard/cover');
        }
    }
    else {
       echo '<p class="user-not-exist">' . esc_html__('Sorry, you do not have sufficient permissions to access this page!', 'sanas') . '</p>';
    }
} else {
        do_action('sanas_get_login');
?>
<input type="hidden" name="header-options-msg" id="header-options-msg" value="You will lose your invitation progress.Please complete cover card step."/>
<script type="text/javascript">
jQuery(document).ready(function ($) {
var current_url =  window.location.href;    
        $('body').addClass('search-active');
        $('.search-popup').addClass('ajax-value');
        console.log('opened no login');
        $('#ajaxvalue').val('0');        
        $('#signInButton').addClass('d-block');
        $('#signInButton').attr('btn-url', current_url);
});     
</script>
<?php    
   // your code for logged out user 
}
get_footer('dashboard');