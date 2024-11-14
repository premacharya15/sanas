<?php
  if (!function_exists('wp_sanas_includes_file')) {
      function wp_sanas_includes_file() {
		require get_template_directory() . '/inc/sanas-functions.php';
		require get_template_directory() . '/inc/help-functions.php';

		require get_template_directory() . '/inc/css-js.php';
		require get_template_directory() . '/template-parts/header/header-one.php';
		require get_template_directory() . '/template-parts/footer/footer-one.php';
		//Load All CodeStar File
		if(class_exists('CSF')){
   	   require_once get_template_directory() . '/inc/cs-framework/theme-options.php';
   	   require_once get_template_directory() . '/inc/cs-framework/meta-options.php';

    }
}
}
add_action('sanas_includes_file','wp_sanas_includes_file');
  