<?php 
/**
    Template Name: My Contact   
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
// Fetch events for the current user
global $current_user, $wpdb;
wp_get_current_user();
$userID = $current_user->ID;
$sanas_card_event = $wpdb->prefix . "sanas_card_event";
$guest_details_info_table = $wpdb->prefix . "guest_details_info";
$guest_group_info_table = $wpdb->prefix . "guest_list_group";

$get_event = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $sanas_card_event WHERE event_user = %d ORDER BY event_no DESC",
        $userID
    )
);

$get_guest_group = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $guest_group_info_table WHERE guest_group_user = %d ORDER BY guest_group_name ASC",
        $userID
    )
);

$current_date = new DateTime('now');

// Check if the user came from the guest list page
$showMoveToGuestListButton = isset($_GET['from']) && $_GET['from'] === 'guestlist';
// get card id and event id
$card_id = isset($_GET['card_id']) ? intval($_GET['card_id']) : 0;
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
?>

<div class="wl-dashboard-wrapper dashboard">
    <div class="container-fluid wl-dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h3 class="pageheader-title">My Contacts</h3>
                    <?php if ($showMoveToGuestListButton): ?>
                        <div class="links-box-2">
                            <button type="submit" data-card-id="<?php echo $card_id; ?>" data-event-id="<?php echo $event_id; ?>" class="dashbord-btn move-to-guestlist">Move to Guest List</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (!empty($get_event)) : ?>
            <?php 
            $table_counter = 1;
            foreach ($get_event as $event) : 
                $event_id = $event->event_no;
                $event_card_id = $event->event_card_id;
                
                // Get event details including name
                $event_data = $wpdb->get_row($wpdb->prepare(
                    "SELECT e.*, p.post_title as event_name, p.post_date as event_date, 
                     u.display_name as host_name, p.guid as event_url
                     FROM {$wpdb->prefix}sanas_card_event e
                     LEFT JOIN {$wpdb->posts} p ON e.event_rsvp_id = p.ID
                     LEFT JOIN {$wpdb->users} u ON e.event_user = u.ID
                     WHERE e.event_no = %d",
                    $event_id
                ));
                
                $event_name = $event_data->event_name;
                $event_rsvp_id = $event->event_rsvp_id;

                // Get the event date
                $eventtitle= esc_html(get_post_meta($event_rsvp_id, 'event_name', true));
                $eventDate = esc_html(get_post_meta($event_rsvp_id, 'event_date', true));
                $event_date = new DateTime($eventDate);
                echo $event_date;
                // Compare event date with current date
                if ($event_date < $current_date) {
                    // Fetch guest details for the event
                    $get_guest_details = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM $guest_details_info_table WHERE guest_user_id = %d AND guest_event_id = %d ORDER BY guest_name ASC",
                            $userID,
                            $event_id
                        )
                    );
            ?>
                <div class="guests-list contact">
                    <div class="inner tabs-box guests-tabs">
                        <div class="guests-box table-box tabs-content">
                            <div class="vendor-table table-responsive">
                                <table class="vendor-list-table guest-contact-list-table" id="guest-contact-list-<?php echo $table_counter; ?>">
                                    <thead>
                                        <tr>
                                            <th class="todo-subhead text-align-start hide-sorting-arrow" colspan="6">
                                                <h4><?php echo esc_html($eventtitle); ?></h4>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><input type="checkbox" id="all-select-checkbox-one"></th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Email address">Email address</th>
                                            <th>Group</th>
                                            <th class="actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($get_guest_details as $guest) : ?>
                                            <tr>
                                                <td><input class="gl-checkbox" data-guest-id="<?php echo $guest->guest_id; ?>" type="checkbox"></td>
                                                <td><?php echo esc_html($guest->guest_name); ?></td>
                                                <td><?php echo esc_html($guest->guest_phone_num); ?></td>
                                                <td class="text-single-line" data-event-email="<?php echo esc_attr($guest->guest_email); ?>" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($guest->guest_email); ?>"><?php echo esc_html($guest->guest_email); ?></td>
                                                <td><?php echo esc_html($guest->guest_group); ?></td>
                                                <td class="actions">
                                                    <div>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-guest-id="<?php echo esc_attr($guest->guest_id);?>" data-bs-target="#edit-popup" class="edit theme-btn">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" data-guest-id="<?php echo esc_attr($guest->guest_id);?>" class="delete theme-btn delete-guest-details">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                            <input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('ajax-delete-guest-nonce'); ?>">
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <script>
                                jQuery(document).ready(function() {
                                    jQuery('#guest-contact-list-<?php echo $table_counter; ?>').DataTable({
                                        searching: true,
                                        paging: true,
                                        "order": [],
                                        "ordering": true,
                                        columnDefs: [
                                            { orderable: false, targets: [0, 2, 4, 5] },
                                        ]
                                    });
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            $table_counter++;
                }
            endforeach; ?>
        <?php else : ?>
            <div class="no-events-message">
                <p>No past events found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

  <div class="modal fade def-popup add-guest-popup" id="edit-popup" tabindex="-1" role="dialog"
  aria-hidden="true">
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
          <form method="post" id="form-edit-guestlist-details">
            <?php wp_nonce_field('ajax-update-edit-guest-event-nonce', 'security'); ?>
            <div class="form-content last">
              <div class="row">
                <div class="col-lg-6 col-sm-12">
                  <div class="form-group">
                    <input type="text" id="editguestname" name="editguestname" class="form-control" placeholder="Name" required="">
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                  <div class="form-group">
                    <select class="form-control select-group" id="editguestgroup" name="editguestgroup">
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
                    <input type="hidden" id="guestid" name="guestid" value="">
                    <button type="submit" class="btn btn-secondary btn-block">Save</button>
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

<?php render_modal_html_alert(); ?>
<?php render_confirm_modal_html_alert(); ?>
<?php
get_footer('dashboard');