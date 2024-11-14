<?php
/**
 * Template part for displaying posts
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
        <ul class="meta-tags blog-underline ps-0 m-0">
          <?php sanas_posted_on(); ?>
          <?php sanas_comment(); ?>
        </ul>
        <div class="entry-content">
          <p><?php the_content(); ?></p>
        </div>
      </div>
    </div>
   <?php 
if(has_tag() || function_exists('sanas_code_social_share_post')) {
?>
<div class="blog-dtl-social">
    <div class="row">
        <div class="col-12 text-end">
		<?php
        if (function_exists('sanas_code_social_share_post')) {
            sanas_code_social_share_post();
        }
        ?>
  		</div>
    </div>
</div>   
<?php 
}
?>
</div>