<?php 
/**
    Template Name: Budget 
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
<?php
    global $wpdb;
    $current_user_id = get_current_user_id();
    $table_name = $wpdb->prefix . 'budget_expense';
    $totals = $wpdb->get_row(
        $wpdb->prepare("
            SELECT 
                COALESCE(SUM(estimated_cost), 0) AS total_estimated,
                COALESCE(SUM(actual_cost), 0) AS total_actual,
                COALESCE(SUM(paid), 0) AS total_paid
            FROM $table_name
            WHERE user_id = %d
        ", $current_user_id)
    );
?>

<div class="wl-dashboard-wrapper dashboard">
    <div class="container-fluid wl-dashboard-content">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="page-header">
            <h3 class="pageheader-title">Budget Calculator</h3>
          </div>
        </div>
      </div>
      <div class="dashboard-inner-box">
        <div class="specs-widget">
          <div class="row">
            <div class="card-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="card border-top-primary h-100">
                <div class="card-body">
                  <div class="text-muted">Estimated</div>
                  <div class="icon"><i class="fa-solid fa-list" aria-hidden="true"></i></div>
                  <div class="count">
                    <span>$<?php echo number_format($totals->total_estimated, 2); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="card border-top-primary h-100">
                <div class="card-body">
                  <div class="text-muted">Actual</div>
                  <div class="icon"><i class="fa fa-chart-line" aria-hidden="true"></i></div>
                  <div class="count">
                    <span>$<?php echo number_format($totals->total_actual, 2); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="card border-top-primary h-100">
                <div class="card-body">
                  <div class="text-muted">Paid</div>
                  <div class="icon"><i class="fa fa-check-square"></i></div>
                  <div class="count">
                    <span>$<?php echo number_format($totals->total_paid, 2); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
              <div class="card border-top-primary h-100">
                <div class="card-body">
                  <div class="text-muted">Due</div>
                  <div class="icon"><i class="fa fa-file-alt"></i></div>
                  <div class="count">
                    <span>$<?php echo number_format($totals->total_actual - $totals->total_paid, 2); ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="budget-man">
        <div class="inner">
            <div class="title-box">
              <div class="title"><h4>Manage Budget</h4>
              <p>Select from below categories or add new category, then enter expense for each</p>
            </div>
            <div class="link ml-auto">
              <a href="javascript:void(0);" class="text-nowrap">Clear Budget</a>
            </div>
          </div>
          <div class="budget-man-box">
            <div class="row row-gap-5 budget-cat-row">
              <div class="cat-col col-xl-4 col-lg-12 col-md-12 col-sm-12">
                <div class="links-box">
                  <div class="links">
                      <div class="add-link align-items-center">
                        <a href="#" class="dashbord-btn" data-bs-toggle="modal" data-bs-target="#add-category-popup"> Add Category</a>
                      </div>
                    <ul class="p-0" id="category_cost_section">
                      <?php
                      $categories = get_all_budget_categories();
                      ?>
                      <?php if ($categories): ?>
                      <?php $expense_totals = $wpdb->get_results(
                            $wpdb->prepare("
                                SELECT category_id, SUM(estimated_cost) as total_expense 
                                FROM {$wpdb->prefix}budget_expense
                                WHERE user_id = %d
                                GROUP BY category_id
                            ", $current_user_id),
                            OBJECT_K
                        );
                        $i = 0;
                        // Sort categories by created_at date in descending order
                        usort($categories, function($a, $b) {
                            return strtotime($b['created_at']) - strtotime($a['created_at']);
                        });
                        foreach ($categories as $index => $category) {
                            $category_id = $category['id'];
                            if($i == 0){
                              $first_category = $category_id;
                              $first_category_name = $category['category_name'];
                              $first_category_icon = !empty($category['icon_class']) ? $category['icon_class'] : strtolower(substr($category['category_name'], 0, 1));
                              $i++;
                            }
                            $total_expense = isset($expense_totals[$category_id]) ? $expense_totals[$category_id]->total_expense : 0;
                            if($total_expense != 0 && $total_expense != 0.00){
                              $js_categories[] = esc_js($category['category_name']);
                              $js_expenses[] = (float) $total_expense;
                            }
                            ?>
                            
                            <li <?php echo (empty($_GET['category']) && $index === 0) || (isset($_GET['category']) && $_GET['category'] == $category_id) ? ' class="active"' : ''; ?>>
                                <a href="/budget/?category=<?php echo esc_attr($category_id); ?>#budget-expense-box"> <!--  class="budget-category-item" -->
                                    <div class="ttl" data-id="<?php echo esc_attr($category['id']); ?>">
                                        <i class="fa-solid fa-<?php echo !empty($category['icon_class']) ? esc_attr($category['icon_class']) : strtolower(substr($category['category_name'], 0, 1)); ?>"></i>
                                        <span class="txt"><?php echo esc_html($category['category_name']); ?></span>
                                    </div>
                                    <div class="count">
                                        <span>$<?php echo number_format($total_expense, 2); ?></span>
                                        <i class="fa fa-trash<?php echo $category['user_id'] != 0 ? ' delete category-delete' : ''; ?>" <?php echo $category['user_id'] != 0 ? 'data-id="' . esc_attr($category['id']) . '"' : ''; ?>></i>
                                    </div>
                                </a>
                            </li>
                            
                            <?php
                        } ?>
                      <?php endif; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <!--Budget Column-->
              <div class="budget-col col-xl-8 col-lg-12 col-md-12 col-sm-12">
                <div class="info-box">
                  <div class="info-top-box">
                    <div class="info">
                      <div class="title">Budget</div>
                      <div class="subtitle">ESTIMATED COST</div>
                      <div class="p-box">
                        <span class="curr">$</span>
                        <span class="amount"><?php echo $totals->total_estimated; ?></span>
                      </div>
                      <div class="instr">To edit estimated cost edit estimated cost on expenses.</div>
                    </div>
                    <div class="graph-box">
                      <div class="title">Total Budget</div>
                      <div class="graph">
                      <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
</div>
<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
</div>
</div> <canvas id="chart-line2" width="299" height="340" class="chartjs-render-monitor" style="display: block; width: 299px; height: 340px;"></canvas>
                      </div>
                    </div>
                  </div>
                  <!-- <p class="text-center mb-3 px-3">Scroll Down To Add Expenses Under Each Category</p> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="budget-man-box col-12" id="budget-expense-box">
        <div class="inner">
          <div class="lower-box">
            <div class="info-box">
              <div class="cat-info">
                <?php
                if(isset($_GET['category'])){
                  $category_id = intval($_GET['category']);
                  $category_name = $wpdb->get_var(
                      $wpdb->prepare("SELECT category_name FROM {$wpdb->prefix}budget_category WHERE id = %d", $category_id)
                  );
                  $category_icon = $wpdb->get_var(
                      $wpdb->prepare("SELECT icon_class FROM {$wpdb->prefix}budget_category WHERE id = %d", $category_id)
                  );
                  if ($category_name) {
                      $first_category = $category_id;
                      $first_category_name = $category_name;
                  }
                  if($category_icon){
                    $first_category_icon = $category_icon;
                  }else{
                    $first_category_icon = strtolower(substr($category_name, 0, 1));
                  }
              }
              ?>
                <div class="icon-box"><i class="fa-solid fa-<?php echo $first_category_icon; ?>"></i></div>
                <div class="category_name_box"><?php echo $first_category_name; ?></div>
                <div class="cost">
                  <?php
                  if(isset($_GET['category'])){
                    $first_category = intval($_GET['category']);
                  }else{
                    $first_category = $first_category;  
                  }
                  $first_category_expenses = get_expense_list($first_category);
                  $total_estimated = 0;
                  $total_actual = 0;
                  
                  if (!empty($first_category_expenses)) {
                      foreach ($first_category_expenses as $expense) {
                          $total_estimated += $expense['estimated_cost'];
                          $total_actual += $expense['actual_cost'];
                      }
                  }
                  ?>
                  <span class="c-text">Estimated cost: <span class="category_estimated">$<?php echo number_format($total_estimated, 2); ?></span></span>
                  <span class="c-text">Actual cost: <span class="category_actual">$<?php echo number_format($total_actual, 2); ?></span></span>
                </div>
              </div>
            </div>
            <div class="add-link justify-content-between">
               <div class="title">
                <h4>Expense</h4>
               </div>
              <a href="#" class="dashbord-btn add-expense-trigger" data-bs-toggle="modal" data-bs-target="#add-expense-popup"> Add New
                Expense</a>
            </div>
            <div class="table-box upcoming-tasks">
              <div class="table-responsive">
                <table class="vendor-table vendor-list-table budget-table-sort expense-list-table" id="budget-expense">
                  <thead>
                    <tr>
                      <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Expense">Expense</th>
                      <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Vendor Name">Vendor Name</th>
                      <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Vendor Contact Info">Vendor Contact Info</th>
                      <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Estimated Cost">Estimated Cost</th>
                      <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Actual Cost">Actual Cost</th>
                      <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Paid">Paid</th>
                      <th class="text-single-line" data-toggle="tooltip" data-bs-original-title="Due">Due</th>
                      <th class="actions">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $expense_category = isset($_GET['category']) ? $_GET['category'] : $first_category;
                    $expenses = get_expense_list($expense_category);
                    $total_estimated = 0;
                    $total_actual = 0;
                    $total_paid = 0;
                    $total_due = 0;
                    
                    if (!empty($expenses)) {
                        usort($expenses, function($a, $b) {
                            return strtotime($b['created_at']) - strtotime($a['created_at']);
                        });
                        foreach ($expenses as $expense) {
                            $total_estimated += $expense['estimated_cost'];
                            $total_actual += $expense['actual_cost']; 
                            $total_paid += $expense['paid'];
                            $total_due = $total_actual - $total_paid;
                            ?>
                            <tr>
                                <td class="expense text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($expense['expense']); ?>"><?php echo esc_html($expense['expense']); ?></td>
                                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($expense['vendor_name']); ?>"><?php echo esc_html($expense['vendor_name']); ?></td>
                                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo !empty($expense['vendor_contact']) ? '+' . esc_html($expense['vendor_contact']) : ''; ?>"><?php echo !empty($expense['vendor_contact']) ? '+' . esc_html($expense['vendor_contact']) : ''; ?></td>
                                <td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($expense['estimated_cost']); ?>">$<?php echo esc_html($expense['estimated_cost']); ?></td>
                                <td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($expense['actual_cost']); ?>">$<?php echo esc_html($expense['actual_cost']); ?></td>
                                <td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($expense['paid']); ?>">$<?php echo esc_html($expense['paid']); ?></td>
                                <td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($expense['actual_cost'] - $expense['paid']); ?>">$<?php echo esc_html(number_format($expense['actual_cost'] - $expense['paid'], 2)); ?></td>
                                <td class="actions">
                                  <div>
                                    <a href="#" class="edit edit-expense edit-expense-trigger theme-btn" data-id="<?php echo esc_attr($expense['id']); ?>" data-bs-toggle="modal" data-bs-target="#edit-expense-popup">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="#" class="delete expense-delete theme-btn" data-id="<?php echo esc_attr($expense['id']); ?>">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                  </div>
                                </td>
                            </tr>
                        <?php }
                    }else{
                        echo '<tr><td class="text-nowrap">No expense found</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                    }
                    ?>
                    <tr class="expense-total-row">
                        <td class="text-single-line">Total</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($total_estimated); ?>">$<?php echo esc_html(number_format($total_estimated, 2)); ?></td>
                        <td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($total_actual); ?>">$<?php echo esc_html(number_format($total_actual, 2)); ?></td>
                        <td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($total_paid); ?>">$<?php echo esc_html(number_format($total_paid, 2)); ?></td>
                        <td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($total_due); ?>">$<?php echo esc_html(number_format($total_due, 2)); ?></td>
                        <td class="actions">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade def-popup add-category-popup" id="add-category-popup" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h4 class="modal-title">Add Category</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span class="cross"></span>
            </button>
          </div>
          <div class="content-box">
            <form method="post" action="#" id="add-budget-category-form">
              <div class="form-content">
                <div class="row">
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group ">
                      <label>CATEGORY NAME</label>
                      <input type="text" class="form-control" name="category_name" required>
                    </div>
                  </div>
                  <!-- <div class="col-lg-6 col-sm-12">
                    <div class="form-group ">
                      <label>COST</label>
                      <input type="number" class="form-control" name="cost" required>
                    </div>
                  </div> -->
                  <div class="form-group col-lg-12 col-sm-12">
                    <div class="links-box">
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
  <div class="modal fade def-popup add-expense-popup" id="add-expense-popup" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h4 class="modal-title">Add Expense</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span class="cross"></span>
            </button>
          </div>
          <div class="content-box">
            <form id="add-expense-form" method="post" action="#">
              <div class="form-content">
                <div class="row">
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Expense*</label>
                      <input type="text" name="expense" class="form-control" required="">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Vendor Name</label>
                      <input type="text" name="vendor_name" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Vendor Contact Info</label>
                      <input type="number" name="vendor_contact" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Estimated Cost</label>
                      <input type="number" step="0.01" name="estimated_cost" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Actual Cost</label>
                      <input type="number" step="0.01" name="actual_cost" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Paid</label>
                      <input type="number" step="0.01" name="paid" class="form-control">
                    </div>
                  </div>
                  <input type="hidden" name="category_id" id="category-id-input" value="<?php echo isset($first_category) ? esc_attr($first_category) : ''; ?>">
                  <div class="form-group col-lg-12 col-sm-12">
                    <div class="links-box">
                      <button type="submit" class="dashbord-btn">Save</button>
                      <!-- <button type="submit" id="add-new-expense" class="dashbord-btn">Save and Add Another Expense</button>                     -->
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
  <div class="modal fade def-popup add-expense-popup" id="edit-expense-popup" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h4 class="modal-title">Edit Expense</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span class="cross"></span>
            </button>
          </div>
          <div class="content-box">
            <form method="post" id="edit-expense-form" action="#">
              <div class="form-content">
                <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Expense*</label>
                      <input type="text" name="expense" class="form-control" id="edit-expense-name" required="">
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                      <label>Vendor Name</label>
                      <input type="text" name="vendor_name" id="edit-vendor-name" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Vendor Contact Info</label>
                      <input type="number" name="vendor_contact" id="edit-vendor-contact" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Estimated Cost</label>
                      <input type="number" step="0.01" name="estimated_cost" id="edit-estimated-cost" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Actual Cost</label>
                      <input type="number" step="0.01" name="actual_cost" id="edit-actual-cost" class="form-control">
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                      <label>Paid</label>
                      <input type="number" step="0.01" name="paid" id="edit-paid" class="form-control">
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-sm-12">
                    <div class="links-box">
                      <input type="hidden" name="category_id" id="category-id-input-edit" value="<?php echo isset($first_category) ? esc_attr($first_category) : ''; ?>">
                      <input type="hidden" name="id" id="edit-expense-id">
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
  <?php 
$js_expenses = isset($js_expenses) && is_array($js_expenses) ? $js_expenses : [];
$js_expenses = json_decode(json_encode($js_expenses), true);
if (array_reduce($js_expenses, fn($carry, $item) => $carry && ($item == 0 || $item == 0.00), true)) {
    $key = array_search(0, $js_expenses, true);
    if ($key === false) {
        $key = array_search(0.00, $js_expenses, true);
    }
    if ($key !== false) {
        $js_expenses[$key] = 100;
    }
}
?>
  <!-- <script>
    jQuery(document).ready(function () {
      if (jQuery('#donut-chart-1').length) {
        
        var options = {
            series: expenses,
            colors: randomColors,
            labels: categories,
            markers: false,
            chart: {
                type: 'donut',
                width: 380
            },
            legend: {
              show: true,
              position: 'bottom',
              formatter: function(seriesName, opts) {
                // Show legend only for the first 10 series
                return opts.seriesIndex < 10 ? seriesName : '';
              }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '55%'
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 380
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var chart = new ApexCharts(document.querySelector("#donut-chart-1"), options);
        chart.render();
    }
    });
  </script> -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
<script>
      jQuery(document).ready(function() {
        var categories = <?php echo json_encode($js_categories); ?>;
        var expenses = <?php echo json_encode($js_expenses); ?>;
        function getRandomLightColor() {
            var letters = '89ABCDEF'; // Start with lighter values (higher values) for more lightness
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * letters.length)];
            }
            return color;
        }

        var randomColors = categories.map(function() {
            return getRandomLightColor();
        });
        var ctx = jQuery("#chart-line2");
        var myLineChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categories,
                datasets: [{
                    data: expenses,
                    backgroundColor: randomColors
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 0
                },
                title: {
                    display: false
                },
                legend: {
                    position: 'bottom',
                    display: true,
                    labels: {
                        fontColor: "#333",
                        fontSize: 12,
                        boxWidth: 10,
                        padding: 10
                    }
                }
            }
        });
    });
    </script>
<?php render_confirm_modal_html_alert(); ?>
<?php render_modal_html_alert(); ?>
<?php
get_footer('dashboard');
