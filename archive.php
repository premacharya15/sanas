<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sanas
 */

get_header();
?>
<section class="blog-detaile-section">
  <div class="container">
    <h2><?php echo the_title(); ?></h2>
  </div>
 </section>
  <div class="blog-main-block">
    <div class="container">
      <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 content-left">
          <?php
            while ( have_posts() ) : the_post();
    
                get_template_part( 'template-parts/content', 'page' );
    						
            endwhile; // End of the loop.
            sanas_blogs_pagination();
            ?>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 blog-sidebar">
          	<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
            <?php } ?> 
        </div>
      </div>
    </div>
  </div>
<?php
get_footer();
