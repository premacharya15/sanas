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
    $current_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $query_string = parse_url($current_url, PHP_URL_QUERY);
    parse_str($query_string, $params);
    
    if(is_user_logged_in()) {
        global $current_user, $post, $wpdb;
        wp_get_current_user();
        $userID = $current_user->ID;
        $sanas_card_event = $wpdb->prefix . "sanas_card_event";
        $guest_details_info_table = $wpdb->prefix . "guest_details_info";

        // Pagination: Define number of events per page
        $events_per_page = 5;  // Number of events per page
        $current_page = isset($_GET['paged']) ? (int) $_GET['paged'] : 1;  // Current page
        $offset = ($current_page - 1) * $events_per_page;  // Calculate offset

        // Optimized query: Retrieve only relevant columns and ensure distinct events, with pagination
        $get_event = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT DISTINCT event_no, event_card_id, event_rsvp_id, event_front_card_preview, event_back_card_preview 
                 FROM $sanas_card_event 
                 WHERE event_user = %d 
                 ORDER BY event_no DESC
                 LIMIT %d OFFSET %d",
                $userID,
                $events_per_page,
                $offset
            )
        );

        // Count total events for pagination
        $total_events = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(DISTINCT event_no) 
                 FROM $sanas_card_event 
                 WHERE event_user = %d",
                $userID
            )
        );
        
        $total_pages = ceil($total_events / $events_per_page);  // Total pages

        ?>      
        <div class="row">
            <div class="col-xl-10 col-lg-8 col-md-12">
                <div class="row event-card-item">
                <?php 
                    foreach ($get_event as $event) { 
                        // Existing event display code
                        // ...
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination">
                <?php
                    echo paginate_links( array(
                        'total' => $total_pages,
                        'current' => $current_page,
                        'format' => '?paged=%#%',
                        'prev_text' => '« Previous',
                        'next_text' => 'Next »',
                    ));
                ?>
            </div>
        </div>
        
        <?php
    }
    if(is_array($get_event) && empty($get_event)){
        echo '<p>You haven’t created any events yet</p>';
    }
    ?>
</div>
</div>
<?php
get_footer('dashboard');
?>
