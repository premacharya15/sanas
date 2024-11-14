<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package sanas
 */

get_header();
?>
<section class="blog-detaile-section">
  <div class="container">
    <h2><?php printf( esc_html__( 'Search Results for: %s', 'hiredots' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
  </div>
 </section>
<div class="blog-main-block">
<div class="container">
<div class="row">
<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 content-left">
  	<?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            /*
             * Include the Post-Type-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
             */
            get_template_part('template-parts/content', 'search');
        endwhile;
        else :
            get_template_part( 'template-parts/content', 'none' );
    endif;
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
