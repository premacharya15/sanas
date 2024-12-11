<?php
global $current_user;
wp_get_current_user();
$user_id = $current_user->ID;
    $dashQuery = 'user-dashboard';
     $dashrsvp = '/?dashboard=rsvp';
    $dashguest = '/?dashboard=guestlist';

     global $wp_rewrite;
        if ($wp_rewrite->permalink_structure == '') {
            $perma = "&";
        } else {
            $perma = "/";
        }

    $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    // Parse the query string from the URL
    $query_string = parse_url($current_url, PHP_URL_QUERY);
    // Parse the query string into an associative array
    parse_str($query_string, $params);
    // Get the values of the 'card_id' and 'event_id' parameters
    $card_id = isset($params['card_id']) ? intval($params['card_id']) : null;
    $event_id = isset($params['event_id']) ? intval($params['event_id']) : null;

    $currentURL = site_url();
    $rsvpURL = esc_url($currentURL . $perma . $dashQuery . $dashrsvp. '&card_id='. $card_id . '&event_id='. $event_id);
    $guestURL = esc_url($currentURL . $perma . $dashQuery . $dashguest. '&card_id='. $card_id . '&event_id='. $event_id);
    $sanas_card_event_table = $wpdb->prefix . 'sanas_card_event';

    $rsvpquery = $wpdb->prepare(
        "SELECT event_rsvp_id FROM $sanas_card_event_table  WHERE event_no = %d",
        $event_id
    );
    $rsvp_id = $wpdb->get_var($rsvpquery);



    if ($card_id) {

        $frontimagequery = $wpdb->prepare(
            "SELECT event_front_card_preview 
             FROM $sanas_card_event_table 
             WHERE event_card_id = %d 
               AND event_no = %d",
            $card_id,
            $event_id
        );

        $frontimageresult = $wpdb->get_var($frontimagequery);
        
        if ($frontimageresult) {
            $event_front_card_preview = $frontimageresult;
        } 
        else {
            $event_front_card_preview = '';
        }


        $backimagequery = $wpdb->prepare(
            "SELECT event_back_card_preview 
             FROM $sanas_card_event_table 
             WHERE event_card_id = %d 
               AND event_no = %d",
            $card_id,
            $event_id
        );
        $backimageresult = $wpdb->get_var($backimagequery);
        // Check if result is not empty
        if ($backimageresult) {
            $event_back_card_preview = $backimageresult;
        } else {
            $event_back_card_preview = '';
        }
    }
    else {
        $event_front_card_preview = 'Invalid card ID';
    }


    $rsvpimagequery = $wpdb->prepare(
        "SELECT event_rsvp_bg_link FROM $sanas_card_event_table WHERE event_no = %d",
        $event_id
    );
    $rsvpimage = $wpdb->get_var($rsvpimagequery);

    $rsvpimage_url = get_template_directory_uri() . '/assets/img/preview-bg.jfif';
    // Use the default image if the database image is empty
    if (empty($rsvpimage)) {
        $rsvpimage_url = $rsvpimage;
    }


    $frontimagequery = $wpdb->prepare(
        "SELECT event_front_bg_link FROM $sanas_card_event_table WHERE event_no = %d",
        $event_id
    );
    $frontimage = $wpdb->get_var($frontimagequery);
 

$color_bg_link = $wpdb->prepare(
      "SELECT event_front_bg_color FROM $sanas_card_event_table WHERE event_no = %d",
       $event_id
 );
$colorbg = $wpdb->get_var($color_bg_link);
$colorbgvalue='';
if($colorbg)
{
    $colorbgvalue=$colorbg;
}    

 $rsvpimagequery = $wpdb->prepare(
      "SELECT event_rsvp_bg_link FROM $sanas_card_event_table WHERE event_no = %d",
       $event_id
 );                           
$rsvpimage = $wpdb->get_var($rsvpimagequery);
$default_image_url = get_template_directory_uri() . '/assets/img/preview-bg.jpg';

// Use the default image if the database image is empty
if (empty($rsvpimage)) {
    $rsvpimage = $default_image_url;
}
    
