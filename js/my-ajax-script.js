document.addEventListener('DOMContentLoaded', () => {
    const tooltipTriggerList = document.querySelectorAll('[data-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // Function to show the modal
    function show_confirm_modal_html_alert() {
        jQuery('#exampleConfirmModalLabel').text('Logout');
        jQuery('#confirm_modal-body-text').text('Are you sure you want to logout?');
        jQuery('#confirm_modal_html_alert').modal('show');
    }

    // Track if logout button was clicked
    let logoutBtnClicked = false;

    // Logout button event listener 
    jQuery('.logout-btn').on('click', function(e) {
        e.preventDefault();
        logoutBtnClicked = true;
        show_confirm_modal_html_alert();
    });

    // Handle "Yes" button click in the confirmation modal
    jQuery('#modal-yes-button').on('click', function () {
        if (logoutBtnClicked) {
            const logoutUrl = jQuery('.logout-btn a').data('logout-url');
            window.location.href = logoutUrl;
        }
        logoutBtnClicked = false;
    });

    // Handle "No" button click in the confirmation modal
    jQuery('#modal-no-button').on('click', function () {
        logoutBtnClicked = false;
        jQuery('#confirm_modal_html_alert').modal('hide');
    });
});
function getQueryParam(param) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}
if (window.location.pathname === '/budget/') {
    jQuery(document).ready(function($) {
        jQuery('.add-expense-trigger').on('click', function() {
            var category = getQueryParam('category');
            jQuery('#category-id-input').val(category); 
        })
        var table = jQuery('.budget-table-sort').DataTable({
            "ordering": false,
            "createdRow": function (row, data, dataIndex) {
                if (dataIndex === jQuery('.budget-table-sort').DataTable().data().length - 1) {
                    jQuery('td', row).each(function () {
                        jQuery(this).attr('data-order', '');
                    });
                }
                // Check if this is the total row
                if (data[0] === 'Total') {
                    jQuery(row).addClass('expense-total-row');
                }
            },
            "drawCallback": function(settings) {
                // Move the total row to the bottom
                var api = this.api();
                var totalRow = api.rows('.expense-total-row').nodes();
                if (totalRow.length) {
                    jQuery(totalRow).appendTo(api.table().body());
                }
            }
        });
jQuery('.budget-category-item .ttl').on('click', function() {
    var categoryId = jQuery(this).data('id');
    jQuery('#category-id-input').val(categoryId);
    jQuery('#category-id-input-edit').val(categoryId);
    console.log(categoryId);
    jQuery('#category_cost_section li').removeClass('active');
    jQuery(this).parent().addClass('active');
    var categoryText = jQuery(this).find('span.txt').text();
    jQuery('.category_name_box').html(categoryText);
    var categoryIcon = jQuery(this).find('.ttl i').prop('outerHTML');
    jQuery('#budget-expense-box .icon-box').html(categoryIcon);

    $.ajax({
        method: 'POST',
        url: ajax_object.ajax_url,
        data: {
            category_id: categoryId,
            action: 'get_budget_expense_by_category'
        },
        success: function(response) {
            jQuery('html, body').animate({
                scrollTop: jQuery('#budget-expense-box').offset().top
            }, 300);
            window.history.pushState(null, '', '?category=' + categoryId);
            if (response.success) {
                var expenses = response.data.expenses;
                if (expenses.length === 0) {
                    jQuery('#budget-expense tbody').html('<tr><td colspan="8">No expenses to display.</td></tr>');
                    return;
                }

                // Sort expenses by created_at in descending order
                expenses.sort(function(a, b) {
                    return new Date(b.created_at) - new Date(a.created_at);
                });

                var total_estimated = 0;
                var total_actual = 0;
                var total_paid = 0;
                var total_due = 0;
                var rows = '';
                table.clear();
                let dataRows = [];
                expenses.forEach(function(expense) {
                    total_estimated += parseFloat(expense.estimated_cost);
                    total_actual += parseFloat(expense.actual_cost);
                    total_paid += parseFloat(expense.paid);
                    total_due += parseFloat(expense.actual_cost) - parseFloat(expense.paid);

                    dataRows.push([
                        '<span class="expense text-single-line" data-toggle="tooltip" data-bs-original-title="' + escapeHtml(expense.expense) + '">' + escapeHtml(expense.expense) + '</span>',
                        '<span class="text-single-line" data-toggle="tooltip" data-bs-original-title="' + escapeHtml(expense.vendor_name) + '">' + escapeHtml(expense.vendor_name) + '</span>',
                        '<span class="text-single-line" data-toggle="tooltip" data-bs-original-title="' + (expense.vendor_contact ? '+' + escapeHtml(expense.vendor_contact) : '') + '">' + (expense.vendor_contact ? '+' + escapeHtml(expense.vendor_contact) : '') + '</span>',
                        '<span class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="' + escapeHtml(expense.estimated_cost) + '">$' + escapeHtml(expense.estimated_cost) + '</span>',
                        '<span class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="' + escapeHtml(expense.actual_cost) + '">$' + escapeHtml(expense.actual_cost) + '</span>',
                        '<span class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="' + escapeHtml(expense.paid) + '">$' + escapeHtml(expense.paid) + '</span>',
                        '<span class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="' + (parseFloat(expense.actual_cost) - parseFloat(expense.paid)).toFixed(2) + '">$' + (parseFloat(expense.actual_cost) - parseFloat(expense.paid)).toFixed(2) + '</span>',
                        '<span class="actions"><div>' +
                            '<a href="#" class="edit edit-expense theme-btn" data-id="' + escapeHtml(expense.id) + '" data-bs-toggle="modal" data-bs-target="#edit-expense-popup">' +
                                '<i class="fa-solid fa-pen"></i>' +
                            '</a>' +
                            '<a href="#" class="delete theme-btn" data-id="' + escapeHtml(expense.id) + '">' +
                                '<i class="fa-regular fa-trash-can"></i>' +
                            '</a>' +
                        '</div></span>'
                    ]);
                });

                // Add total row
                dataRows.push(['<td class="text-single-line">Total</td>',
    '<td>&nbsp;</td>',
    '<td>&nbsp;</td>',
    '<td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="' + total_estimated.toFixed(2) + '">$' + total_estimated.toFixed(2) + '</td>',
    '<td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="' + total_actual.toFixed(2) + '">$' + total_actual.toFixed(2) + '</td>',
    '<td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="' + total_paid.toFixed(2) + '">$' + total_paid.toFixed(2) + '</td>',
    '<td class="text-single-line number-align-right" data-toggle="tooltip" data-bs-original-title="' + total_due.toFixed(2) + '">$' + total_due.toFixed(2) + '</td>',
    '<td class="actions">&nbsp;</td>'
                ]);
                table.rows.add(dataRows).draw();

                // Update the table body with the new rows
                jQuery('#budget-expense tbody').html(rows);
                jQuery('.category_estimated').text(total_estimated.toFixed(2));
                jQuery('.category_actual').text(total_actual.toFixed(2));
                jQuery('.category_due').text(total_due.toFixed(2)); // Ensure total due is displayed
            } else {
                table.clear().draw();
                jQuery('#budget-expense tbody').html('<tr><td colspan="8">No expenses to display.</td></tr>');
            }
        },
        
        error: function() {
            alert('Error loading expenses.');
        }
    });
});
// Escape HTML for safety
function escapeHtml(text) {
    if (text == null) return ''; // Return empty string for null or undefined
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

    // Edit Expense Item
    jQuery(document).on('click', '.edit-expense', function(e) {
        e.preventDefault();
        var expenseId = jQuery(this).data('id');
        var categoryId = jQuery('#category-id-input').val();
        console.log(expenseId + " " + jQuery(this).data('id'));
        console.log(categoryId + " " + jQuery('#category-id-input-edit').val());
        // set the category ID in the hidden input field
        jQuery('#category-id-input-edit').val(categoryId);
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: { id: expenseId, category_id: categoryId, action: 'get_expense_details' },
            success: function(response) {
                if (response.success) {
                    jQuery('#edit-expense-id').val(response.data.id);
                    jQuery('#edit-expense-name').val(response.data.expense);
                    jQuery('#edit-vendor-name').val(response.data.vendor_name);
                    jQuery('#edit-vendor-contact').val(response.data.vendor_contact);
                    jQuery('#edit-estimated-cost').val(response.data.estimated_cost);
                    jQuery('#edit-actual-cost').val(response.data.actual_cost);
                    jQuery('#edit-paid').val(response.data.paid);
                    jQuery('#category-id-input-edit').val(response.data.category_id);
                    jQuery('#edit-expense-popup').modal('show');
                } else {
                    alert('Failed to fetch expense details.');
                }
            }
        });
    });

    // Edit Expense form
    jQuery('#edit-expense-form').submit(function(e) {
        e.preventDefault();
        var formData = jQuery(this).serialize();
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: formData + '&action=edit_expense',
            success: function(response) {
                if (response.success) {
                    // jQuery('#edit-expense-popup').modal('hide');
                    // set the modal title and message
                    // jQuery('#exampleModalLabel').text('Success');
                    // jQuery('#modal-body-text').text(response.data);
                    // jQuery('#modal_html_alert').modal('show');
                    // jQuery('#render-modal-yes-button').on('click', function() {
                        location.reload();
                    // });
                } else {
                    // set the modal title and message
                    jQuery('#exampleModalLabel').text('Error');
                    jQuery('#modal-body-text').text(response.data);
                    // show the modal
                    jQuery('#modal_html_alert').modal('show');
                    // handle the click event on the "Yes" button in the modal
                    jQuery('#render-modal-yes-button').on('click', function() {
                        jQuery('#modal_html_alert').modal('hide');
                    });
                }
            }
        });
    });

        // Function to show the modal
        function show_alert_message3(title, message) {
            jQuery('#exampleConfirmModalLabel').text(title);
            jQuery('#confirm_modal-body-text').text(message);
            jQuery('#confirm_modal_html_alert').modal('show');
        }
        
        jQuery('#modal-yes-button').on('click', function () {
            proceedWithRemovalExpense();
            jQuery('#confirm_modal_html_alert').modal('hide');
        });
        
        // delete expense
        function proceedWithRemovalExpense() {
            var expenseId = currentExpenseId;
        
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: { id: expenseId, action: 'delete_expense' },
                success: function(response) {   
                    if (response.success) {
                        location.reload();
                    } else {
                        // set the modal title and message
                        jQuery('#exampleModalLabel').text('Error');
                        jQuery('#modal-body-text').text(response.data);
                        // show the modal
                        jQuery('#modal_html_alert').modal('show');
                        // handle the click event on the "Yes" button in the modal
                        jQuery('#render-modal-yes-button').on('click', function() {
                            jQuery('#modal_html_alert').modal('hide');
                        });
                    }
                }
            });
        }
        
        // Keep track of the expense ID for the current action
        var currentExpenseId;
        
        // Click handler for the delete icon
        jQuery(".expense-delete").on("click", function (e) {
            e.preventDefault();
            currentExpenseId = jQuery(this).data("id");
        
            show_alert_message3('Delete Expense', 'Do you want to delete this entry?');
        });

    // Add Budget Category Item
    jQuery('#add-budget-category-form').submit(function(e) {
        e.preventDefault();
        var formData = jQuery(this).serialize();
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: formData + '&action=add_budget_category_item',
            success: function(response) {
                if (response.success) {
                    // Hide add-vendor-popup
                    jQuery('#add-category-popup').modal('hide');

                    // jQuery('#exampleModalLabel').text('Success');
                    // jQuery('#modal-body-text').text('Category item added successfully.');

                    // jQuery('#modal_html_alert').modal('show');

                    // jQuery('#render-modal-yes-button').on('click', function() {
                        // window.location.reload();
                        window.location.href = "/budget/?category=" + response.data.category_id + "#budget-expense-box";
                    // });
                } else {
                    // Set the modal title and message
                    jQuery('#exampleModalLabel').text('Error');
                    jQuery('#modal-body-text').text(response.data);
                    // Show the modal
                    jQuery('#modal_html_alert').modal('show');

                    // Handle the click event on the "Yes" button in the modal
                    jQuery('#render-modal-yes-button').on('click', function() {
                        jQuery('#modal_html_alert').modal('hide');
                    })
                }
            }
        });
    });


    // Function to show the modal
    function show_alert_message2(title, message) {
        jQuery('#exampleConfirmModalLabel').text(title);
        jQuery('#confirm_modal-body-text').text(message);
        jQuery('#confirm_modal_html_alert').modal('show');
    }
    
    // When "Yes" button is clicked
    jQuery('#modal-yes-button').on('click', function () {
        // Trigger the removal process
        proceedWithRemoval();
        jQuery('#confirm_modal_html_alert').modal('hide');
    });
    
    // Function to handle the AJAX call for removal
    function proceedWithRemoval() {
        var vendorId = currentVendorId;
    
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: { id: vendorId, action: 'delete_budget_category_item' },
            success: function(response) {   
                if (response.success) {
                    location.reload();
                } else {
                    // alert(response.data);  
                }
            }
        });
    }
    
    // Keep track of the vendor ID for the current action
    var currentVendorId;
    
    // Click handler for the delete icon
    jQuery(".category-delete").on("click", function (e) {
        e.preventDefault();
        currentVendorId = jQuery(this).data("id");
    
        show_alert_message2('Delete Category', 'Do you want to delete this entry?');
    });


    // jQuery('.delete').on('click', function() {
    //     var categoryId = jQuery(this).data('id');
    //     if (confirm('Do you want to delete this entry?')) {
    //         $.ajax({
    //             type: 'POST',
    //             url: ajax_object.ajax_url,
    //                 data: { id: categoryId, action: 'delete_budget_category_item' },
    //             success: function(response) {
    //                 if (response.success) {
    //                     alert(response.data);
    //                     location.reload();
    //                 } else {
    //                     alert(response.data);
    //                 }
    //             }
    //         });
    //     }
    // });

    function loadExpenses() {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'get_expenses_ajax'
            },
            success: function(response) {
                jQuery('#budget-expense tbody').html(response);
            }
        });
    }
    loadExpenses();
    

    jQuery('.clear-budget-btn').on('click', function() {
        jQuery('#confirm_modal_html_alert').modal('show');
        jQuery('#confirm_modal_html_alert #confirm_modal-body-text').text('Do you want to clear all values in your budget, including categories, expenses, and vendor information? Please be aware that once cleared, this information cannot be retrieved.');
        jQuery('#confirm_modal_html_alert').addClass('clear-budget-confirmation-modal');
        jQuery('.clear-budget-confirmation-modal #modal-yes-button').on('click', function(event) {
            event.preventDefault();
            console.log('clicked');
            jQuery('#confirm_modal_html_alert').removeClass('clear-budget-confirmation-modal');
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'clear_budget'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data);
                    }
                }
            });
        });
    });

});
}
if (window.location.pathname === '/to-do-list/' || window.location.pathname === '/my-dashboard/') {
document.addEventListener('DOMContentLoaded', () => {
    const today = new Date();
    document.getElementById('edit-todo-date').value = today.toISOString().split('T')[0];
    document.getElementById('add-todo-date').value = today.toISOString().split('T')[0];
  });
jQuery(document).ready(function($) {
    jQuery('#add-todo-form').submit(function(e) {
        e.preventDefault();
        var formData = jQuery(this).serialize();
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: formData + '&action=add_todo_item',
            success: function(response) {
                if (response.success) {
                    jQuery('#add-todolist-popup').modal('hide');
                    // jQuery('#exampleModalLabel').text('Success');
                    // jQuery('#modal-body-text').text(response.data);
                    // jQuery('#modal_html_alert').modal('show');
                    recalculate_task();
                    // jQuery('#render-modal-yes-button').on('click', function() {
                        location.reload();
                    // });
                } else {
                    jQuery('#exampleModalLabel').text('Error');
                    jQuery('#modal-body-text').text(response.data);
                    jQuery('#modal_html_alert').modal('show');
                    jQuery('#render-modal-yes-button').on('click', function() {
                        jQuery('#modal_html_alert').modal('hide');
                    });
                }
            }
        });
    });

    // Edit To-Do Item
    jQuery('#edit-todo-form').submit(function(e) {
        e.preventDefault();
        var formData = jQuery(this).serialize();
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: formData + '&action=edit_todo_item',
            success: function(response) {
                if (response.success) {
                    jQuery('#edit-todolist-popup').modal('hide');
                    // jQuery('#exampleModalLabel').text('Success');
                    // jQuery('#modal-body-text').text(response.data);
                    // jQuery('#modal_html_alert').modal('show');
                    // jQuery('#render-modal-yes-button').on('click', function() {
                        location.reload();
                    // });
                } else {
                    jQuery('#exampleModalLabel').text('Error');
                    jQuery('#modal-body-text').text(response.data);
                    jQuery('#modal_html_alert').modal('show');
                    jQuery('#render-modal-yes-button').on('click', function() {
                        jQuery('#modal_html_alert').modal('hide');
                    });
                }
            }
        });
    });

  
  jQuery(".checkSingle").on("change", function () {
    var $checkbox = jQuery(this);
    var completed = $checkbox.is(":checked") ? 1 : 0;
    var todoId = $checkbox.attr("id").split("-").pop();

    $.ajax({
      type: "POST",
      url: ajax_object.ajax_url,
      data: {
        action: "toggle_todo_completed",
        id: todoId,
        completed: completed,
        security: ajax_object.security // Include if you're using a nonce for security
      },
      success: function (response) {
        if (response.success) {
            //
        } else {
          console.log("Something went wrong: " + response.data);
        }
      }
    });
  });
   // Function to show the modal
    function show_alert_message2(title, message) {
        jQuery('#exampleConfirmModalLabel').text(title);
        jQuery('#confirm_modal-body-text').text(message);
        jQuery('#confirm_modal_html_alert').modal('show');
    }

    // When "Yes" button is clicked
    jQuery('#modal-yes-button').on('click', function () {
        // Trigger the removal process
        proceedWithRemoval();
        jQuery('#confirm_modal_html_alert').modal('hide');
    });

    // Function to handle the AJAX call for removal
    function proceedWithRemoval() {
        var todoId = currentTodoId;

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: { id: todoId, action: 'delete_todo_item' },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    // Set the modal title and message
                    jQuery('#exampleModalLabel').text('Error');
                    jQuery('#modal-body-text').text(response.data);
                    // Show the modal
                    jQuery('#modal_html_alert').modal('show');

                    // Handle the click event on the "Yes" button in the modal
                    jQuery('#render-modal-yes-button').on('click', function() {
                        jQuery('#modal_html_alert').modal('hide');
                    });
                }
            }
        });
    }

    var currentTodoId;
    jQuery(".delete").on("click", function (e) {
        e.preventDefault();
        currentTodoId = jQuery(this).data("id");
        show_alert_message2('Delete Task', 'Do you want to delete this task?');
    });
    
