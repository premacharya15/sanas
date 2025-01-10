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
    global $wp_rewrite;
    $perma = ($wp_rewrite->permalink_structure == '') ? "&" : "/";
    $current_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    if(is_user_logged_in()) {
        global $current_user, $post, $wpdb;
        wp_get_current_user();
        $userID = $current_user->ID;
        $sanas_card_event = $wpdb->prefix . "sanas_card_event";
        $guest_details_info_table = $wpdb->prefix . "guest_details_info";

        // Pagination logic
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $events_per_page = 6;

        // Get paginated events
        $get_event = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT DISTINCT event_no, event_card_id, event_rsvp_id, event_front_card_preview, event_back_card_preview
                 FROM $sanas_card_event 
                 WHERE event_user = %d 
                 ORDER BY event_no DESC 
                 LIMIT %d OFFSET %d",
                $userID,
                $events_per_page,
                ($paged - 1) * $events_per_page
            )
        );

        ?>
        <div class="row">
            <div class="col-xl-10 col-lg-8 col-md-12">
                <div class="row event-card-item">
                <?php 
                    foreach ($get_event as $event) { 
                        $id = $event->event_no;
                        $event_card_id = $event->event_card_id;
                        $event_rsvp_id = $event->event_rsvp_id;
                        $event_front_card_preview = $event->event_front_card_preview;
                        $event_back_card_preview = $event->event_back_card_preview;

                        $stepURL = esc_url($currentURL . $perma . 'user-dashboard&card_id=' . $event_card_id . '&event_id=' . $id);
                        $eventDate = esc_html(get_post_meta($event_rsvp_id, 'event_date', true));
                        $eventtitle = esc_html(get_post_meta($event_rsvp_id, 'event_name', true));

                        $formattedDate = '';
                        if (!empty($eventDate)) {
                            $date = new DateTime($eventDate);
                            $formattedDate = $date->format('F jS, Y');
                        }
                ?>            
                    <div class="col-xxl-4 col-xl-5 col-lg-9 col-md-6 col-sm-6 col-12">
                        <div class="event-box">
                            <a href="<?php echo $stepURL; ?>" class="flip-container">
                                <div class="flipper">
                                    <div class="front">
                                        <img src="<?php echo $event_front_card_preview; ?>" alt="template">
                                    </div>
                                    <div class="back">
                                        <img src="<?php echo $event_back_card_preview; ?>" alt="template">
                                    </div>
                                </div>
                            </a>
                            <div class="event-detaile">
                                <h4><?php echo $eventtitle; ?></h4>
                                <p><?php echo $formattedDate; ?></p>
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
        $total_events = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(DISTINCT event_no) FROM $sanas_card_event WHERE event_user = %d",
                $userID
            )
        );

        $total_pages = ceil($total_events / $events_per_page);

        echo paginate_links( array(
            'total' => $total_pages,
            'current' => $paged,
            'format' => '?paged=%#%',
            'prev_text' => '« Prev',
            'next_text' => 'Next »',
        ) );
    }
    if (is_array($get_event) && empty($get_event)) {
        echo '<p>You havent created any event yet</p>';
    }
    ?>
</div>
</div>
<?php
get_footer('dashboard');
?>
