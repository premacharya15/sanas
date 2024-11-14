<?php
/**
	Template Name: Full Width Page
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
$padding_class = '';
if (!class_exists('CSF')) {
	$padding_class = ' section-padding--top container-fluid';
}
while (have_posts()):
	the_post();
?>
<div class="full-width-content<?php echo esc_attr($padding_class) ?>" id="post-<?php the_ID() ?>">
	<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links inner-post-pagination">' . esc_html__( 'Pages:', 'sanas' ),
				'after'  => '</div>',
			)
		);
	?>
</div>
<?php
endwhile;
get_footer();