function countDropdowns() {
var totalDropdowns = jQuery('.todo-list .status-dropdown').length;
var completedDropdowns = jQuery('.todo-list .status-dropdown').filter(function() {
  return jQuery(this).val() === 'Completed';
}).length;
return { total: totalDropdowns, completed: completedDropdowns };
}
function recalculate_task(){
    var counts = countDropdowns();
    var countmultiple = 100 / counts.total;
    var percent = countmultiple * counts.completed;
    jQuery('.tast-count-com').text(counts.completed);
    jQuery('.tast-count-total').text(counts.total);
    jQuery('#todo_progressbar').css('width', percent + '%');
}
    jQuery(".status-dropdown").on("change", function () {
        var status = jQuery(this).val();
        var id = jQuery(this).data("id");

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'update_todo_status',
                status: status,
                id: id,
                security: ajax_object.security
            },
            success: function (response) {
                if (response.success) {
                    recalculate_task();
                } else {
                }
            }
        });
    });
    jQuery('.edit-todo').on('click', function() {
        var todoId = jQuery(this).data('id');
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: { id: todoId, action: 'get_todo_item' },
            success: function(response) {
                if (response.success) {
                    jQuery('#edit-todo-id').val(response.data.id);
                    jQuery('#edit-todo-title').val(response.data.title);
                    jQuery('#edit-todo-date').val(response.data.date);
                    jQuery('#edit-todo-category').val(response.data.category);
                    jQuery('#edit-todo-notes').val(response.data.notes);
                    jQuery('#edit-todolist-popup').modal('show');
                }
            }
        });
    });
    const tooltipTriggerList = document.querySelectorAll('[data-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
});
}

