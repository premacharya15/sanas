<?php 
/**
    Template Name: Vendor List 
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
        <div class="link text-right">
          <a href="#" class="add-link-btn move-vendor-btn" data-id="<?php echo esc_attr($vendor['id']); ?>">Move to My Vendors</a>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
          <div class="page-header d-flex flex-column align-items-baseline gap-2 title">
            <h3 class="pageheader-title m-0">Vendors List</h3>
            <p class="m-0">Add your party vendors, then move your selected vendors to the "My Vendors" Page.</p>
          </div>
        </div>
      </div>
      <div class="vendor">
        <div class="inner">
          <div class="todo-search-add-link justify-content-end">
            <div class="add-link">
                <a href="#" class="" data-bs-toggle="modal" data-bs-target="#add-todolist-popup">Add Vendor</a>
            </div>
          </div>
          <div class="todo-box">
            <div class="row">
              <div class="to-do-list-table d-table-block col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="inner-box3">
                  <div class="table-box upcoming-tasks">
                    <div class="vendor-table table-responsive m-0">
                        <?php
                        $vendor_items = get_vendor_list_items();
                          global $wpdb;
                          $current_user_id = get_current_user_id();
                        ?>
                      <table class="vendor-list-table vendor-table-list" id="vendor-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="allCheck" id="all-select-chechbox"></th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Ph#</th>
                                <th>Notes</th>
                                <th class="text-single-line">Social Madia Profile</th>
                                <th>Pricing</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $vendor_items = get_vendor_list_items();
                        usort($vendor_items, function($a, $b) {
                            return strtotime($b['created_at']) - strtotime($a['created_at']);
                        });
                        
                        if ($vendor_items): ?>
                            <?php foreach ($vendor_items as $vendor): ?>
                                <tr>
                                    <td><input type="checkbox" class="checkSingle"></td>
                                    <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['category']); ?>"><?php echo esc_html($vendor['category']); ?></td>
                                    <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['name']); ?>"><?php echo esc_html($vendor['name']); ?></td>
                                    <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['email']); ?>"><?php echo esc_html($vendor['email']); ?></td>
                                    <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['phone']); ?>"><?php echo esc_html($vendor['phone']); ?></td>
                                    <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['notes']); ?>"><?php echo esc_html($vendor['notes']); ?></td>
                                    <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['social_media_profile']); ?>"><?php echo esc_html($vendor['social_media_profile']); ?></td>
                                    <td>$<?php echo esc_html($vendor['pricing']); ?></td>
                                    <td class="actions">
                                      <div>
                                        <a href="#" class="edit theme-btn" data-id="<?php echo esc_attr($vendor['id']); ?>" data-bs-toggle="modal" data-bs-target="#edit-todolist-popup">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="#" class="delete theme-btn" data-id="<?php echo esc_attr($vendor['id']); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                      </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade def-popup add-todolist-popup" id="add-todolist-popup" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h4 class="modal-title">Add Vendor</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span class="cross"></span>
            </button>
          </div>
          <div class="content-box">
            <form id="add-vendor-form" method="post" action="#">
              <div class="form-content">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Category*</label>
                      <input type="text" name="category" class="form-control" required="">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Name*</label>
                      <input type="text" name="name" class="form-control" required="">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="number" name="phone" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Social Media Profile</label>
                      <input type="text" name="social_media_profile" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Pricing</label>
                      <input type="number" name="pricing" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control"></textarea>
                  </div>
                  <div class="form-group col-lg-12 col-sm-12">
                    <div class="links-box">
                      <button type="submit" class="dashbord-btn">Save</button>
                      <button type="submit" id="add-new-vendor" class="dashbord-btn">Save and Add Another Vendor</button>                    
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
  <div class="modal fade def-popup add-todolist-popup" id="edit-todolist-popup" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h4 class="modal-title">Edit Vendor</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span class="cross"></span>
            </button>
          </div>
          <div class="content-box">
            <form method="post" id="edit-vendor-form" action="#">
              <div class="form-content">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Category</label>
                      <input type="text" name="category" id="edit-vendor-category" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" id="edit-vendor-name" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="email" id="edit-vendor-email" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="number" name="phone" id="edit-vendor-phone" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label> Social Madia Profile</label>
                      <input type="text" name="social_media_profile" id="edit-vendor-social-media-profile" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Pricing</label>
                      <input type="number" name="pricing" id="edit-vendor-pricing" class="form-control">
                    </div>
                  </div> 
                  <div class="col-lg-12 col-sm-12">
                    <label>Notes</label>
                    <textarea name="notes" id="edit-vendor-notes" class="form-control"></textarea>
                  </div>
                  <div class="form-group col-lg-12 col-sm-12">
                    <div class="links-box">
                      <input type="hidden" name="id" id="edit-vendor-id">
                      <button type="submit" class="dashbord-btn">Save</button>
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

<?php render_confirm_modal_html_alert(); ?>
<?php render_modal_html_alert(); ?>
<?php
get_footer('dashboard');