// Query to check if the user already has an existing RSVP
$existing_rsvp_query = new WP_Query(array(
    'post_type' => 'sanas_rsvp',
    'author' => $user_id,
    'posts_per_page' => 1,  // Limit to 1 post per user
));

if ($existing_rsvp_query->have_posts()) {
    // If an existing RSVP post is found
    $existing_rsvp_query->the_post();
    $edit_id = $rsvp_id;
    $rsvpvideo = esc_html(get_post_meta($edit_id, 'opt_upload_video', true));
    $guestName = esc_html(get_post_meta($edit_id, 'guest_name', true));
    $eventtitle = esc_html(get_post_meta($edit_id, 'event_name', true));
    $eventdate = esc_html(get_post_meta($edit_id, 'event_date', true));
    $guestContact = esc_html(get_post_meta($edit_id, 'guest_contact', true));
    $guestMessage = esc_html(get_post_meta($edit_id, 'guest_message', true));
    $program = get_post_meta($edit_id, 'listing_itinerary_details', true);
    $registry = get_post_meta($edit_id, 'registries', true);
    $event_venue_name = esc_html(get_post_meta($edit_id, 'event_venue_name', true));
    $event_venue_address = esc_html(get_post_meta($edit_id, 'event_venue_address', true));
    $event_venue_address_link = esc_html(get_post_meta($edit_id, 'event_venue_address_link', true));
    $itinerary = get_post_meta($edit_id, 'itinerary', true);

    $guest_name_css = get_post_meta($edit_id, 'guest_name_css', true);
    $guest_contact_css = get_post_meta($edit_id, 'guest_contact_css', true);
    $guest_message_css = get_post_meta($edit_id, 'guest_message_css', true);
    $event_title_css = get_post_meta($edit_id, 'event_title_css', true);
    $event_date_css = get_post_meta($edit_id, 'event_date_css', true);
    $itinerarycss = get_post_meta($edit_id, 'itinerarycss', true);
    // Restore original post data
    wp_reset_postdata();
} 
else {
    // If no existing RSVP post is found, initialize variables to empty or default values
    $edit_id = null;
    $rsvpvideo = '';
    $guestName = '';
    $guestContact = '';
    $guestMessage = '';
    $event_venue_name = '';
    $event_venue_address = '';
    $event_venue_address_link = '';
    $program = array();
    $registry = array();
    $itinerary='';
    $guest_name_css = '';
    $guest_contact_css = '';
    $guest_message_css = '';
    $event_title_css = '';
    $event_date_css = '';    

    $itinerarycss='';
}
function is_youtube_url($url) {
    return preg_match('/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', $url);
}
?>
<div class="wl-right-slide-bar">
   <?php 
         get_template_part('template-parts/dashboard/menu');
    ?> 
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Set the src of the image element to the base64 data URL
        var eventFrontCardPreview = <?php echo json_encode($event_front_card_preview); ?>;
        if (eventFrontCardPreview !== 'No preview available' && eventFrontCardPreview !== 'Invalid card ID') {
            document.getElementById('frontimagePreview').src = eventFrontCardPreview;
        }

         var eventBackCardPreview = <?php echo json_encode($event_back_card_preview); ?>;
        if (eventBackCardPreview !== 'No preview available' && eventBackCardPreview !== 'Invalid card ID') {
            document.getElementById('backimagePreview').src = eventBackCardPreview;
        }
    });
</script>
<style>
#previewcanvasElement {
    background-image: url('<?php echo $rsvpimage ?>');
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat; 
}

