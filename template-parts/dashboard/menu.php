<!-- User Dashboar Menubar -->
<?php 
    if(isset($_GET['dashboard']) && !empty($_GET['dashboard']))
    {
        $coverclass = $_GET['dashboard']=='cover' ? 'active ' : ''; 
        $detailsclass = $_GET['dashboard']=='details' ? 'active ' : ''; 
        $rsvpclass = $_GET['dashboard']=='rsvp' ? 'active ' : '';   
        $previewclass = $_GET['dashboard']=='preview' ? 'active ' : ''; 
        $guestlistclass = $_GET['dashboard']=='guestlist' ? 'active ' : '';    
        $dashboard_trigger = $_GET['dashboard'];                                         
    }
    else{
        $coverclass = 'active';    
        $detailsclass = ''; 
        $rsvpclass = '';    
        $previewclass = ''; 
        $guestlistclass = '';   
        $dashboard_trigger = '';                                         
    }
    $currentURL = site_url();
    $dashQuery = 'user-dashboard';
    $dashpage = '/?dashboard=cover';
    $dashback = '/?dashboard=details';
    $dashrsvp = '/?dashboard=rsvp';
    $dashpreview = '/?dashboard=preview';
    $dashguest = '/?dashboard=guestlist';
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
        $current_url = " http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        // Parse the query string from the URL
        $query_string = parse_url($current_url, PHP_URL_QUERY);
        // Parse the query string into an associative array
        parse_str($query_string, $params);
        // Get the values of the 'card_id' and 'event_id' parameters
        $card_id = isset($params['card_id']) ? intval($params['card_id']) : null;
        $event_id = isset($params['event_id']) ? intval($params['event_id']) : null;
        // Output the card ID
        // Construct the dashboard URL with the card ID
        $dashboardURL = esc_url($currentURL . $perma . $dashQuery . $dashpage . '&card_id=' . $card_id .'&event_id=' . $event_id);
        $backURL = esc_url($currentURL . $perma . $dashQuery . $dashback . '&card_id=' . $card_id . '&event_id=' . $event_id);
        $rsvpURL = esc_url($currentURL . $perma . $dashQuery . $dashrsvp . '&card_id=' . $card_id . '&event_id=' . $event_id);
        $previewURL = esc_url($currentURL . $perma . $dashQuery . $dashpreview . '&card_id=' . $card_id . '&event_id=' . $event_id);
        $guestURL = esc_url($currentURL . $perma . $dashQuery . $dashguest . '&card_id=' . $card_id . '&event_id=' . $event_id);
        global $wpdb;
        $event_no = $event_id; // Replace this with the actual event_no you want to check
        $sanas_card_event_table = $wpdb->prefix . 'sanas_card_event';
        $event = $wpdb->get_row($wpdb->prepare(
            "SELECT event_step_id FROM $sanas_card_event_table WHERE event_no = %d",
            $event_no
        ));

        $event_step_id = $event ? $event->event_step_id : '0';
        $menu_items = [
            [
                'id' => 'btn-cover',
                'class' => 'btn-cover',
                'label' => 'Cover',
                'url'=>$dashboardURL,
                'activeclass'=>$coverclass,
                'icon' => 'icon-Envelop',
                'active' => true
            ],
            [
                'id' => 'btn-Details',
                'class' => 'btn-Details',
                'label' => 'Info',
                'url'=>$backURL,
                'activeclass'=>$detailsclass,
                'icon' => 'icon-Confetti',
                'active' => $event_step_id == 1 || $event_step_id == 2 || $event_step_id == 3  || $event_step_id == 4
            ],
            [
                'id' => 'btn-RSVP',
                'class' => 'btn-RSVP',
                'label' => 'RSVP',
                'url'=>$rsvpURL,
                'activeclass'=>$rsvpclass,
                'icon' => 'icon-RSVP',                
                'active' => $event_step_id == 2  || $event_step_id == 3  || $event_step_id == 4 
            ],
            [
                'id' => 'btn-Preview',
                'class' => 'btn-Preview',
                'label' => 'Preview',
                'url'=>$previewURL,
                'activeclass'=>$previewclass,
                'icon' => 'icon-Eye',
                'active' => $event_step_id == 3  || $event_step_id == 4 
            ],
            [
                'id' => 'btn-Guest-list',
                'class' => 'btn-Guest-list',
                'label' => 'Guest list',
                'url'=>$guestURL,
                'activeclass'=>$guestlistclass,
                'icon' => 'icon-Family',
                'active' => $event_step_id == 4
            ],
        ];
        ?>
<div class="inner-colum">
    <?php foreach ($menu_items as $item): ?>
        <button data-url="<?php echo esc_url($item['url']); ?>" data-trigger="<?php echo $dashboard_trigger; ?>" class="btn btn-side-bar <?php echo esc_attr($item['class']); ?> <?php echo esc_attr($item['activeclass']); ?> <?php echo $item['active'] ? 'stepactive' : 'disabled'; ?>">
            <i class="<?php echo isset($item['icon']) ? $item['icon'] : ''; ?>"></i>
            <span><?php echo esc_html($item['label']); ?></span>
        </button>
    <?php endforeach; ?>
    <input type="hidden" name="triggercall" id="triggercall" value="" >
</div>