<div class="blog-search text-right">
  <form method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
    <input name="s" class="form-control" placeholder="<?php esc_attr_e('Enter Keyword','sanas');?>" type="text" value="<?php echo the_search_query(); ?>">
    <button type="submit" class="btn btn-go"><?php esc_html_e('Go','sanas');?></button>
  </form>
</div>