if (window.location.pathname === '/vendors-list/') {
    jQuery(document).ready(function($) {
        jQuery('#add-vendor-form').submit(function(e) {
            e.preventDefault();
            var formData = jQuery(this).serialize();
            var addAnother = jQuery(e.originalEvent.submitter).attr('id') === 'add-new-vendor';
            
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: formData + '&action=add_vendor_item',
                success: function(response) {
                    if (response.success) {
                        if (addAnother) {
                            jQuery('#add-vendor-form').append('<p id="temporary-message">Vendor item added successfully.</p>');
                            setTimeout(function() {
                                jQuery('#temporary-message').fadeOut(500, function() {
                                    jQuery(this).remove();
                                });
                            }, 3000);
                            jQuery('#vendor-table tbody').html(response.data);
                            jQuery('#add-vendor-form')[0].reset();
                            jQuery('#add-todolist-popup').modal('show');
                        } else {
                            jQuery('#add-todolist-popup').modal('hide');
                            // jQuery('#exampleModalLabel').text('Success');
                            // jQuery('#modal-body-text').text('Vendor item added successfully.');
                            // jQuery('#modal_html_alert').modal('show');
                            // jQuery('#render-modal-yes-button').on('click', function() {
                                location.reload();
                            // });
                        }
                    } else {
                        alert(response.data);
                    }
                }
            });
        });

        // Select All Checkbox
        jQuery('#all-select-chechbox').on('change', function() {
            var allChecked = jQuery(this).is(':checked');
            jQuery('.checkSingle').prop('checked', allChecked);
        });

        // Get Vendor Item for Editing
        jQuery('.edit').on('click', function() {
            var vendorId = jQuery(this).data('id');
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: { id: vendorId, action: 'get_vendor_list_item' },
                success: function(response) {
                    if (response.success) {
                        jQuery('#edit-vendor-id').val(response.data.id);
                        jQuery('#edit-vendor-category').val(response.data.category);
                        jQuery('#edit-vendor-name').val(response.data.name);
                        jQuery('#edit-vendor-email').val(response.data.email);
                        jQuery('#edit-vendor-phone').val(response.data.phone);
                        jQuery('#edit-vendor-notes').val(response.data.notes);
                        jQuery('#edit-vendor-social-media-profile').val(response.data.social_media_profile);
                        jQuery('#edit-vendor-pricing').val(response.data.pricing);
                        jQuery('#edit-todolist-popup').modal('show');
                    }
                }
            });
        });

        // Edit Vendor Item
        jQuery('#edit-vendor-form').submit(function(e) {
            e.preventDefault();
            var formData = jQuery(this).serialize();
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: formData + '&action=edit_vendor_item',
                success: function(response) {
                    if (response.success) {
                        // jQuery('#edit-todolist-popup').modal('hide');
                        
                        // jQuery('#exampleModalLabel').text('Success');
                        // jQuery('#modal-body-text').text(response.data);
                        
                        // jQuery('#modal_html_alert').modal('show');
                        // jQuery('#render-modal-yes-button').on('click', function() {
                            location.reload();
                        // });
                    } else {
                        alert(response.data);
                    }
                }
            });
        });

        jQuery(document).ready(function($) {
            // Move to My Vendors List button click
            jQuery('.add-link-btn').on('click', function(e) {
                e.preventDefault();
                var selectedVendors = jQuery('.checkSingle:checked').map(function() {
                    return jQuery(this).closest('tr').find('.edit').data('id');
                }).get();

                if (selectedVendors.length === 0) {
                    // alert('Please select at least one vendor to move to the "My Vendors" page.');
                    // Set the modal title and message
                    jQuery('#exampleModalLabel').text('Error');
                    jQuery('#modal-body-text').text('Please select at least one vendor to move to the "My Vendors" page.');
                    // Show the modal
                    jQuery('#modal_html_alert').modal('show');

                    // Handle the click event on the "Yes" button in the modal
                    jQuery('#render-modal-yes-button').on('click', function() {
                        jQuery('#modal_html_alert').modal('hide');
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: ajax_object.ajax_url,
                        data: {
                            action: 'move_vendors_to_my_list',
                            vendor_ids: selectedVendors
                        },
                        success: function(response) {
                            if (response.success) {
                                // Set the modal title and message
                                jQuery('#exampleModalLabel').text('Success');
                                jQuery('#modal-body-text').text(response.data);
                                // Show the modal
                                jQuery('#modal_html_alert').modal('show');

                                // Handle the click event on the "Yes" button in the modal
                                jQuery('#render-modal-yes-button').on('click', function() {
                                    location.reload();
                                });
                            } else {
                                // Set the modal title and message
                                jQuery('#exampleModalLabel').text('Error');
                                jQuery('#modal-body-text').text(response.data);
                                // Show the modal
                                jQuery('#modal_html_alert').modal('show');

                                // Handle the click event on the "Yes" button in the modal
                                jQuery('#render-modal-yes-button').on('click', function() {
                                    jQuery('#modal_html_alert').modal('hide');
                                });
                            }
                        }
                    });
                }
            });
        });

        // Function to show the modal
        function show_alert_message2(title, message) {
            jQuery('#exampleConfirmModalLabel').text(title);
            jQuery('#confirm_modal-body-text').text(message);
            jQuery('#confirm_modal_html_alert').modal('show');
        }

        // When "Yes" button is clicked
        jQuery('#modal-yes-button').on('click', function () {
            // Trigger the removal process
            proceedWithRemoval();
            jQuery('#confirm_modal_html_alert').modal('hide');
        });

        // Function to handle the AJAX call for removal
        function proceedWithRemoval() {
            var vendorId = currentVendorId;

            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: { id: vendorId, action: 'delete_vendor_item' },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data);  
                    }
                }
            });
        }

        // Keep track of the vendor ID for the current action
        var currentVendorId;

        // Click handler for the delete icon
        jQuery(".delete").on("click", function (e) {
            e.preventDefault();
            currentVendorId = jQuery(this).data("id");

            show_alert_message2('Delete Vendor', 'Are you sure you want to delete this vendor?');
        });
    });
}

