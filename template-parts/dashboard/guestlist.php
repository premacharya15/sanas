<?php 
global $current_user, $post, $wpdb;
wp_get_current_user();
$userID = $current_user->ID;
$guest_details_info_table = $wpdb->prefix . "guest_details_info";
$guest_group_info_table = $wpdb->prefix . "guest_list_group";
$sanas_card_event_table = $wpdb->prefix . 'sanas_card_event';
// Get the event_id from the URL
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$card_id = isset($_GET['card_id']) ? intval($_GET['card_id']) : 0;

$get_guest_details = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $guest_details_info_table WHERE guest_user_id = %d AND guest_event_id = %d ORDER BY guest_name ASC",
        $userID,
        $event_id
    )
);


$get_guest_group = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $guest_group_info_table WHERE guest_group_user = %d AND guest_event_id = %d  ORDER BY guest_group_name ASC",
        $userID,
        $event_id
    )
);
$frontimagequery = $wpdb->prepare(
        "SELECT event_front_card_preview FROM $sanas_card_event_table WHERE event_card_id = %d AND event_no = %d",
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
$totalGuests = count($get_guest_details);
$currentURL = site_url();
$dashQuery = 'user-dashboard';
$dashpreview = '/?dashboard=preview';

$data_to_encrypt = 'card_id='.intval($card_id).'&event_id='.intval($event_id).'&entry=new';

$invite = sanas_encrypt_data($data_to_encrypt);


$share_guest_preview = site_url().'/guest-preview/?invite='.$invite;

// Determine the correct permalink structure
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
global $wp_rewrite;
$perma = $wp_rewrite->permalink_structure == '' ? "&" : "/";
$card_id = isset($_GET['card_id']) ? intval($_GET['card_id']) : 0;
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;



$rsvp_query = $wpdb->prepare(
        "SELECT event_rsvp_id FROM $sanas_card_event_table WHERE event_card_id = %d AND event_no = %d",
        $card_id,
        $event_id
    );

$rsvp_id = $wpdb->get_var($rsvp_query);
$mailtitle = get_post_meta($rsvp_id, 'event_name', true);


$preview_guest_invitation_url = $currentURL . '/guest-preview/' .'?card_id='.$card_id .'&event_id='.$event_id; 


$guestURL = $currentURL . '/user-dashboard/' .'?dashboard=guestlist&card_id='.$card_id .'&event_id='.$event_id; 

$acceptedURL = $currentURL . '/user-dashboard/' .'?dashboard=guestlist&card_id='.$card_id .'&event_id='.$event_id.'&status=accepted'; 
$declinedURL = $currentURL . '/user-dashboard/' .'?dashboard=guestlist&card_id='.$card_id .'&event_id='.$event_id.'&status=declined'; 
$maybeURL = $currentURL . '/user-dashboard/' .'?dashboard=guestlist&card_id='.$card_id .'&event_id='.$event_id.'&status=maybe'; 


$guest_declined=0;
$guest_accepted=0;
$guest_maybe = 0 ;
$guest_reply = 0 ;


$guest_accepted_adult=0;
$guest_accepted_kids=0;

$guest_declined_adult=0;
$guest_declined_kids=0;

$guest_maybe_adult = 0 ;
$guest_maybe_kids = 0 ;


$accepted_status='';
$declined_status='';
$maybe_status='';


if(isset($_GET['status']) && !empty($_GET['status']))
{
  if($_GET['status']=='accepted')
  {
    $accepted_status='active';
  }
  else if($_GET['status']=='declined')
  {
    $declined_status='active';
  }
  else if($_GET['status']=='maybe')
  {
    $maybe_status='active';
  }
}

foreach ($get_guest_details as $guest_list) { 
           $guest_status = $guest_list->guest_status;
           if($guest_status=='Declined')
           {
           		$guest_declined=$guest_declined+1;
              $guest_declined_adult=$guest_declined_adult+intval($guest_list->guest_adult);
              $guest_declined_kids=$guest_declined_kids+intval($guest_list->guest_kids);              

           }
           else if($guest_status=='Accepted')
           {
           		$guest_accepted=$guest_accepted+1;

           		$guest_accepted_adult=$guest_accepted_adult+intval($guest_list->guest_adult);
           		$guest_accepted_kids=$guest_accepted_kids+intval($guest_list->guest_kids);           		
           }
           else if($guest_status=='May Be')
           {
              $guest_maybe=$guest_maybe+1;

              $guest_maybe_adult=$guest_maybe_adult+intval($guest_list->guest_adult);
              $guest_maybe_kids=$guest_maybe_kids+intval($guest_list->guest_kids);              
           }  
           else if($guest_status=='pending')
           {
              $guest_reply=$guest_reply+1;
           }                      
}                            
?>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
        var eventFrontCardPreview = <?php echo json_encode($event_front_card_preview); ?>;
});
</script>
  <div class="wl-dashboard-wrapper" style="background: #F9F9F9;">
    <div class="container-fluid wl-dashboard-content">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="page-header">
            <h4 class="pageheader-title">Guest List</h4>
          </div>
        </div>
      </div>
      <div class="top-tabs">
        <div class="tabs-box">
          <h5>Reception</h5>
        </div>
      </div>
      <div class="guest-stats">
        <div class="row">
          <a class="card-block" href="<?php echo esc_url($guestURL);?>">
            <div class="card border-top-primary h-100">
              <div class="card-body">
                <div class="icon"><i class="fa-solid fa-users"></i></div>
                <div class="count">
                  <span><?php echo $totalGuests;?></span>
                </div>
                <h4 class="text-muted">Guests</h4>
              </div>
            </div>
          </a>
          <a class="card-block" href="<?php echo esc_url($acceptedURL);?>">
            <div class="card border-top-primary  h-100">
              <div class="card-body <?php echo $accepted_status; ?>">
                <div class="icon"><i class="fa fa-check-square"></i></div>
                <div class="count">
                  <span><?php echo $guest_accepted;?></span>
                </div>
                <h4 class="text-muted">Accepted</h4>
                <?php 
                if(!empty($guest_accepted_adult)) {
                ?>
                <span>Adult: <?php echo $guest_accepted_adult; ?></span>&nbsp;&nbsp;<span>Kids: <?php echo $guest_accepted_kids; ?></span>
                <?php 
                }
                ?>
              </div>
            </div>
          </a>
          <a class="card-block" href="<?php echo esc_url($maybeURL);?>">
            <div class="card border-top-primary  h-100">
              <div class="card-body <?php echo $maybe_status; ?>">
                <div class="icon"><i class="fa fa-hourglass-half"></i></div>
                <div class="count">
                  <span><?php echo $guest_maybe; ?></span>
                </div>
                <h4 class="text-muted">May be</h4>
                <?php 
                if(!empty($guest_maybe_adult)) {
                ?>
                <span>Adult: <?php echo $guest_maybe_adult; ?></span>&nbsp;&nbsp;<span>Kids: <?php echo $guest_maybe_kids; ?></span>
                <?php 
                }
                ?>                
              </div>
            </div>
          </a>
          <div class="card-block ">
            <div class="card border-top-primary  h-100">
              <div class="card-body">
                <div class="icon"><i class="fa-solid fa-reply"></i></div>
                <div class="count">
                 <span><?php echo $guest_reply; ?></span>
                </div>
                <h4 class="text-muted">Yet to respond</h4>
              </div>
            </div>
          </div>
          <a class="card-block" href="<?php echo esc_url($declinedURL);?>">
            <div class="card border-top-primary  h-100">
              <div class="card-body <?php echo $declined_status; ?>">
                <div class="icon"><i class="fa fa-times-circle"></i></div>
                <div class="count">
                  <span><?php echo $guest_declined; ?></span>
                </div>
                <h4 class="text-muted">Declined</h4>
                <?php 
                if(!empty($guest_declined_adult)) {
                ?>
                <span>Adult: <?php echo $guest_declined_adult; ?></span>&nbsp;&nbsp;<span>Kids: <?php echo $guest_declined_kids; ?></span>
                <?php 
                }
                ?>

              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="guests-list">
        <div class="inner tabs-box guests-tabs">
          <div class="guests-box table-box tabs-content">
            <div class="tab active-tab" id="tab-1">
              <div class="d-table-block">
                <div class="inner-box-2">
                  <div class="table-box upcoming-tasks">
                    <div class="guest-list-form-button">
                      <div class="guest-list-form-button-inner">
                        <a class="btn btn-outline"  data-bs-toggle="modal"
                          data-bs-target="#uploadModal">
                          <i class="fa-solid fa-upload me-1"></i>
                          Upload (.csv,.xls)
                        </a>
                        <a class="btn btn-outline" href="<?php echo esc_url('/my-contact/?from=guestlist&card_id='.$card_id.'&event_id='.$event_id);?>">
                          <i class="fa-regular fa-address-card me-1"></i>
                          My Contacts</a>
                        <a class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#shareModal">
                          <i class="fa-solid fa-share-nodes me-1"></i>
                          Share link</a>
                      </div>
                      <div class="add-link">
                        <a data-bs-target="#add-group-popup"  data-bs-toggle="modal" class="btn btn-outline"><i class="fa-solid fa-plus"></i>
                          New Group</a>
                        <a data-bs-target="#add-guest-popup"  data-bs-toggle="modal" class="btn btn-secondary"><i class="fa-solid fa-plus"></i>
                          NEW GUEST</a>
                      </div>
                    </div>
