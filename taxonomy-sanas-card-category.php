<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package weddlist
 */

get_header(); 
global $post;

$queried_object = get_queried_object();
$t_id = $queried_object->term_id;
$term_name = $queried_object->name;
$term_details = $queried_object->description;

//$card_category_home = get_term_meta($queried_object->term_id, 'card_category_home', true);


?>
<section class="hero-section">
  <div class="container">
    <div class="hero-detaile">
       <div class="row align-items-center h-100"> 
        <div class="col-md-6 xol-sm-12">
          <h2><?php echo $term_name; ?></h2>
          <p><?php echo $term_details; ?></p>
        </div>
      </div>
    </div>
  </div>
 </section>
 <?php
 echo "123";
 ?>
<section class="wedding-section">
 <div class="container">
    <div class="row">
<?php if ( have_posts() ) : ?>

         
        <?php
        // Start the loop
        while ( have_posts() ) : the_post(); 


            $category = get_the_terms( get_the_ID(),'sanas-card-category' );
            $categoryName = $category[0]->name;
            if (get_post_meta(get_the_ID(),'sanas_metabox',true)) {
              $sanas_portfolio_meta = get_post_meta(get_the_ID(),'sanas_metabox',true);
            }
            else {
              $sanas_portfolio_meta = array();
            }

            ?>
             <?php


                $currentURL = site_url();
                $dashQuery = 'user-dashboard';
                $dashpage = '/?dashboard=cover';
                // Determine the correct permalink structure
                global $wp_rewrite;
                if ($wp_rewrite->permalink_structure == '') {
                    $perma = "&";
                } else {
                    $perma = "/";
                }
                // Construct the URL with proper formatting
                $dashboardURL = esc_url($currentURL .$perma. $dashQuery . $dashpage. '&card_id='.get_the_id()  );

                if($sanas_portfolio_meta['sanas_bg_color'])
                {
                    $bg_color='style="background:'.$sanas_portfolio_meta['sanas_bg_color'].'"';
                }
                ?>
                  <div class="card-box col-lg-3 col-md-4 col-sm-6">
                    <div class="inner-box" >
                      <a href="<?php echo $dashboardURL;?>" class="flip-container" <?php echo $bg_color;?>>
                        <div class="flipper">
                          <div class="front">
                            <img src="<?php echo esc_url($sanas_portfolio_meta['sanas_upload_front_Image']['url']) ?>" alt="template">
                          </div>
                          <div class="middel-card">
                            <img src="<?php echo esc_url($sanas_portfolio_meta['sanas_upload_back_Image']['url']) ?>" alt="template">
                          </div>
                          <div class="back">
                            <img src="<?php echo esc_url($sanas_portfolio_meta['sanas_upload_back_Image']['url']) ?>" alt="template">
                          </div>
                        </div>
                      </a>
                      <div class="lower-content">
                        <a href="<?php echo $dashboardURL; ?>" class="card-box-title"><h4><?php echo get_the_title();?></h4></a>
                        <a href="<?php echo $dashboardURL; ?>">Free</a>
                        <div class="hart-icon">
                          <i class="icon-Heart"></i>
                        </div>
                      </div>
                    </div>
                  </div>
        <?php endwhile; ?>
    <!-- Pagination if needed -->
    <?php the_posts_pagination(); ?>
  <?php else : ?>
      <p class="text-center"><?php _e( 'No cards found for this category.' ); ?></p>
  <?php endif; 

  ?>
    </div>
    </div>
</section>
<?php
get_footer();
?>