#frontcanvasElement {
    background-image: url('<?php echo $frontimage ?>') !important;
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat; 
}
</style>
    <section class="wl-main-canvas wl-main-preview">
        <div class="container-fluid">
            <div class="inner-container"  id="previewcanvasElement">
                <div class="inner-colum" id="frontcanvasElement" style="background-color: <?php echo $colorbg;?>">
                    <div class="card-canvas row">
                        <div class=" col-md-6 col-sm-12">
                            <div class="preview-img">
                               <?php if ($event_front_card_preview !== 'No preview available' && $event_front_card_preview !== 'Invalid card ID'){ ?>
                                <img id="frontimagePreview" width="525" height="765" alt="">
                            <?php } 
                            else{ ?>
                                <p><?php echo esc_html($event_front_card_preview); ?></p>
                            <?php } ?> 
                            </div>
                        </div>
                        <div class=" col-md-6 col-sm-12">
                            <div class="preview-img">
                                 <?php if ($event_back_card_preview !== 'No preview available' && $event_back_card_preview !== 'Invalid card ID'){ ?>
                                <img id="backimagePreview" width="525" height="765" alt="">
                                <?php }else{ ?>
                                    <p><?php echo esc_html($event_back_card_preview); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content content-3">
                    <div class="row">

                        <div class="divider">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/divider.png" alt="">
                        </div>
                        <div class="wl-card-detaile">
                            <div class="row">
                            <?php if (!empty($rsvpvideo)) { ?>
                            <div class="col-12">
                                    <?php if (is_youtube_url($rsvpvideo)) : ?>
                                    <?php
                                         $youtubevideo=$rsvpvideo ;
                                        // Extract YouTube video ID
                                        preg_match('/\/([^\/]+)$/', $youtubevideo, $matches);
                                        $youtube_id = $matches[1];                                   
                                    ?>
                                    <iframe id="youtube-iframe" width="1000" height="490" src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <?php else : ?>

                                    <?php if (!empty($rsvpvideo)) { ?>
                                    <video controls>
                                        <source src="<?php echo esc_url($rsvpvideo); ?>">
                                    </video>
                                    <?php } ?>
                                <?php endif; ?>
                            </div>
                            <?php } ?>                                
                            </div>
                            <?php if (!empty($rsvpvideo)) { ?>
                            <div class="divider">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/divider.png" alt="">
                            </div>
                            <?php } ?>  
                            <div class="wl-inner-card-detaile wl-previewbox">
                                <div class="row">

                                <div class="row col-xxl-8 col-xl-9 col-lg-9 col-md-12 m-auto position-relative">
                            
                                <div class="rsvp-from-group">
                                    <h3 class="mb-0 mt-3" style="font-size:24px;">Hosted By</h3>
                                </div>  
                                <div class="rsvp-event" style="background: transparent !important;border:none !important; padding: 20px 20px 0px 20px;margin:0;">
                                    <div class="rsvp-from-group">
                                        <div id="guestName" name="guestName" style="<?php echo $guest_name_css; ?>" class="edit-text rsvp-msg preview-host-name">
                                            <?php echo esc_html($guestName); ?>
                                        </div>
                                    </div>
                                    <div class="rsvp-from-group">
                                        <div id="guestContact" style="<?php echo $guest_contact_css; ?>" class="edit-text rsvp-msg preview-host-contact-no mb-0">
                                            <?php echo esc_html($guestContact); ?>
                                        </div>
                                    </div>
                                        <!-- <input type="hidden" id="event_venue_address_link" name="event_venue_address_link" value="<?php echo esc_html($event_venue_address_link); ?>"> -->
                                        <?php  if(!empty($guestMessage)) { ?>
                                        <div class="rsvp-from-group">
                                            <div class="edit-text rsvp-msg preview-host-message" style="<?php echo $guest_message_css; ?>" id="guestMessage" name="guestMessage"><?php echo nl2br(htmlspecialchars(html_entity_decode($guestMessage))); ?>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div> 

                            <div class="row col-xxl-8 col-xl-9 col-lg-9 col-md-12 m-auto mt-0 position-relative">
                                <div class="rsvp-event" style="background: transparent !important;border:none !important; padding: 0px 20px;margin-top: 0 !important;">
                                    <div class="divider">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/divider.png" alt="">
                                    </div>
                                    <div class="rsvp-from-group">
                                        <div id="eventtitle" class="edit-text rsvp-msg event-title" style="<?php echo $event_title_css; ?>">
                                            <?php echo esc_html($eventtitle); ?>
                                        </div>
                                    </div>
                                    <div class="rsvp-from-group">
                                        <div class="event-date py-1" style="<?php echo $event_date_css; ?>">
                                            <?php
                                            $timestamp = strtotime($eventdate);
                                            $formattedDate = date("jS M Y", $timestamp);
                                            ?>
                                            <?php echo esc_html($formattedDate); ?>
                                        </div>
                                        <!-- <input type="date" id="eventdate" class="edit-text rsvp-msg event-date" name="eventdate"  style="<?php echo $event_date_css; ?>" value="" required=""> -->
                                    </div>
                                    <div class="rsvp-from-group m-0 p-0 map-container-rsvp">
                                        <!-- <h4>Address</h4> -->
                                            <div class="map-input-rsvp map-input-rsvp-black m-0 py-1 edit-text rsvp-msg event_venue_name" id="search" type="text"><?php echo esc_html($event_venue_name); ?></div>
                                            <div class="map-input-rsvp map-input-rsvp-black m-0 py-1 edit-text rsvp-msg event_venue_address" id="search_address" rows="2" cols="50"><?php echo esc_html($event_venue_address); ?></div>
                                            <div class="map-location-rsvp" id="map" style="display: none;"></div>
                                    </div>
                                </div>
                            </div>



                                
                                    <!-- <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-8 col-sm-12 m-auto"> -->
                                        <!-- <span></span> -->
                                         <?php 
                                        // if(!empty($eventtitle)) { echo '<div class="mt-3 mb-2 preview-event-title" style="'.$event_title_css.'">'.esc_html($eventtitle).'</div>'; }

                                        //     if(!empty($eventdate)) { echo '<div class="mt-2 mb-2 preview-event-date" style="'.$event_date_css.'">'.esc_html($eventdate).'</div>'; }

                                        ?>
                                        
                                        <!-- <div class="mt-2 mb-2 edit-text rsvp-msg" id="search_address" rows="2" cols="50" placeholder="Venue Address">61020 Petriano, Province of Pesaro and Urbino, Italy</div> -->
                                        <!-- <h4 class="mb-2" style="font-size:20px;color: #5c310d;">Hosted By</h4> -->
                                        <?php 
                                            // if(!empty($guestName)) { echo '<div class="preview-host-name mb-2" style="'.$guest_name_css.'">'.esc_html($guestName).'</div>'; }
                                            // if(!empty($guestContact)) { echo '<div class="preview-host-contact-no mb-2" style="'.$guest_contact_css.'">'.esc_html($guestContact).'</div>'; }
                                            // if(!empty($guestMessage)) { echo '<div class="preview-host-message mb-2" style="'.$guest_message_css.'"><pre>'.$guestMessage.'</pre></div>'; }
                                        ?>
                                    <!-- </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 m-auto">
                                        <div class="wl-fuc-timing">
                                            <?php 
                                            //if(!empty($itinerary)) { echo '<h4 class="mb-0" style="'.$itinerarycss.'">'.esc_html($itinerary).'</h4>'; }
                                            
                                            if( !empty($program) && count($program)>0 ){
                                            ?>
                                            <h4 class="mb-1 mt-3" style="font-size: 24px;">Itinerary</h4>
                                            <table class="preview-itn">
                                                <?php 
                                                
                                                foreach ($program as $event) :?>
                                                <tr>
                                                    <td><?php echo esc_attr($event['program_name'])?></td>
                                                    <td><?php echo esc_attr($event['program_time'])?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </table>
                                            <?php  } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-10 col-sm-12 m-auto">
                                        <div class="wl-joining nonclickeble">
                                            <h4 class="mb-3">Will you be joining us?</h4>
                                            <ul>
                                                <li><a href="#">Yes</a></li>
                                                <li><a href="#">No</a></li>
                                                <li><a href="#">Not Sure</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-10 m-auto">
                                        <div class="guest-count nonclickeble">
                                            <h5>No. of Guests</h5>
                                            <div class="guest-counter">
                                                <h4>Adults</h4>
                                                <div class="count">
                                                    <span class="mines"><i class="fa-solid fa-minus"></i></span>
                                                    <span class="total-guest">0</span>
                                                    <span class="plues"><i class="fa-solid fa-plus"></i></span>
                                                </div>
                                            </div>
                                            <div class="guest-counter">
                                                <h4>Kids</h4>
                                                <div class="count">
                                                    <span class="mines"><i class="fa-solid fa-minus"></i></span>
                                                    <span class="total-guest">0</span>
                                                    <span class="plues"><i class="fa-solid fa-plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-8 col-sm-12 m-auto nonclickeble">
                                        <textarea name="Message" class="textarea-preview" id="guestMessage" rows="5"
                                            placeholder="Message to the host..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if( !empty($registry) && count($registry)>0 ){
               
            ?>
            <div class="registry">
                <div class="container-fluid ps-5 pe-5">
                    <div class="row">
                        <div class=" col-12 m-auto">
                            <h5>Gift Registry</h5>
                            <div class=" row g-sm-5">
                            <?php
                               if( !empty($registry) && count($registry)>0 ){
                                foreach ($registry as $event) :?>
                                     <div class="col-xl-3 col-lg-6 col-md-6">
                                      <?php 
                                            if (str_contains($event['url'], 'amazon.')) {
                                            ?>
                                            <a class="gift-registry" href="<?php echo esc_url($event['url'])?>" target="_blank">
                                                <?php echo '<img id="img12" src=" ' . get_template_directory_uri() . '/assets/img/Amazon.png" alt=""> '?> </a>
                                            <?php    
                                            } else  if (str_contains($event['url'], 'target.')) {
                                            ?>
                                             <a class="gift-registry" href="<?php echo esc_url($event['url'])?>" target="_blank"><?php echo '<img id="img12" src=" ' . get_template_directory_uri() . '/assets/img/Target.png" alt=""> '?></a>
                                            <?php    
                                            } else {
                                            ?>
                                             <a class="gift-registry" href="<?php echo esc_url($event['url'])?>" target="_blank"><?php echo esc_attr($event['name'])?></a>
                                            <?php    
                                            }
                                      ?>                                   
                                    </div>
                               <?php endforeach; }?>                                                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-4">
                                <button event-id="<?php echo esc_attr($event_id); ?>" 
                                                                    rsvp-id="<?php echo esc_attr($rsvp_id); ?>"
                                                                    card-id="<?php echo esc_attr($card_id); ?>" 
                                                                    btn-url="<?php echo $rsvpURL;?>"
                                                                    id="rsvp-page-redirect" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back </button>
                                <button btn-url="<?php echo $guestURL;?>" event-id="<?php echo esc_attr($event_id); ?>" 
                                                                    rsvp-id="<?php echo esc_attr($rsvp_id); ?>"
                                                                    card-id="<?php echo esc_attr($card_id); ?>"  id="guest-page-redirect" class="btn btn-secondary"> Next <i class="fa-solid fa-arrow-right"></i></button> 
                                <?php wp_nonce_field('ajax-sanas-save-preview-nonce', 'sanassavepreviewsecurity');?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }else{
               ?>
                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-4">
                                <button event-id="<?php echo esc_attr($event_id); ?>" 
                                                                    rsvp-id="<?php echo esc_attr($rsvp_id); ?>"
                                                                    card-id="<?php echo esc_attr($card_id); ?>" 
                                                                    btn-url="<?php echo $rsvpURL;?>"
                                                                    id="rsvp-page-redirect" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back </button>
                                <button btn-url="<?php echo $guestURL;?>" event-id="<?php echo esc_attr($event_id); ?>" 
                                                                    rsvp-id="<?php echo esc_attr($rsvp_id); ?>"
                                                                    card-id="<?php echo esc_attr($card_id); ?>"  id="guest-page-redirect" class="btn btn-secondary"> Next <i class="fa-solid fa-arrow-right"></i></button> 
                                <?php wp_nonce_field('ajax-sanas-save-preview-nonce', 'sanassavepreviewsecurity');?>

                            </div>
                        </div>
                    </div>
                </div>
               <?php
            }
            ?>
        </div>
    </section>
<input type="hidden" name="header-options-msg" id="header-options-msg" value="Add Your Guests in Next Steps."/>    