<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sanas
 */

get_header();
?>
<section class="blog-section blog-wrapper">
      <div class="container-fluid">
        <div class="sec-title style-two">
          <h2>All Blogs</h2>
        </div>
        <div class="row">
        <?php
		while(have_posts()):
		the_post();?>
          <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="blog-box">
              <div class="image">
                <a href="blog-details.html">
                  <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="sanas">
                </a>
              </div>
              <div class="blog-detaile">
                <a href="<?php the_permalink(); ?>" class="blog-hedding">
                  <h4><?php the_title(); ?></h4>
                  <span class="blog-icon">
                    <i class="icon-Left-Up-Arrwo"></i>
                  </span>
                </a>
                <p><?php the_excerpt(); ?></p>
              </div>
              <div class="blog-poster">
                <?php sanas_author_avatar(); ?>
                <div class="blog-poster-detaile">
                     <h6><?php echo get_the_author();?></h6>
                     <span><?php echo get_the_date(); ?></span>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile;
        sanas_blogs_pagination(); ?>
        </div>
      </div>
    </section>

<?php
get_footer();
