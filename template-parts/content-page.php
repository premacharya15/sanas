<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sanas
 */

?>

<div class="blog-block">
    <div class="status-publish">
      <div class="blog-img">
        <div class="blog-img">
        <?php if(has_post_thumbnail()): ?>
          <a href="#">
            <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php bloginfo(); ?>">
          </a>
      	<?php endif; ?>
        </div>
      </div>
      <div class="blog-dtl">
      	<h3 class="blog-heading"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
        <ul class="meta-tags blog-underline ps-0 m-0">
          <?php sanas_posted_on(); ?>
          <?php sanas_comment(); ?>
        </ul>
        <div class="entry-content">
          <p><?php the_excerpt(); ?></p>
        </div>
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary">Read More</a>
      </div>
    </div>
</div>