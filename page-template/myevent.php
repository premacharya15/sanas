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
        $currentURL = site_url();
        $dashQuery = 'user-dashboard';
        $dashpage = '/?dashboard=cover';
        $dashback = '/?dashboard=details';
        $dashrsvp = '/?dashboard=rsvp';
        $dashpreview = '/?dashboard=preview';
        $dashguest = '/?dashboard=';
        global $wp_rewrite;
        $perma = ($wp_rewrite->permalink_structure == '') ? "&" : "/";

        if (is_user_logged_in()) {
            global $current_user, $post, $wpdb;
            wp_get_current_user();
            $userID = $current_user->ID;
            $sanas_card_event = $wpdb->prefix . "sanas_card_event";
            $guest_details_info_table = $wpdb->prefix . "guest_details_info";

            // Fetch all events and guest details in one query
            $get_event = $wpdb->get_results(
              $wpdb->prepare(
                  "SELECT e.event_no, e.event_card_id, e.event_rsvp_id, 
                          e.event_front_card_preview, e.event_back_card_preview, 
                          g.guest_status, COUNT(g.guest_id) as guest_count
                   FROM {$sanas_card_event} AS e
                   LEFT JOIN {$guest_details_info_table} AS g 
                   ON e.event_no = g.guest_event_id 
                   WHERE e.event_user = %d 
                   GROUP BY e.event_no 
                   ORDER BY e.event_no DESC",
                  $userID
              )
          );
          

            if (!empty($get_event)) {
                ?>
                <div class="row">
                    <div class="col-xl-10 col-lg-8 col-md-12">
                        <div class="row event-card-item">
                            <?php
                            foreach ($get_event as $event) {
                                $event_id = $event->event_no;
                                $event_card_id = $event->event_card_id;
                                $event_rsvp_id = $event->event_rsvp_id;
                                $event_front_card_preview = $event->event_front_card_preview;
                                $event_back_card_preview = $event->event_back_card_preview;
                                $formattedDate = '';
                                $status_name = 'Draft';
                                $status_class = 'draft';

                                // Format the event date
                                $eventDate = esc_html(get_post_meta($event_rsvp_id, 'event_date', true));
                                if (!empty($eventDate)) {
                                    $date = new DateTime($eventDate);
                                    $formattedDate = $date->format('F jS, Y');
                                }

                                // Check event title
                                $eventtitle = esc_html(get_post_meta($event_rsvp_id, 'event_name', true));

                                // Determine guest statuses
                                $guest_statuses = explode(',', $event->guest_status);
                                foreach ($guest_statuses as $status) {
                                    if (in_array($status, ['pending', 'Accepted', 'Declined', 'May Be'])) {
                                        $status_name = 'Sent';
                                        $status_class = 'sent';
                                        break;
                                    }
                                }

                                // Fetch portfolio meta
                                $sanas_portfolio_meta = get_post_meta($event_card_id, 'sanas_metabox', true) ?: [];
                                $bg_color = (!empty($sanas_portfolio_meta['sanas_bg_color'])) ? 'style="background:' . esc_attr($sanas_portfolio_meta['sanas_bg_color']) . '"' : '';

                                // Use back card preview if empty
                                if (empty($event_back_card_preview) && !empty($sanas_portfolio_meta['sanas_upload_back_Image']['url'])) {
                                    $event_back_card_preview = $sanas_portfolio_meta['sanas_upload_back_Image']['url'];
                                }

                                // Guest count
                                $totalGuests = $event->guest_count;

                                $stepURL = esc_url($currentURL . $perma . $dashQuery . $dashpage . '&card_id=' . $event_card_id . '&event_id=' . $event_id);
                                ?>
                                <div class="col-xxl-4 col-xl-5 col-lg-9 col-md-6 col-sm-6 col-12">
                                    <div class="event-box">
                                        <a href="<?php echo $stepURL; ?>" class="flip-container" <?php echo $bg_color; ?>>
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
                                            <?php echo $status_name; ?>
                                        </a>
                                        <div class="event-detaile">
                                            <div class="event-detaile-title">
                                                <h4 class="m-0">
                                                    <?php
                                                    if (empty($eventtitle)) {
                                                        echo 'Untitled ' . get_the_title($event_card_id);
                                                    } else {
                                                        echo $eventtitle;
                                                    }
                                                    ?>
                                                </h4>
                                                <p class="m-0"><?php echo $formattedDate; ?></p>
                                            </div>
                                            <div class="event-detaile-lower">
                                                <p class="m-0"><?php echo $totalGuests; ?> Guests</p>
                                                <a href="/user-dashboard/?dashboard=guestlist&card_id=<?php echo $event_card_id; ?>&event_id=<?php echo $event_id; ?>" class="btn btn-outline">
                                                    Guest List</a>
                                                <a href="<?php echo $stepURL; ?>" class="btn btn-secondary">
                                                    <i class="fa-solid fa-pen"></i>
                                                    Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo '<p>You haven’t created any event yet</p>';
            }
        }
        ?>
    </div>
</div>
<?php
get_footer('dashboard');
