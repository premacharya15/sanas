<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package sanas
 */

get_header();
?>

	<section class="error-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="img404">
            	<?php if(!empty(sanas_options('sanas_error_banner_image')['url']) && sanas_options('sanas_enable_error_banner_image') == true) :?>
              	<img src="<?php echo esc_url(sanas_options('sanas_error_banner_image')['url']) ?>" alt="404-images">
          		<?php endif; ?>
            </div>
          </div>
          <div class="col-xl-6 col-md-6 col-sm-12">
            <div class="error-msg">
            	<?php if(sanas_options('sanas_enable_error_banner_title') == true) :?>
              <h2><?php echo esc_html(sanas_options('sanas_error_banner_title')); ?></h2>
          <?php endif;
          if(sanas_options('sanas_enable_error_banner_subtitle') == true): ?>
              <p><?php echo wp_kses_post(sanas_options('sanas_error_banner_subtitle')); ?></p>
          <?php endif; 
          if(sanas_options('sanas_enable_error_banner_button') == true):?>
              <a href="<?php echo esc_url(home_url()) ?>" class="btn btn-primary"><?php echo esc_html(sanas_options('sanas_error_banner_button_text')) ?></a>
          <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php
get_footer();