if (window.location.pathname === '/my-vendors/' || window.location.pathname === '/my-dashboard/') {
    jQuery(document).ready(function($) {
        let buttonDataId;
        jQuery('#add-my-vendor-form button[type="submit"]').click(function() {
            buttonDataId = jQuery(this).data('id');
        });
        jQuery('#add-my-vendor-form').submit(function(e) {
            e.preventDefault();
            var formData = jQuery(this).serialize();
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: formData + '&action=add_my_vendor_item',
                success: function(response) {
                    if (response.success) {
                        if(buttonDataId == 0){
                            jQuery('#add-todolist-popup').modal('hide');
                            // jQuery('#exampleModalLabel').text('Success');
                            // jQuery('#modal-body-text').text('Vendor item added successfully.');
                            // jQuery('#modal_html_alert').modal('show');
                            // jQuery('#render-modal-yes-button').on('click', function() {
                                location.reload();
                            // });
                        }
                        if(buttonDataId == 1){
                            // add temporary message
                            jQuery('#add-my-vendor-form').append('<p id="temporary-message">Vendor item added successfully.</p>');
                            setTimeout(function() {
                                jQuery('#temporary-message').fadeOut(500, function() {
                                    jQuery(this).remove();
                                });
                            }, 3000);
                            // Update the vendor table with the new data
                            jQuery('#vendor-table tbody').html(response.data);
                            // Clear form fields
                            jQuery('#add-my-vendor-form')[0].reset();
                            // Open the form again (assuming it's in a modal)
                            jQuery('#add-todolist-popup').modal('show');
                        }
                    } else {
                        // Set the modal title and message
                        jQuery('#exampleModalLabel').text('Error');
                        jQuery('#modal-body-text').text(response.data);
                        // Show the modal
                        jQuery('#modal_html_alert').modal('show');

                        // Handle the click event on the "Yes" button in the modal
                        jQuery('#render-modal-yes-button').on('click', function() {
                            jQuery('#modal_html_alert').modal('hide');
                        });
                    }
                }
            });
        });

        // Get My Vendor Item for Editing
        jQuery('.edit-myvendor').on('click', function() {
            console.log('edit');
            var vendorId = jQuery(this).data('id');
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: { id: vendorId, action: 'get_my_vendor_list_item' },
                success: function(response) {
                    if (response.success) {
                        jQuery('#edit-my-vendor-id').val(response.data.id);
                        jQuery('#edit-my-vendor-category').val(response.data.category);
                        jQuery('#edit-my-vendor-name').val(response.data.name);
                        jQuery('#edit-my-vendor-email').val(response.data.email);
                        jQuery('#edit-my-vendor-phone').val(response.data.phone);
                        jQuery('#edit-my-vendor-notes').val(response.data.notes);
                        jQuery('#edit-my-vendor-social-media-profile').val(response.data.social_media_profile);
                        jQuery('#edit-my-vendor-pricing').val(response.data.pricing);
                        jQuery('#edit-vendor-popup').modal('show');
                    }
                }
            });
        });

        // Edit My Vendor Item
        jQuery('#edit-my-vendor-form').submit(function(e) {
            e.preventDefault();
            var formData = jQuery(this).serialize();
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: formData + '&action=edit_my_vendor_item',
                success: function(response) {
                    if (response.success) {
                        jQuery('#edit-todolist-popup').modal('hide');
                        // jQuery('#exampleModalLabel').text('Success');
                        // jQuery('#modal-body-text').text(response.data);
                        // jQuery('#modal_html_alert').modal('show');
                        // jQuery('#render-modal-yes-button').on('click', function() {
                            location.reload();
                        // });
                    } else {
                        jQuery('#exampleModalLabel').text('Error');
                        jQuery('#modal-body-text').text(response.data);
                        jQuery('#modal_html_alert').modal('show');
                        jQuery('#render-modal-yes-button').on('click', function() {
                            jQuery('#modal_html_alert').modal('hide');
                        });
                    }
                }
            });
        });

        // Function to show the modal
        function show_alert_message2(title, message) {
            jQuery('#exampleConfirmModalLabel').text(title);
            jQuery('#confirm_modal-body-text').text(message);
            jQuery('#confirm_modal_html_alert').modal('show');
        }
        jQuery('#modal-yes-button').on('click', function () {
            proceedWithRemoval();
            jQuery('#confirm_modal_html_alert').modal('hide');
        });
        
        // Function to handle the AJAX call for removal
        function proceedWithRemoval() {
            var vendorId = currentVendorId;
        
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: { id: vendorId, action: 'delete_my_vendor_item' },
                success: function(response) {   
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data);  
                    }
                }
            });
        }
        
        // Keep track of the vendor ID for the current action
        var currentVendorId;
        
        // Click handler for the delete icon
        jQuery(".delete").on("click", function (e) {
            e.preventDefault();
            currentVendorId = jQuery(this).data("id");
        
            show_alert_message2('Delete My Vendor', 'Do you want to delete this entry?');
        });
    }); 
}


