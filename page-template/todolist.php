<?php 
/**
    * Template Name: To Do List    
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
            <h3 class="pageheader-title">To Do List</h3>
          </div>
        </div>
      </div>
      <div class="todo-list">
        <div class="inner">
          <div class="todo-search-add-link justify-content-end">
            <div class="add-link"><a href="#" class="dashbord-btn" data-bs-toggle="modal" data-bs-target="#add-todolist-popup"><i class="icon-plus"></i> Add Task</a>
            </div>
          </div>
          <div class="title-box">
            <div class="todo-status">
              <p>
              <?php
// Fetch the to-do list items
$todo_items = get_todo_list_items();

// Check if there are no items
if (empty($todo_items)) {
    // Insert a default entry
    global $wpdb;
    $wpdb->insert(
        $wpdb->prefix . 'todo_list',
        array(
            'title' => 'Photography',
            'date' => current_time('mysql'),
            'category' => 'General',
            'notes' => 'photography for the wedding',
            'user_id' => get_current_user_id(),
            'status' => 'Yet To Start',
            'completed' => 0
        )
    );

    // Fetch the updated list of to-do items
    $todo_items = get_todo_list_items();
}

$completed_count = 0;
$pending_count = 0;

// Assuming $todo_items is an array of associative arrays
foreach ($todo_items as $item) {
    if ($item['status'] === 'Completed') { // Use array syntax
        $completed_count++;
    } elseif ($item['status'] === 'In Progress') {
        $pending_count++;
    } elseif ($item['status'] === 'Yet To Start') {
      $pending_count++;
  }
}

$total_count = $completed_count + $pending_count;
$percent_count = ($completed_count > 0) ? ($completed_count * 100) / $total_count : 0;
?>
<p class="max-45">You have completed <span class="tast-count-com"><?php echo $completed_count; ?></span> out of <span class="tast-count-total"><?php echo $total_count; ?></span> tasks</p>
<div class="progress">
    <div id="todo_progressbar" class="progress-bar" role="progressbar" data-percent="<?php echo $percent_count; ?>" data-count="<?php echo $total_count; ?>" style="width: <?php echo $percent_count; ?>%"></div>
</div>
            </div>
        </div>
    <div class="todo-box">
    <div class="row">
        <div class="tasks-col to-do-list-table d-table-block col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="inner-box3">
                <div class="table-box upcoming-tasks">
                    <div class="vendor-table table-responsive todo-table-list m-0">
                        <?php
                        $vendor_items = get_vendor_list_items();
                        ?>
                        <?php if ($todo_items): ?>
                        <?php 
                        $grouped_items = [];

                        foreach ($todo_items as $item) {
                            $item_month = date('F', strtotime($item['date']));
                            $item_year = date('Y', strtotime($item['date']));
                            $current_item_month_year = $item_month . ' ' . $item_year;

                            // Group items by month and year
                            if (!isset($grouped_items[$current_item_month_year])) {
                                $grouped_items[$current_item_month_year] = []; // Create an array for each month
                            }
                            $grouped_items[$current_item_month_year][] = $item; // Add the item to the respective month
                        }
// <span class="year-text">' . $item_year . '</span>'
                        // Generate tables for each month
                        $month_count = 0;
                        $show_all = isset($_GET['show_all']) && $_GET['show_all'] == 'true';

                        foreach ($grouped_items as $month_year => $items): 
                            if ($month_count >= 5 && !$show_all) break;
                            $month_count++;
                        ?>
                            <table class="mb-0">
                            <tr><th class="todo-subhead text-align-start" colspan="6">
                            <?php
                            $month_year = explode(" ", $month_year);
                            ?>
                            <h4><?php echo $month_year[0]; ?> <span class="year-text"><?php echo $month_year[1]; ?></span></h4>
                            </th></tr>
                            </table>
                            <table class="vendor-list-table todo-list-table todo-table" id="todo-table-<?php echo str_replace(' ', '-', $month_year); ?>">
                                <thead>
                                    <tr class="todo-check-title">
                                        <th>Category</th>
                                        <th>Task</th>
                                        <th>Notes</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php usort($items, function($a, $b) {
                                        return strtotime($b['created_at']) - strtotime($a['created_at']);
                                    }); ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr <?php echo ($item['completed'] == 1) ? 'class="text-decoration-line-through pe-none"' : ''; ?>>
                                            <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($item['category']); ?>">
                                                <?php echo esc_html($item['category']); ?>
                                            </td>
                                            <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($item['title']); ?>">
                                                <?php echo esc_html($item['title']); ?>
                                            </td>
                                            <td class="text-single-line text-capitalize" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($item['notes']); ?>">
                                                <?php echo esc_html($item['notes']); ?>
                                            </td>
                                            <td class="text-single-line text-nowrap">
                                                <?php echo DateTime::createFromFormat('Y-m-d', $item['date'])->format('jS M Y'); ?>
                                            </td>
                                            <td>
                                                <select class="status-dropdown mediumfont mobile-dropdown" data-id="<?php echo $item['id']; ?>" data-bs-toggle="tooltip" data-bs-original-title="Yet To Start">
                                                <option value="Yet To Start" <?php echo selected($item['status'], 'Yet To Start', false); ?> data-bs-toggle="tooltip" data-bs-original-title="Yet To Start">⏳</option>
                                        <option value="In Progress" <?php echo selected($item['status'], 'In Progress', false); ?> data-bs-toggle="tooltip" data-bs-original-title="In Progress">🔄</option>
                                        <option value="Completed" <?php echo selected($item['status'], 'Completed', false); ?> data-bs-toggle="tooltip" data-bs-original-title="Completed">✅</option>
                                                </select>
                                                <select class="status-dropdown smallfont desktop-dropdown" data-id="<?php echo $item['id']; ?>" data-bs-toggle="tooltip" data-bs-original-title="Yet To Start">
                                                <option value="Yet To Start" <?php echo selected($item['status'], 'Yet To Start', false); ?> data-bs-toggle="tooltip" data-bs-original-title="Yet To Start">Yet To Start</option>
                                        <option value="In Progress" <?php echo selected($item['status'], 'In Progress', false); ?> data-bs-toggle="tooltip" data-bs-original-title="In Progress">In Progress</option>
                                        <option value="Completed" <?php echo selected($item['status'], 'Completed', false); ?> data-bs-toggle="tooltip" data-bs-original-title="In Progress">Completed</option>
                                                </select>
                                            </td>
                                            <td class="actions">
                                                <div>
                                                    <a href="#" class="edit edit-todo theme-btn" data-bs-toggle="modal" data-bs-target="#edit-todolist-popup" data-id="<?php echo $item['id']; ?>">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="delete theme-btn" data-id="<?php echo $item['id']; ?>">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endforeach; ?>

                        <?php if (!$show_all && count($grouped_items) > 5): ?>
                            <div class="todo-search-add-link justify-content-center">
                                <a href="?show_all=true" class="dashbord-btn">Show All</a>
                            </div>
                        <?php endif; ?>

                        <?php endif; ?>
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



<!-- Add To-Do Modal -->
<div class="modal fade def-popup add-todolist-popup" id="add-todolist-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Add Task</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="cross"></span>
                    </button>
                </div>
                <div class="content-box">
                    <form id="add-todo-form" method="post" action="#">
                        <div class="form-content">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Task*</label>
                                        <input type="text" name="title" class="form-control" placeholder="Task" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="date" id="add-todo-date" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label>Category*</label>
                                    <input type="text" name="category" class="form-control" required="">
                                </div>
                                <!-- <div class="form-group col-lg-12 col-sm-12">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" placeholder="Description" required=""></textarea>
                                </div> -->
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label>Notes</label>
                                    <textarea name="notes" class="form-control" maxlength="250" placeholder="Notes"></textarea>
                                </div>
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

<!-- Edit To-Do Modal -->
<div class="modal fade def-popup add-todolist-popup" id="edit-todolist-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Task</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="cross"></span>
                    </button>
                </div>
                <div class="content-box">
                    <form id="edit-todo-form" method="post" action="#">
                        <div class="form-content">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Task*</label>
                                        <input type="text" name="title" id="edit-todo-title" class="form-control" placeholder="Task" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="date" id="edit-todo-date" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label>Category*</label>
                                    <input type="text" name="category" id="edit-todo-category" class="form-control" required="">
                                </div>
                                <!-- <div class="form-group col-lg-12 col-sm-12">
                                    <label>Description</label>
                                    <textarea name="description" id="edit-todo-description" class="form-control" placeholder="Description" required=""></textarea>
                                </div> -->
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label>Notes</label>
                                    <textarea name="notes" id="edit-todo-notes" class="form-control" placeholder="Notes"></textarea>
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <div class="links-box">
                                        <input type="hidden" name="id" id="edit-todo-id">
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