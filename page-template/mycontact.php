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
?>

<div class="wl-dashboard-wrapper dashboard">
    <div class="container-fluid wl-dashboard-content">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="pageheader-title mb-0"> My Contacts</h3>
            <div class="links-box-2 ">
              <button type="submit" class="dashbord-btn">Move to Guest List </button>
            </div>
          </div>
        </div>
      </div>
      <div class="guests-list contact">
        <div class="inner tabs-box guests-tabs">
          <div class="guests-box tabs-content">
            <div class="table-responsive">
              <table class="table data-table display" id="guest-contact-list">
                <thead>
                  <tr>
                    <th class="todo-subhead text-align-start" colspan="6">
                      <h4>Wedding Invite</h4>
                    </th>
                  </tr>
                  <tr>
                    <th><input type="checkbox" id="all-select-chechbox-one"> </th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email address</th>
                    <th>Group</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td>Olivia Rhye</td>
                    <td>+1-212-456-7890</td>
                    <td>olivia@untitledui.com</td>
                    <td>Groom Friend</td>
                    <td>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#edit-popup" class="edit theme-btn">
                        <i class="fa-solid fa-pen"></i>
                      </a>
                      <a href="#" class="delete theme-btn">
                        <i class="fa-regular fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-xxl-2 col-lg-4  col-sm-6 m-auto">
          </div>
        </div>
      </div>
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