if (window.location.pathname === '/my-favorites/') {
    jQuery(document).ready(function ($) {
        // Function to show the modal
        function show_alert_message2(title, message) {
            jQuery('#exampleConfirmModalLabel').text(title);
            jQuery('#confirm_modal-body-text').text(message);
            jQuery('#confirm_modal_html_alert').modal('show');
        }

        // When "Yes" button is clicked
        jQuery('#modal-yes-button').on('click', function () {
            // Trigger the removal process
            proceedWithRemoval();
            jQuery('#confirm_modal_html_alert').modal('hide');
        });

        // Function to handle the AJAX call for removal
        function proceedWithRemoval() {
            var $icon = jQuery('.wishlist-delete-icon[data-card-id="' + currentCardId + '"]');

            $.ajax({
                url: sanas_ajax_object.ajax_url,
                type: "POST",
                data: {
                    action: "remove_from_wishlist",
                    card_id: currentCardId,
                    security: sanas_ajax_object.security,
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        console.log("Something went wrong. Please try again.");
                    }
                },
            });
        }

        // Keep track of the card ID for the current action
        var currentCardId;

        // Click handler for the delete icon
        jQuery(".wishlist-delete-icon").on("click", function (e) {
            e.preventDefault();
            currentCardId = jQuery(this).data("card-id");

            show_alert_message2('Delete Favorite', 'Do you want to remove this card from My Favorites?');
        });
    });
}


