<?php
/**
    Template Name: My Event    
    * The template for displaying all pages
    * @package sanas
*/
get_header();
get_sidebar('dashboard');
?>
<div class="wl-dashboard-wrapper dashboard">
    <div class="container-fluid wl-dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h4 class="pageheader-title"><?php the_title(); ?></h4>
                </div>
            </div>
        </div>

        <?php 
        if (is_user_logged_in()) {
            global $current_user, $wpdb;
            wp_get_current_user();
            $userID = $current_user->ID;
            $sanas_card_event = $wpdb->prefix . "sanas_card_event";
            $guest_details_info_table = $wpdb->prefix . "guest_details_info";

            $get_event = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM $sanas_card_event WHERE event_user = %d ORDER BY event_no DESC",
                    $userID
                )
            );

            if (!empty($get_event)) {
                ?>
                <div class="row">
                    <div class="col-xl-10 col-lg-8 col-md-12">
                        <div class="row event-card-item">
                            <?php foreach ($get_event as $event) {
                                $id = $event->event_no;
                                $event_card_id = $event->event_card_id;
                                $event_rsvp_id = $event->event_rsvp_id;
                                $event_front_card_preview = $event->event_front_card_preview;
                                $event_back_card_preview = $event->event_back_card_preview;

                                // Ensure the back image is handled correctly
                                if (empty($event_back_card_preview)) {
                                    $sanas_metabox = get_post_meta($event_card_id, 'sanas_metabox', true);
                                    if ($sanas_metabox) {
                                        $event_back_card_preview = $sanas_metabox['sanas_upload_back_Image']['url'] ?? '';
                                    }
                                }

                                $eventDate = esc_html(get_post_meta($event_rsvp_id, 'event_date', true));
                                $eventTitle = esc_html(get_post_meta($event_rsvp_id, 'event_name', true));
                                $formattedDate = !empty($eventDate) ? (new DateTime($eventDate))->format('F jS, Y') : '';

                                $get_guest_details = $wpdb->get_results(
                                    $wpdb->prepare(
                                        "SELECT * FROM $guest_details_info_table WHERE guest_user_id = %d AND guest_event_id = %d",
                                        $userID,
                                        $id
                                    )
                                );
                                $totalGuests = count($get_guest_details);

                                $status_name = 'Draft';
                                $status_class = 'draft';

                                foreach ($get_guest_details as $guest) {
                                    if (in_array($guest->guest_status, ['pending', 'Accepted', 'Declined', 'May Be'])) {
                                        $status_name = 'Sent';
                                        $status_class = 'sent';
                                        break;
                                    }
                                }

                                $stepURL = esc_url(site_url("/?dashboard=cover&card_id=$event_card_id&event_id=$id"));
                                ?>
                                <div class="col-xxl-4 col-xl-5 col-lg-9 col-md-6 col-sm-6 col-12">
                                    <div class="event-box">
                                        <a href="<?php echo $stepURL; ?>" class="flip-container" style="background:<?php echo esc_attr($event->sanas_bg_color ?? ''); ?>;">
                                            <div class="flipper">
                                                <div class="front">
                                                    <img src="<?php echo esc_url($event_front_card_preview); ?>" alt="template">
                                                </div>
                                                <div class="middel-card">
                                                    <img src="<?php echo esc_url($event_front_card_preview); ?>" alt="template">
                                                </div>
                                                <div class="back">
                                                    <img src="<?php echo esc_url($event_back_card_preview); ?>" alt="template">
                                                </div>
                                            </div>
                                        </a>
                                        <a href="<?php echo $stepURL; ?>" class="<?php echo esc_attr($status_class); ?> event-send-btn">
                                            <?php echo esc_html($status_name); ?>
                                        </a>
                                        <div class="event-detaile">
                                            <div class="event-detaile-title">
                                                <h4 class="m-0"><?php echo !empty($eventTitle) ? esc_html($eventTitle) : 'Untitled ' . get_the_title($event_card_id); ?></h4>
                                                <p class="m-0"><?php echo esc_html($formattedDate); ?></p>
                                            </div>
                                            <div class="event-detaile-lower">
                                                <p class="m-0"><?php echo $totalGuests; ?> Guests</p>
                                                <a href="/user-dashboard/?dashboard=guestlist&card_id=<?php echo $event_card_id; ?>&event_id=<?php echo $id; ?>" class="btn btn-outline">
                                                    Guest List</a>
                                                <a href="<?php echo $stepURL; ?>" class="btn btn-secondary">
                                                    <i class="fa-solid fa-pen"></i> Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo '<p>You haven\'t created any event yet.</p>';
            }
        }
        ?>
    </div>
</div>
<?php
get_footer('dashboard');
?>