<?php 

if(isset($_GET['status']) && !empty($_GET['status']))
{


if($_GET['status']=='accepted')
{
  $status='Accepted';
}
else if($_GET['status']=='declined')
{
  $status='Declined';
}
else if($_GET['status']=='maybe')
{
  $status='May Be';
}

$get_guest_details = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $guest_details_info_table WHERE guest_user_id = %d AND guest_event_id = %d AND guest_status = %s ORDER BY guest_name ASC",
        $userID,
        $event_id,
        $status
    )
);
}
else{
$get_guest_details = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $guest_details_info_table WHERE guest_user_id = %d AND guest_event_id = %d ORDER BY guest_name ASC",
        $userID,
        $event_id
    )
);
}
?>


                    <div class="vendor-table table-responsive">
                      <table class="vendor-list-table guestlist-table" id="guest-list-Table">
                        <thead>
                          <tr>
                            <th><input type="checkbox" name="allCheck" id="all-select-chechbox guestlist-checkbox-all"></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="contact">status</th>
                            <th>Guest</th>
                            <th class="actions">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($get_guest_details as $guest) { 
                            $id = $guest->guest_id;
                          ?>
                          <tr>
                            <td><input type="checkbox" class="select-checkbox guest-checkbox" data-email="<?php echo $guest->guest_email; ?>" data-guestid="<?php echo $id;?>"></td>
                            <td><?php echo $guest->guest_name; ?></td>
                            <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($guest->guest_email); ?>"><?php echo esc_html($guest->guest_email); ?></td>
                            <td><?php echo $guest->guest_phone_num; ?></td>
                            <td class="contact">
                            <?php 
                            if(empty($guest->guest_status))
                            {
                            ?>
                            <a href="#" class="status-Pending">Draft</a>
                            <?php	
                            }
                            else if($guest->guest_status=='pending')
                            {?>
							<a href="#" class="status-sent">Sent</a>
                            <?php 
                            }
                           	else if($guest->guest_status=='Declined')
                            {?>
							<a href="#" class="status-Pending" style="background:rgba(250, 77, 77, 0.10);color: #f84d4d;"><?php echo ucfirst($guest->guest_status); ?></a>
                            <?php 
                            }                          
                           	else if($guest->guest_status=='Accepted')
                            {?>
							<a href="#" class="status-sent"><?php echo ucfirst($guest->guest_status); ?></a>
                            <?php 
                            }                            
                            else 
                            {?>
							 <a href="#" class="status-Pending"><?php echo ucfirst($guest->guest_status); ?></a>
                            <?php 
                            }	
                            ?>	
                              
                            </td>
                             <td>Adults: <?php echo $guest->guest_adult; ?>, Kids: <?php echo $guest->guest_kids; ?></td>

                            <td class="actions">
                              <a href="javascript:void(0)" data-bs-toggle="modal" onclick="edit_guestlist_details(<?php echo esc_attr($id);?>)" data-bs-target="#edit-popup" class="edit theme-btn">
                                <i class="fa-solid fa-pen"></i>
                              </a>
                              <a href="javascript:void(0)" onclick="delete_guest_details(<?php echo esc_attr($id);?>)" class="delete theme-btn">
                                <i class="fa-regular fa-trash-can"></i>
                              </a>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php

// Step 1: Remove the "data:image/png;base64," part
$encoded_data = preg_replace('#^data:image/\w+;base64,#i', '', $event_front_card_preview);

// Step 2: Decode the Base64 string to get binary data
$image_data = base64_decode($encoded_data);

// Step 3: Get the WordPress uploads directory
$upload_dir = wp_upload_dir();
$file_name = $_GET['card_id'].'1card_image.png'; // You can change this to any file name you prefer
$file_path = $upload_dir['path'] . '/' . $file_name; // Full path to save the file

// Step 4: Save the binary data as a PNG file
file_put_contents($file_path, $image_data);

// Step 5: Get the URL of the saved file
$card_image_url = $upload_dir['url'] . '/' . $file_name;
 ?>

        <div class="guest-list-footer">
          <div class="container-fluid">
            <div class="row align-items-center">
              <div class="col-sm-9">
                <div class="guest-list-footer-inner">
                  <div class="guest-list-footer-iteam">
                    <p>Allow guests to bring additional guests</p>
                    <div class="check-toggle">
                      <span class=""></span>
                    </div>
                  </div>
                  <!-- <div class="guest-list-footer-iteam">
                    <p>Enable other guests to see the list of attendees</p>
                    <div class="check-toggle">
                      <span class=""></span>
                    </div>
                  </div> -->
                </div>
              </div>
              <div class="col-sm-3">
                <div class="links-box-2 justify-content-end">
                   <button type="submit" id="send-invitation-btn" class="btn btn-secondary" data-title="<?php echo $mailtitle;?>" data-preview-url="<?php echo $preview_guest_invitation_url;?>">Send Invitations</button>
                	<input type="hidden" id="event_front_card_preview" name="event_front_card_preview" class="form-control" value="<?php echo esc_url($card_image_url); ?>">
          			<input type="hidden" id="event_id" name="event_id"  value="<?php echo $event_id; ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  



  <div class="wl-right-slide-bar">
   <?php 
         get_template_part('template-parts/dashboard/menu');
    ?> 
</div>
<!-- Add Guest Modal -->
  <div class="modal fade def-popup add-guest-popup" id="add-guest-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h2 class="modal-title"><?php echo esc_html('Guest Details'); ?></h2>
            <button onclick="location.reload();" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span class="cross"></span>
            </button>
          </div>
          <div class="content-box">
             <form id="add-guest-info" method="post" >
              <div class="form-content last">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <input type="text" name="guestname" id="guestname"  class="form-control" placeholder="Name*" required="">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12" id="one">
                    <div class="form-group">
                      <select class="form-control select-group" >
                            <option value="">Choose Group</option>
                             <?php foreach ($get_guest_group as $group) { 
                                $id = $group->guest_group_id;
                                ?>
                                <option value="<?php echo $group->guest_group_name; ?>"><?php echo $group->guest_group_name; ?></option>
                             <?php   }?>                       
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <input type="number" name="guestcontact" id="guestcontact"  class="form-control" placeholder="Phone No">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <input type="email" name="guestemail" id="guestemail" class="form-control" placeholder="Email*">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="links-box">
                      <button type="submit" id="add_guest_details" event-id="<?php echo $event_id ?>" class="btn btn-secondary">Add</button>
                      <button type="button" id="add_guest_details_save" event-id="<?php echo $event_id ?>" class="btn btn-secondary">Save and Add Guest</button>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-6">
                    <div class="links-box">
                     
                    </div>
                  </div>
                </div>
              </div>
               <?php wp_nonce_field('ajax-sanas-save-guest-nonce', 'sanasguestsecurity');?>
               <div class="guestlist_details_message"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
 <!-- Add Guest Modal -->
  <div class="modal fade def-popup add-group-popup" id="add-group-popup" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h2 class="modal-title">Guest Group Managment</h2>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span class="cross"></span>
            </button>
          </div>
          <div class="content-box">
            <form id="form-guestlist-group" method="post">
                <div class="meal-list guest-list-form-box">
                    <h5 class="guest-list-form-title">
                        Add New Group
                    </h5>
                    <ul class="list-unstyled ms-0 guest_group_list_section" id="guest_group_list_section">
                        <?php
                        // Fetch existing groups for the user
                        global $wpdb, $current_user;
                        wp_get_current_user();
                        $userID = $current_user->ID;
                        $table_name = $wpdb->prefix . 'guest_list_group';
                        $existing_groups = $wpdb->get_results(
                            $wpdb->prepare(
                                "SELECT guest_group_name FROM $table_name WHERE guest_group_user = %d AND guest_event_id = %d ",
                                $userID,
                                $event_id,
                            )
                        );
                        foreach ($existing_groups as $group) {
                            echo '<li class="d-flex justify-content-between align-items-center">' .
                                '<span>' . esc_html($group->guest_group_name) . '</span>' .
                                '<a href="javascript:" class="action-links remove-group" data-group-name="' . esc_attr($group->guest_group_name) . '">' .
                                '<i class="fa fa-trash"></i></a></li>';
                        }
                        ?>
                    </ul>
                    <div class="text-muted">
                        <div class="input-group mb-3">
                            <input autocomplete="off" type="text" class="form-control form-light" id="add_new_group_input" placeholder="Add New Group">
                            <div class="input-group-append">
                                <button id="add_new_group_button" class="btn btn-secondary btn-block" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="update_guest_group_button col-sm-6">
                        <button type="submit" id="update_guest_group_button" event-id="<?php echo $event_id ?>" class="btn btn-secondary btn-block">   
                            Save
                        </button>
                    </div>
                </div>
                <?php wp_nonce_field('ajax-user-guestlist-group-nonce', 'security'); ?>
                 <div class="guestlist_guest_details_message"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Add Guest Modal -->
  <div class="modal fade def-popup add-guest-popup" id="edit-popup" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h2 class="modal-title">Update Guest Details</h2>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span class="cross"></span>
            </button>
          </div>
          <div class="content-box">
            <form method="post" id="form-edit-guestlist-details" >
            <?php wp_nonce_field('ajax-update-edit-guest-event-nonce', 'security'); ?>
              <div class="form-content last">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <input type="text" id="editguestname"  name="editguestname" class="form-control" placeholder="Name*" required="">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                     <select class="form-control select-group">
                        <option value="">Choose Group</option>
                        <?php foreach ($get_guest_group as $group) { 
                                $id = $group->guest_group_id;
                                ?>
                                <option value="<?php echo $group->guest_group_name ?>"><?php echo $group->guest_group_name ?></option>
                             <?php   }?>   
                    </select>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <input type="text" id="editguestphone" name="editguestphone" class="form-control" placeholder="Phone No*" required="">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <input type="text" id="editguestemail" name="editguestemail" class="form-control" placeholder="Email*" required="">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="links-box">
                      <input id="guestid" name="guestid" type="hidden" value="" />
                      <button type="submit" id="edit-guestinfo" class="btn btn-secondary btn-block">Save</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="edit_details_message"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--upload Modal -->
  <div class="modal fade" id="uploadModal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
      <form id="csv-upload-form" method="post" enctype="multipart/form-data">
      <div class="modal-content upload-csv-box">
        <div class="modal-header">
          <h4 class="modal-title fs-5">Upload</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="response_csv"></div>
          <div class="upload-btn">
            <input type="file" name="csvFile" id="csvFile" accept=".csv">
            <div class="upload-file-content">
              <span class="upload-icon">
                <i class="upload-icon icon-Upload-2"></i>
              </span>
              <br>
              <a href="#">Click to upload</a>
              <span>or drag and drop</span>
            </div>
          </div>
          <p>Use <a href="#">Sana's Invite Template</a> worksheet and enter your guest names, emails and phone number in the specified format
          </p>
          <p>Remember to save your spreadsheet as a .csv or .xls before uploading.</p>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="eventid" id="eventid" value="<?php echo $_GET['event_id'];?>">
          <button type="button" class="btn btn-secondary btn-block" data-bs-dismiss="modal">Close</button>
          <input  type="submit" class="btn btn-secondary btn-block" value="Upload" />           
        </div>
      </div>
      </form>
    </div>
  </div>
  <div class="modal fade" id="shareModal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="background-image: url(<?php echo  get_template_directory_uri(); ?>/assets/img/sher-link-bg.png);">
        <div class="modal-header">
          <h4 class="modal-title fs-5">Share your Invitation</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="img">
            <img src="<?php echo $event_front_card_preview; ?>" alt="">
          </div>
         <div class="url" style="display:none;">
            <p id="copyurl"><?php echo esc_url($share_guest_preview); ?></p>
          </div>
           <p id="statusMessage" style="margin-top:1rem;"></p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-block" id="copyUrlButton">
            <i class="fa-solid fa-link"></i>
            Copy link</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="savedmodal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" >Your invitation has been <br> seved successfully </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="img">  
            <img src="<?php echo $event_front_card_preview; ?>" alt="">
          </div>
          <div class="modal-footer">
            <a href="<?php echo site_url(); ?>"  class="btn btn-primary-2 btn-block"> Back to Home</a>
          </div>
          <div class="text">
            <p>Checkout wedding vendors at</p>
            <a target="_blank" href="https://www.sanashub.com/">Sana’s hub.com</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" id="guestdetailsdeletemsg" name="guestdetailsdeletemsg" value="<?php esc_html_e('Are you sure you want to delete this guest?','Guestlist'); ?>">
  <input type="hidden" name="header-options-msg" id="header-options-msg" value="Add your guest and send invitation to your be loved one."/>
