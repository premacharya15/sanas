<?php 
/**
    Template Name: My Vendors   
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
            <h3 class="pageheader-title"> My Vendors</h3>
          </div>
        </div>
      </div>
      <div class="vendor">
        <div class="inner">
          <div class="todo-search-add-link justify-content-end">
            <div class="add-link">
                <a href="#" class="" data-bs-toggle="modal" data-bs-target="#add-todolist-popup"> Add Vendor</a>
            </div>
          </div>
          <div class="todo-box">
            <div class="row">
              <div class="to-do-list-table d-table-block col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="inner-box3">
                  <div class="table-box upcoming-tasks">
                    <div class="vendor-table table-responsive m-0">
                      <table class="vendor-list-table my-vendor-table" id="vendor-table">
                        <thead>
                        <tr>
                          <th>Category</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Ph#</th>
                          <th>Notes</th>
                          <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Social Madia Profile">Social Madia Profile</th>
                          <th>Pricing</th>
                          <th class="actions">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $my_vendor_items = get_my_vendor_list_items();
                        if ($my_vendor_items) {
                            usort($my_vendor_items, function($a, $b) {
                                return strtotime($b['created_at']) - strtotime($a['created_at']);
                            });
                        ?>
                            <?php foreach ($my_vendor_items as $my_vendor): ?>
                                <tr>
                                    <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['category']); ?>"><?php echo esc_html($my_vendor['category']); ?></td>
                                    <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['name']); ?>"><?php echo esc_html($my_vendor['name']); ?></td>
                                    <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['email']); ?>"><?php echo esc_html($my_vendor['email']); ?></td>
                                    <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['phone']); ?>"><?php echo esc_html($my_vendor['phone']); ?></td>
                                    <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['notes']); ?>"><?php echo esc_html($my_vendor['notes']); ?></td>
                                    <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['social_media_profile']); ?>"><?php echo esc_html($my_vendor['social_media_profile']); ?></td>
                                    <td>$<?php echo esc_html($my_vendor['pricing']); ?></td>
                                    <td class="actions">
                                      <div>
                                        <a href="#" class="edit edit-myvendor theme-btn" data-id="<?php echo esc_attr($my_vendor['id']); ?>" data-bs-toggle="modal" data-bs-target="#edit-todolist-popup">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="#" class="delete theme-btn" data-id="<?php echo esc_attr($my_vendor['id']); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                      </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
            <form method="post" action="#" id="add-my-vendor-form">
              <div class="form-content">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Category*</label>
                      <input type="text" class="form-control" name="category" required="">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Name*</label>
                      <input type="text" class="form-control" name="name" required="">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="number" class="form-control" name="phone">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label> Social Madia Profile</label>
                      <input type="text" class="form-control" name="social_media_profile">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Pricing</label>
                      <input type="number" class="form-control" name="pricing">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" maxlength="250"></textarea>
                  </div>
                  <div class="form-group col-lg-12 col-sm-12">
                    <div class="links-box">
                      <button type="submit" data-id="0" class="dashbord-btn">Save</button>
                      <button type="submit" data-id="1" class="dashbord-btn">Save and Add Another Vendor</button>
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
            <form method="post" action="#" id="edit-my-vendor-form">
              <div class="form-content">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Category</label>
                      <input type="text" class="form-control" name="category" id="edit-my-vendor-category">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" id="edit-my-vendor-name">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" id="edit-my-vendor-email">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="number" class="form-control" name="phone" id="edit-my-vendor-phone">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label> Social Madia Profile</label>
                      <input type="text" class="form-control" name="social_media_profile" id="edit-my-vendor-social-media-profile">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Pricing</label>
                      <input type="number" class="form-control" name="pricing" id="edit-my-vendor-pricing">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" maxlength="250" id="edit-my-vendor-notes"></textarea>
                  </div>
                  <div class="form-group col-lg-12 col-sm-12">
                    <div class="links-box">
                      <input type="hidden" name="id" id="edit-my-vendor-id">
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