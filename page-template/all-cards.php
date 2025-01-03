<?php
/**
	Template Name: All Cards Page
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
get_header();

?>
<div class="all-cards">
 <div class="container">
    <?php
    // WP_Query Arguments
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'sanas_card',
        'posts_per_page' => 12, // Customize this for the number of posts per page
        'paged' => $paged,
    );

    if (isset($_GET['s'])) {
        $args['s'] = sanitize_text_field($_GET['s']); // Add search keyword
    }

    if (isset($_GET['sanas-card-category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'sanas-card-category',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['custom_category']),
            ),
        );
    }

    // Custom Query
    $query = new WP_Query($args);

    if ($query->have_posts()) : ?>
        <div class="row">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
 		<?php

            if (get_post_meta(get_the_ID(),'sanas_metabox',true)) {
              $sanas_portfolio_meta = get_post_meta(get_the_ID(),'sanas_metabox',true);
            }
            else {
              $sanas_portfolio_meta = array();
            }

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
                  <div class="card-box col-lg-4 col-md-4 col-sm-6">
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
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'total' => $query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'format' => '?paged=%#%',
                'show_all' => false,
                'prev_text' => '<i class="fa-solid fa-arrow-left-long"></i>'.'Prev',
                'next_text' => 'Next'.'<i class="fa-solid fa-arrow-right-long"></i>',
            ));
            ?>
        </div>

    <?php else : ?>
        <p>No cards found.</p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>	
</div>
</div>
<?php 
get_footer();