jQuery(document).ready(function ($) {
    // Update Profile
    jQuery('form.profile-update').on('submit', function (e) {
        e.preventDefault();
        var data = {
            action: 'update_profile',
            first_name: jQuery('form.profile-update input[name="first_name"]').val(),
            last_name: jQuery('form.profile-update input[name="last_name"]').val(),
            email: jQuery('form.profile-update input[name="email"]').val(),
            phone: jQuery('form.profile-update input[name="phone"]').val(),
            about: jQuery('form.profile-update textarea[name="about"]').val(),
        };

        $.post(ajax_object.ajax_url, data, function (response) {
            jQuery(".profile-info-title h4").text(jQuery('form.profile-update input[name="first_name"]').val() + ' ' + jQuery('form.profile-update input[name="last_name"]').val());
            jQuery(".profile-info-text").text(jQuery('form.profile-update textarea[name="about"]').val());
            jQuery("#tab-11 .form-box").append(response.success ? 'Profile updated successfully!' : response.data);
        });
    });

    // Update Social Media Links
    jQuery('form.social-update').on('submit', function (e) {
        e.preventDefault();
        var data = {
            action: 'update_profile',
            facebook: jQuery('form.social-update input[name="facebook"]').val(),
            twitter: jQuery('form.social-update input[name="twitter"]').val(),
            instagram: jQuery('form.social-update input[name="instagram"]').val(),
            youtube: jQuery('form.social-update input[name="youtube"]').val(),
        };

        $.post(ajax_object.ajax_url, data, function (response) {
            alert(response.success ? 'Social links updated successfully!' : response.data);
        });
    });

 // Change Password
jQuery('form.change-password').on('submit', function (e) {
    e.preventDefault();

    var data = {
        action: 'change_password',
        current_password: jQuery('form.change-password input[name="current_password"]').val(),
        new_password: jQuery('form.change-password input[name="new_password"]').val(),
        security: ajax_object.change_password_nonce // Nonce for security
    };

    $.post(ajax_object.ajax_url, data, function (response) {
        if (response.success) {
            alert('Password updated successfully!');
        } else {
            alert(response.data || 'An error occurred.');
        }
    });
});


    // Delete Account
    jQuery('.delete-account-btn').on('click', function () {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            $.post(ajax_object.ajax_url, { action: 'delete_account' }, function (response) {
                if (response.success) {
                    alert('Account deleted successfully!');
                    window.location.href = ajax_object.home_url; // Redirect to homepage or login
                } else {
                    alert('Error deleting account');
                }
            });
        }
    });

    // Update Profile Picture
    jQuery('#edit-image-btn').on('click', function() {
        jQuery('#profile-image-upload').click();
    });

    jQuery('#profile-image-upload').on('change', function() {
        var file_data = jQuery('#profile-image-upload').prop('files')[0];
        var form_data = new FormData();
        form_data.append('image', file_data);
        form_data.append('action', 'upload_user_profile_image');

        showPreloader( "Loading..." );

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            contentType: false,
            processData: false,
            data: form_data,
            success: function(response) {
                hidePreloader();
                if (response.success) {
                    jQuery("#tab-18 .my-profile-box").append('Profile image updated successfully!');
                    // Update all elements with the class 'user-profile-image' with the new image URL
                    jQuery('.user-profile-image').attr('src', response.data.url);
                    hidePreloader();
                    console.log(response.data.url);
                } else {
                    alert('Failed to upload image: ' + response.data);
                    hidePreloader();
                }
            },
            error: function() {
                alert('Error uploading image.');
                hidePreloader();
            }
        });
    });
});

jQuery(document).ready(function($) {
    jQuery('#add-expense-form').submit(function(e) {
        e.preventDefault();
        var formData = jQuery(this).serialize();
        formData += '&action=add_expense'; // Append the action for WP AJAX

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url, // URL from localized script
            data: formData,
            success: function(response) {
                if (response.success) {
                    // jQuery('#add-expense-popup').modal('hide');
                    // jQuery('#exampleModalLabel').text('Success');
                    // jQuery('#modal-body-text').text('Expense item added successfully.');
                    // jQuery('#modal_html_alert').modal('show');
                    // jQuery('#render-modal-yes-button').on('click', function() {
                        location.reload();
                    // });

                } else {
                     // Set the modal title and message
                    jQuery('#exampleModalLabel').text('Error');
                    jQuery('#modal-body-text').text(response.data);
                    // Show the modal
                    jQuery('#modal_html_alert').modal('show');

                    // Handle the click event on the "Yes" button in the modal
                    jQuery('#render-modal-yes-button').on('click', function() {
                        jQuery('#modal_html_alert').modal('hide');
                    })
                }
            },
            error: function() {
                alert('Failed to process the request.');
            }
        });
    });
});