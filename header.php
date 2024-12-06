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
$is_guest_preview = strpos($_SERVER['REQUEST_URI'], '/guest-preview') !== false && isset($_GET['invite']);
?>

	<?php if ($is_guest_preview):

if (isset($_GET['invite'])) {
    $invite_from_url = $_GET['invite'];
    $decrypted_data = sanas_decrypt_data($invite_from_url);
    if ($decrypted_data) {
        parse_str($decrypted_data, $params);
        $card_id = isset($params['card_id']) ? $params['card_id'] : 'Not Found';
        $event_id = isset($params['event_id']) ? $params['event_id'] : 'Not Found';
        $entry = isset($params['entry']) ? $params['entry'] : 'Not Found';
        $guestid='';
    } else {
        echo "Failed to decrypt the data or the data is not in the expected format.";
    }
}
$sanas_card_event_table = $wpdb->prefix . 'sanas_card_event';  
$get_event_date = $wpdb->get_results($wpdb->prepare(
	"SELECT * FROM $sanas_card_event_table WHERE event_no = %d",
	$event_id
));
$event_rsvp_id=$get_event_date[0]->event_rsvp_id;

$get_event_date = $wpdb->get_results($wpdb->prepare(
	"SELECT * FROM $sanas_card_event_table WHERE event_no = %d",
	$event_id
));
$guestName = esc_html(get_post_meta($event_rsvp_id, 'guest_name', true));
echo $guestName;

		$eventtitle = esc_html(get_post_meta($event_rsvp_id, 'event_name', true));
		$current_url =$current_url = "http" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "s" : "") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";		;
	?>
		
	<!-- Open Graph Meta Tags -->
	<meta name="og:title" content="You are Invited! Click here to RSVP <?php echo htmlspecialchars($eventtitle); ?>" />
    <meta name="og:description" content="Host name has invited you to <?php echo htmlspecialchars($eventtitle); ?> on <?php echo $get_event_date; ?> " />
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