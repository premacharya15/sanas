<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sanas
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php
	$is_guest_preview = (basename($_SERVER['PHP_SELF']) === 'guest-preview.php') && isset($_GET['invite']);
	?>

	<?php if ($is_guest_preview):
		$eventtitle = esc_html(get_post_meta($edit_id, 'event_name', true));
		$current_url = "http" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "s" : "") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	?>
		
	<!-- Open Graph Meta Tags -->
	<meta name="og:title" content="You are invited to <?php echo htmlspecialchars($eventtitle); ?>" />
    <meta name="og:description" content="Tap to RSVP " />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $current_url; ?>" />
    <meta property="og:image" content="https://sit132.sanasinvite.com/wp-content/uploads/2024/08/Sana__s_Hub.png.png" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="300" />
    <?php endif; ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class('inner-page'); ?>>
<?php wp_body_open(); 
    do_action('sanas_header');
?>