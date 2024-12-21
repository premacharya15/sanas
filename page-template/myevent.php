<?php 
/**
    Template Name: My Event    
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
    // Determine the correct permalink structure
        $currentURL = site_url();
        $dashpage = '/?dashboard=cover';
        $dashQuery = 'user-dashboard';
        $dashrsvp = '/?dashboard=rsvp';
        // $dashback = '/?dashboard=details';
        // Determine the correct permalink structure
        global $wp_rewrite;
        if ($wp_rewrite->permalink_structure == '') {
            $perma = "&";
        } else {
            $perma = "/";
        }
        $current_url = " https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        // Parse the query string from the URL
        $query_string = parse_url($current_url, PHP_URL_QUERY);
        // Parse the query string into an associative array
        parse_str($query_string, $params);
        // Get the values of the 'card_id' and 'event_id' parameters
                // Output the card ID
        if(is_user_logged_in())
        {
        global $current_user, $post, $wpdb;
        wp_get_current_user();
        $userID = $current_user->ID;
        $sanas_card_event = $wpdb->prefix . "sanas_card_event";
        $guest_details_info_table = $wpdb->prefix . "guest_details_info";
        $get_event = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $sanas_card_event WHERE event_user = %d  ORDER BY event_no DESC",
                $userID
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
        $event_step_id = $event->event_step_id;
        $card_id = $event_card_id;
        $event_id = $id ;
        $get_guest_details = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $guest_details_info_table WHERE guest_user_id = %d AND guest_event_id = %d ORDER BY guest_id DESC",
                $userID,
                $id
            )
        );
        $totalGuests = count($get_guest_details);
        // Construct the dashboard URL with the card ID
        $stepURL = esc_url($currentURL . $perma . $dashQuery . $dashpage . '&card_id=' . $event_card_id . '&event_id=' . $id);

        $eventDate= esc_html(get_post_meta($event_rsvp_id, 'event_date', true));
        $eventtitle= esc_html(get_post_meta($event_rsvp_id, 'event_name', true));

        $formattedDate = '';
        if(!empty($eventDate))
        {
          $date = new DateTime($eventDate);
          $formattedDate = $date->format('F jS, Y');          
        }

        $status_name='Draft';
        $status_class='darft';
        // if(intval($event_step_id)>=4)
        // {
        //   $status_name='Sent';
        //   $status_class='sent ';
        // }

        if (get_post_meta($event_card_id,'sanas_metabox',true)) {
          $sanas_portfolio_meta = get_post_meta($event_card_id,'sanas_metabox',true);
        }
        else {
          $sanas_portfolio_meta = array();
        }

      $bg_color='';    
      if($sanas_portfolio_meta['sanas_bg_color'])
      {
      $bg_color='style="background:'.$sanas_portfolio_meta['sanas_bg_color'].'"';
      }

      if(empty($event_back_card_preview))
      {

            $sanas_metabox=get_post_meta($event_card_id,'sanas_metabox',true);
            if ($sanas_metabox) {
              $sanas_portfolio_meta = $sanas_metabox;
              $event_back_card_preview=$sanas_portfolio_meta['sanas_upload_back_Image']['url'];
            }
            else {
              $sanas_portfolio_meta = array();
            }

      }

      // Check if invitations have been sent
      $invitations_sent = check_invitations_sent($event_card_id);

      if ($invitations_sent) {
          $status_name = 'Sent';
          $status_class = 'sent';
      } else {
          // Existing logic to determine status
          if (intval($event_step_id) >= 4) {
              $status_name = 'Sent';
              $status_class = 'sent';
          } else {
              $status_name = 'Draft';
              $status_class = 'draft';
          }
      }
?>            
            <div class="col-xxl-4 col-xl-5 col-lg-9 col-md-6 col-sm-6 col-12">
              <div class="event-box">
                <a href="<?php echo $stepURL; ?>" class="flip-container" <?php echo $bg_color;?> >
                  <div class="flipper">
                    <div class="front">
                      <img src="<?php echo $event_front_card_preview; ?>" alt="template">
                    </div>
                    <div class="middel-card">
                      <img src="<?php echo $event_front_card_preview; ?>" alt="template">
                    </div>
                    <div class="back">
                      <img src="<?php echo $event_back_card_preview; ?>" alt="template">
                    </div>
                  </div>
                </a>
                <a href="<?php echo $stepURL; ?>" class="<?php echo esc_attr($status_class);?> event-send-btn">
                <?php echo $status_name; ?></a>
                <div class="event-detaile">
                  <div class="event-detaile-title">
                    <h4 class="m-0"><?php 
                   if(empty($eventtitle))
                   {
                    echo 'Untitled '.get_the_title($card_id);
                   }
                   else{
                    echo $eventtitle; 
                   }
                   ?></h4>
                    <p class="m-0"><?php echo $formattedDate ?></p>
                  </div>
                  <div class="event-detaile-lower">
                    <p class="m-0"><?php echo $totalGuests;?> Guests</p>
                    <a href="/user-dashboard/?dashboard=guestlist&card_id=<?php echo $card_id; ?>&event_id=<?php echo $event_id; ?>" class="btn btn-outline">
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
        }
        if(is_array($get_event) && empty($get_event)){
        echo '<p>You havent created any event yet</p>';
      }
        ?>
    </div>
  </div>
<?php
get_footer('dashboard');

// Function to check if invitations have been sent
function check_invitations_sent($event_card_id) {
    global $wpdb;
    $sanas_card_event_table = $wpdb->prefix . 'sanas_card_event';
    
    // Query to check if invitations have been sent for the specific event
    $result = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $sanas_card_event_table WHERE event_card_id = %d AND event_status = 'Sent'",
        $event_card_id
    ));

    return $result > 0; // Return true if invitations have been sent
}