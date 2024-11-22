<?php 
/*
*Theme Css and js file
*/
if ( !function_exists( 'sanas_google_fonts_url' ) ) {
    function sanas_google_fonts_url() {
        $sanas_fonts_url = '';
        $sanas_fonts     = array('Mulish','sans-serif','Faculty Glyphic');
        $sanas_subsets   = 'latin,latin-ext';
        /* translators: If there are characters in your language that are not supported by Inter, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Manrope font: on or off', 'sanas')) {
            $sanas_fonts[] = 'Manrope:100,200,300,400,500,600,700,800,900|Faculty Glyphic:400,500,600,700';
        }
        if ($sanas_fonts) {
            $sanas_fonts_url = add_query_arg(array(
            'family' => urlencode(implode('|', $sanas_fonts)),
            'subset' => urlencode($sanas_subsets),
            ), '//fonts.googleapis.com/css');
        }
        return esc_url_raw($sanas_fonts_url);
    }
}


function sanas_css()
{

  wp_enqueue_style('sanas-fonts', sanas_google_fonts_url(), array());
  wp_enqueue_style('select2', get_template_directory_uri() . '/assets/css/select2.min.css', array(), SANAS_VERSION);
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), '5.3.3');
  wp_enqueue_style('sanas-icon', get_template_directory_uri() . '/assets/icomoon/style.css', array(), SANAS_VERSION);
  wp_enqueue_style('sanas-font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/all.min.css', array(), SANAS_VERSION);
  wp_enqueue_style('slick', get_template_directory_uri() . '/assets/slick/slick.css', array(), SANAS_VERSION);


  if(is_page_template('page-template/user-dashboard.php'))
  {
     if ( $_GET['dashboard'] == 'preview') {
           wp_enqueue_style('preview-style', get_template_directory_uri() . '/assets/css/preview.css', array(), SANAS_VERSION);     
     }
    if ( $_GET['dashboard'] == 'guestlist') {
        wp_enqueue_style('datatables', get_template_directory_uri() . '/assets/css/datatables.min.css', array(), SANAS_VERSION);
    }        
  }
  if(is_page_template('page-template/todolist.php') ||
  is_page_template('page-template/my-vendors.php') ||
  is_page_template('page-template/vendor-list.php') ||
  is_page_template('page-template/mycontact.php') ||
  is_page_template('page-template/my-dashboard.php') ||
  is_page_template('page-template/budget.php')){
    wp_enqueue_style('datatables', get_template_directory_uri() . '/assets/css/datatables.min.css', array(), SANAS_VERSION);
  }
  if(is_page_template('page-template/guest-preview.php'))
  {
    wp_enqueue_style('preview-style', get_template_directory_uri() . '/assets/css/preview.css', array(), SANAS_VERSION);     
  }
  wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/css/style.css', array(), SANAS_VERSION);
  wp_enqueue_style('theme-secondary-style', get_template_directory_uri() . '/assets/css/style2.css', array(), SANAS_VERSION);
  wp_enqueue_style('theme-responsive-style', get_template_directory_uri() . '/assets/css/responsive.css', array(), SANAS_VERSION);

}
add_action('wp_enqueue_scripts', 'sanas_css');	



function sanas_js()
{

  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.bundle.min.js',array(),'5.2.2',true);
  wp_enqueue_script('select2', get_template_directory_uri() . '/assets/js/select2.min.js', array('jquery'), SANAS_VERSION,true);  
  wp_enqueue_script('fabric-js', 'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js', array(), '4.5.0', true);
  wp_enqueue_script('font-js', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js', array(), '4.5.0', true);
  wp_enqueue_script('webfont-js', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', array(), '4.5.0', true); 

  wp_enqueue_script('slick', get_template_directory_uri() . '/assets/slick/slick.min.js', array('jquery'), SANAS_VERSION,true);  

  if(is_page_template('page-template/user-dashboard.php'))
  {
     if ( $_GET['dashboard'] == 'cover') {
         wp_enqueue_script('fronted-canvas', get_template_directory_uri() . '/assets/js/forntend-canvas-editor.js', array('jquery'), SANAS_VERSION,true);
      }
      else if ( $_GET['dashboard'] == 'details') {
         wp_enqueue_script('fronted-canvas', get_template_directory_uri() . '/assets/js/forntend-back-canvas-editor.js', array('jquery'), SANAS_VERSION,true);
      }
    else if ( $_GET['dashboard'] == 'rsvp') {
         wp_enqueue_script('video-upload-script', get_template_directory_uri() . '/assets/js/video-upload.js', array('jquery'), SANAS_VERSION,true);
        // Localize the script with the videoUpload object
        wp_localize_script('video-upload-script', 'videoUpload', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('video-upload-nonce') // Adjust nonce name as per your implementation
        ));
      }
    else if($_GET['dashboard']== 'guestlist') {
          wp_enqueue_script('datatables', get_template_directory_uri() . '/assets/js/datatables.min.js', array('jquery'), SANAS_VERSION,true);
    }
  }  
  if(is_page_template('page-template/todolist.php') ||
  is_page_template('page-template/my-vendors.php') ||
  is_page_template('page-template/vendor-list.php') ||
  is_page_template('page-template/mycontact.php') ||
  is_page_template('page-template/my-dashboard.php') ||
  is_page_template('page-template/budget.php')){
    wp_enqueue_script('datatables', get_template_directory_uri() . '/assets/js/datatables.min.js', array('jquery'), SANAS_VERSION,true);
  }
  wp_enqueue_script('sanas-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), SANAS_VERSION,true);
  wp_enqueue_script('sanas-customs-2', get_template_directory_uri() . '/assets/js/custom-2.js', array('jquery'), SANAS_VERSION,true);

}
add_action('wp_enqueue_scripts', 'sanas_js');  	


function sanas_ajax_load_enqueue_scripts() {
    //wp_enqueue_script('jquery'); // Ensure jQuery is loaded
    wp_enqueue_script('sanas-login', get_template_directory_uri() . '/assets/js/login.js', array('jquery'), SANAS_VERSION, true);
    wp_localize_script('sanas-login', 'ajax_login_object', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'sanas_ajax_load_enqueue_scripts');
?>