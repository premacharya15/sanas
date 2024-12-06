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

	<?php if ($is_guest_preview): ?>
	<!-- Open Graph Meta Tags -->
	<meta name="og:title" content="<?php echo htmlspecialchars($eventtitle); ?>" />
    <meta name="og:description" content="<?php echo htmlspecialchars($eventdescription); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $eventUrl; ?>" />
    <meta property="og:image" content="<?php echo $eventImage; ?>" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="300" />
    <?php endif; ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class('inner-page'); ?>>
<?php wp_body_open(); 
    do_action('sanas_header');
?>