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

$get_event = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM $sanas_card_event WHERE event_user = %d ORDER BY event_no DESC",
        $userID
    )
);

?>

<div class="wl-dashboard-wrapper dashboard">
    <div class="container-fluid wl-dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h3 class="pageheader-title mb-0">My Contacts</h3>
                    <div class="links-box-2">
                        <button type="submit" class="dashbord-btn">Move to Guest List</button>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($get_event)) : ?>
            <?php 
            $table_counter = 1;
            foreach ($get_event as $event) : ?>
                <?php
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
                        <div class="guests-box tabs-content">
                            <div class="table-responsive">
                                <table class="table data-table display" id="guest-contact-list-<?php echo $table_counter; ?>">
                                    <thead>
                                        <tr>
                                            <th class="todo-subhead text-align-start" colspan="6">
                                                <h4><?php echo esc_html($event_name); ?></h4>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th><input type="checkbox" id="all-select-checkbox-one"></th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email address</th>
                                            <th>Group</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($get_guest_details as $guest) : ?>
                                            <tr>
                                                <td><input type="checkbox"></td>
                                                <td><?php echo esc_html($guest->guest_name); ?></td>
                                                <td><?php echo esc_html($guest->guest_phone_num); ?></td>
                                                <td><?php echo esc_html($guest->guest_email); ?></td>
                                                <td><?php echo esc_html($guest->guest_group); ?></td>
                                                <td class="actions">
                                                    <div>
                                                        <a href="#" class="edit theme-btn" data-bs-toggle="modal" data-bs-target="#edit-popup">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <a href="#" class="delete theme-btn">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <script>
                                jQuery(document).ready(function() {
                                    jQuery('#guest-contact-list-<?php echo $table_counter; ?>').DataTable();
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            $table_counter++;
            endforeach; ?>
        <?php endif; ?>
    </div>
</div>

  <div class="modal fade def-popup add-guest-popup" id="edit-popup" tabindex="-1" role="dialog"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-header">
          <h2 class="modal-title">Guest Details</h2>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="cross"></span>
          </button>
        </div>
        <div class="content-box">
          <form method="post" action="#">
            <div class="form-content last">
              <div class="row">
                <div class="col-lg-6 col-sm-12">
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" required="">
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                  <div class="form-group group-option-inner">
                    <select class="form-control group-option">
                      <option value="">Choose Group</option>
                      <option value="">group-2</option>
                      <option value="">group-3</option>
                      <option value="">group-4</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                  <div class="form-group">
                    <input type="number" class="form-control" placeholder="Phone No" required="">
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                  <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="">
                  </div>
                </div>
                <div class="col-lg-12 col-sm-12">
                  <div class="links-box">
                    <button type="submit" class="btn btn-secondary btn-block">Save</button>
                    <button type="submit" class="btn btn-secondary btn-block">Save and Add Guest</button>
                    <button class="btn btn-secondary gt-delete-btn"><i class="fa-regular fa-trash-can"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer('dashboard');