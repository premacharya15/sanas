jQuery(document).ready(function ($) {
// Sanas Signin Login Popup js
    // Sanas Signin Login Popup js
$('button.usersignin').on('click', function (e) {
    e.preventDefault();
    var ajaxValue = $('#ajaxvalue').val();
    var datahref = $('#datahref').val();
    if (ajaxValue == '0') {
        var currentPageURL = window.location.href;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'sanas_signin_user_status',
                'email': $('#signinEmail').val(),
                'password': $('#signinPassword').val(),
                'current_url': currentPageURL,
                'security': $('#usersigninsecurity').val()
            },
            success: function (data) {
                $('#signinresponseMessage').html(data.message).show();
                $('#signinresponseMessagepopup').html(data.message).show();
                 setTimeout(function() {
                        $('#signinresponseMessage').fadeOut(); // Or use .hide() to just hide it without fading
                        $('#signinresponseMessagepopup').fadeOut(); // Or use .hide() to just hide it without fading
                    }, 3000); // 5000 milliseconds = 5 seconds
                if (data.loggedin) {
                    // Remove the d-none class to show the success popup
                    $('.content-succes').removeClass('d-none');
                    $('.form-boxed .login').addClass('d-none');

                       setTimeout(function() {
                        if (datahref) {
                            window.location.href = datahref;
                        } else {
                            window.location.reload();
                        }
                        }, 1000); 
                } 
                else {
                    // Hide the success popup if login fails
                    $('.content-succes').addClass('d-none');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX Error: ' + textStatus, errorThrown);
            }
        });
    }
});  
// Sanas Signup Login Popup js
    $('form#usersignup').on('submit', function (e) {
        e.preventDefault();
        $('#signupresponseError').hide();
        var datahref = $('#datahref1').val();

        if (!isValidForm()) {
            return false;
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'sanas_signup_user_status',
                'username': $('#signupUsername').val(),
                'yourname': $('#signupYourname').val(),
                'email': $('#signupEmail').val(),
                'password': $('#signupPassword').val(),
                'security': $('#usersignupsecurity').val()
            },
            success: function (data) {
                // show success popup
                if (data.register) {
                    $('#signupresponseMessage').html(data.message).show();
                    $.ajax({
                        type: 'POST',
                        url: ajax_login_object.ajaxurl,
                        data: {
                            'action': 'sanas_send_signup_email',
                            'email': $('#signupEmail').val()
                        },
                    });
                    $('.form-boxed .sign-up').addClass('d-none');
                    $('.account-content-succes').removeClass('d-none');
                     // setTimeout(function() {
                
                     if (datahref) {
                        document.location.href = datahref;
                    } else {
                        document.location.href = data.redirect_url;
                    }
                // }, 3000);
                    
                } else {
                    $('#signupresponseError').html(data.message).show();
                    // .delay(3000).fadeOut();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX Error: ' + textStatus, errorThrown);
            }
        });
    });
//Sanas Signup Form Validation
    function isValidForm() {
        var isValid = true;
        // Validate username
        // var username = $('#signupUsername').val();
        // if (username.trim() === '') {
        //     $('#signupUsernameError').text('Username is required.').show();
        //     isValid = false;
        // } else if (username.trim().length < 3) {
        //     $('#signupUsernameError').text('Username must be at least 3 characters long.').show();
        //     isValid = false;
        // } else {
        //     $('#signupUsernameError').hide();
        // }

        // Validate email
        var email = $('#signupEmail').val();
        // var confirmsignupEmail = $('#confirmsignupEmail').val();

        // Email format validation
        if (!isValidEmail(email)) {
            $('#signupEmailError').text('Please enter a valid email address.').show();
            isValid = false;
        } else {
            $('#signupEmailError').hide();
        }


        // Email format validation
        // if (!isValidEmail(confirmsignupEmail)) {
        //     $('#confirmsignupEmailError').text('Please enter a valid email address.').show();
        //     isValid = false;
        // } else {
        //     $('#confirmSignupEmailError').hide();
        // }

        // Confirm email validation
        // if (email !== confirmsignupEmail) {
        //     $('#confirmsignupEmailError').show();
        //     $('#confirmsignupEmailError').text('Confirm Email addresses do not match.');
        //     isValid = false;
        // } else {
        //     $('#confirmsignupEmailError').hide();
        // }


        var password = $('#signupPassword').val();
        if (password.trim() === '') {
            $('#signupPasswordError').text('Password is required.').show();
            isValid = false;
        } else if (password.trim().length < 8) {
            $('#signupPasswordError').text('Password must be at least 8 characters long.').show();
            isValid = false;
        } else {
            $('#signupPasswordError').hide();
        }
        // Validate password
        return isValid;
    }
    $('#signupEmail').on('input', function () {
        var email = $(this).val();
        if (isValidEmail(email)) {
            $('#signupEmailError').hide();
        } else {
            $('#signupEmailError').show();

        }
    });
    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }


// Sanas RESET PASSWORD
    $('#reset-password-form').on('submit', function (e) {
        e.preventDefault();
        $('#resetpassword-status').hide();
        var key = $('#key').val();
        var login = $('#login').val();
        var pass1 = $('#pass1').val();
        var pass2 = $('#pass2').val();


        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'sanas_reset_password_user',
                'key': key,
                'login': login,
                'pass1': pass1,
                'pass2': pass2,
                'security': $('#userpasswordsecurity').val()
            },
            success: function (response) {
                if (response.success) {
                    $('#resetpassword-status').show().html('<div class="alert alert-success" role="alert">'+response.data.message+'</div>');   
                    document.location.href = response.data.siteurl        
                } else {
                    $('#resetpassword-status').show().html('<div class="alert alert-danger" role="alert">'+response.data.message+'</div>');            
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX Error: ' + textStatus, errorThrown);
            }
        });
    });

// Sanas Userverify email
    $('#changepassword').on('click', function (e) {
        e.preventDefault();
        $('#changepassword-status').hide();
        var email = $('#userEmail').val();
        if (!verifyisValidEmail(email)) {
            $('#changepassword-status').show().html('<div class="alert alert-info" role="alert">Please enter a valid email.</div>');            
            return;
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'sanas_verify_user_email',
                'email': email,
                'security': $('#useremailsecurity').val()
            },
            success: function (response) {
                if (response.exists) {
                    $('#changepassword-status').show().html('<div class="alert alert-success" role="alert">We have sent a password reset link to your email.</div>');            
                                document.location.href = window.location.href;
                                setTimeout(function () {
                                window.location.reload();
                                }, 2000);
                } else {
                    $('#changepassword-status').show().html('<div class="alert alert-danger" role="alert">Your email does not exists.</div>');            
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX Error: ' + textStatus, errorThrown);
            }
        });
    });



    function verifyisValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
});
jQuery(document).ready(function ($) {
    $('#rsvp-page-redirect').click(function (e) {
        var guestURL = $(this).attr('btn-url');
        window.location.href = guestURL;
    });
    $('#guest-page-redirect').click(function (e) {
        e.preventDefault();  
        var event_id = $(this).attr('event-id');
        var card_id = $(this).attr('card-id');
        var guestURL = $(this).attr('btn-url');
        var stepId = '4' // Use PHP to insert event_no
        $.ajax({
            url: ajax_login_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'sanas_save_guest_data_callback',
                'security': $('#sanassavepreviewsecurity').val(), 
                 step_id: stepId,
                 event_id: event_id
            },
            success: function (response) {
                window.location.href = guestURL;
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                show_alert_message('Preview', 'please wait some movement try after some time');
            }
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteRowBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Hide the video/iframe and show the upload form
            document.querySelector('.video-box').style.display = 'block';
            document.querySelectorAll('.video-container').forEach(container => container.style.display = 'none');
            document.querySelectorAll('.youtube-container').forEach(container => container.style.display = 'none');
        });
    });
});
jQuery(document).ready(function ($) {
    $('#add-guest-info').on('submit', function (e) {
        e.preventDefault(); 
        var guestName = $('#guestname').val().trim();
        var guestContact = $('#guestcontact').val().trim();
        var guestEmail = $('#guestemail').val().trim();
        var guestGroup = $('.select-group').val(); 
        var event_id = $('#add_guest_details').attr('event-id');

      // Regular expression for validating phone number (10 digits)
        var phoneRegex = /^\d{11}$/;

        // Regular expression for validating email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (guestContact === "" && guestEmail === "") {
         $('.guestlist_details_message').html('<p>Please enter either Phone Number or Email Address</p>');
            return false; // Prevent form submission
        }

        if (guestContact !== "" && !phoneRegex.test(guestContact)) {
         $('.guestlist_details_message').html('<p style="color: red;">Please enter a valid 11-digit phone number.</p>');

            return false; // Prevent form submission
        }

        if (guestEmail !== "" && !emailRegex.test(guestEmail)) {
         $('.guestlist_details_message').html('<p style="color: red;">Please enter a valid email.</p>');
            return false; // Prevent form submission
        }

        $.ajax({
            url: ajax_login_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'sanas_guest_info',
                security: $('#sanasguestsecurity').val(), 
                guestName: guestName,
                guestContact: guestContact,
                guestEmail: guestEmail,
                guestGroup: guestGroup,
                event_id: event_id,
            },
            success: function (response) {
                var messageBox = $('.guestlist_details_message');
                if (response.success) {
                    messageBox.html('<p style="color: green;">' + response.data.message + '</p>');

                     setTimeout(function() {
                        window.location.reload();
                    }, 1000); 

                } else {
                    messageBox.html('<p style="color: red;">' + response.data.message + '</p>');
                }
            },
            error: function (xhr, status, error) {
                $('.guestlist_details_message').html('<p style="color: red;">Please wait a moment and try again later.</p>');
            }
        });
    });

   $('#add_guest_details_save').on('click', function (e) {
        e.preventDefault(); 
        var guestName = $('#guestname').val().trim();
        var guestContact = $('#guestcontact').val().trim();
        var guestEmail = $('#guestemail').val().trim();
        var guestGroup = $('.select-group').val(); 
        var event_id = $('#add_guest_details').attr('event-id');

      // Regular expression for validating phone number (10 digits)
        var phoneRegex = /^\d{11}$/;

        // Regular expression for validating email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (guestContact === "" && guestEmail === "") {
         $('.guestlist_details_message').html('<p style="color: red;">Please fill in either the phone number or email</p>');
            return false; // Prevent form submission
        }

        if (guestContact !== "" && !phoneRegex.test(guestContact)) {
         $('.guestlist_details_message').html('<p style="color: red;">Please enter a valid 11-digit phone number.</p>');

            return false; // Prevent form submission
        }

        if (guestEmail !== "" && !emailRegex.test(guestEmail)) {
         $('.guestlist_details_message').html('<p style="color: red;">Please enter a valid email.</p>');
            return false; // Prevent form submission
        }

        $.ajax({
            url: ajax_login_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'sanas_guest_info',
                security: $('#sanasguestsecurity').val(), 
                guestName: guestName,
                guestContact: guestContact,
                guestEmail: guestEmail,
                guestGroup: guestGroup,
                event_id: event_id,
            },
            success: function (response) {
                var messageBox = $('.guestlist_details_message');
                if (response.success) {
                    messageBox.html('<p style="color: green;background:#cbedcb;padding:14px;border-radius:5px;margin-top:10px;">' + response.data.message + '</p>');

                    $('#add-guest-info')[0].reset();
                } else {
                    messageBox.html('<p style="color: red;margin-top:10px;background:#f4d4d4;padding:14px;border-radius:5px;">' + response.data.message + '</p>');
                }
            },
            error: function (xhr, status, error) {
                $('.guestlist_details_message').html('<p style="color: red;">Please wait a moment and try again later.</p>');
            }
        });
    });

    $('#csv-upload-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log([formData]);
        formData.append('action', 'sanas_guest_handle_csv_upload'); // Add the action parameter
        formData.append('eventid', $('#eventid').val()); // Add the action parameter
        $.ajax({
            url: ajax_login_object.ajaxurl,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#response_csv').html(response);
            },
            error: function() {
                $('#response_csv').html('An error occurred.');
            }
        });
    setInterval(function() {
        cache_clear()
      }, 2000);
    function cache_clear() {
      window.location.reload();
      // window.location.reload(); use this if you do not remove cache
    }
    });
});
function delete_guest_details(itemid) {
    show_alert_message2('Delete Guest', 'Are you sure you want to delete this guest?');

    jQuery('#modal-yes-button').on('click', function () {
        proceedWithGuestRemoval(itemid);
        jQuery('#confirm_modal_html_alert').modal('hide');
    });
}

function show_alert_message2(title, message) {
    jQuery('#exampleConfirmModalLabel').text(title);
    jQuery('#confirm_modal-body-text').text(message);
    jQuery('#confirm_modal_html_alert').modal('show');
}

function proceedWithGuestRemoval(itemid) {
    jQuery.ajax({
        type: 'POST',
        url: ajax_login_object.ajaxurl,
        data: {
            'action': 'sanas_delete_guest_info',
            'itemid': itemid,
        },
        success: function (response) {
            if (response.success) {
                location.reload();
            } else {
                location.reload();
                // Handle failure case
            }
        }
    });
}
function edit_guestlist_details(itemid) {
   var action = 'sanas_ajax_edit_guestlist_details_popup';   
   jQuery.ajax({
        type: 'POST',
        url: ajax_login_object.ajaxurl,
        dataType: 'json',
        data: {
            'action': action,
            'itemid': itemid,
        },
        success: function (data) {
            jQuery('#edit-guestinfo').show();
            jQuery('#form-edit-guestlist-details #editguestname').val(data.guestname);
            jQuery('#form-edit-guestlist-details #editguestphone').val(data.guestphone);
            jQuery('#form-edit-guestlist-details #editguestemail').val(data.guestemail);
            jQuery('#form-edit-guestlist-details #guestid').val(data.guestid);
            var $selectGroup = jQuery('#form-edit-guestlist-details .select-group');
            $selectGroup.val(data.guestgroup).change(); 
        }
    }); 
}
jQuery('#edit-guestinfo').on('click', function (e) {
    e.preventDefault(); 
    var action = 'sanas_edit_guest_info';
    var guestname = jQuery('#form-edit-guestlist-details #editguestname').val();
    var guestphone = jQuery('#form-edit-guestlist-details #editguestphone').val();
    var guestemail = jQuery('#form-edit-guestlist-details #editguestemail').val();
    var guestid = jQuery('#form-edit-guestlist-details #guestid').val(); // Ensure this selector is correct
    var guestGroup = jQuery('#form-edit-guestlist-details .select-group').val(); // Use the correct form selector
    var security = jQuery('#form-edit-guestlist-details #security').val();

      // Regular expression for validating phone number (10 digits)
        var phoneRegex = /^\d{11}$/;

        // Regular expression for validating email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (guestphone === "" && guestemail === "") {
         jQuery('.edit_details_message').html('<p style="color: red;">Please fill in either the phone number or email</p>');
            return false; // Prevent form submission
        }

        if (guestphone !== "" && !phoneRegex.test(guestphone)) {
         jQuery('.edit_details_message').html('<p style="color: red;">Please enter a valid 11-digit phone number.</p>');

            return false; // Prevent form submission
        }

        if (guestemail !== "" && !emailRegex.test(guestemail)) {
         jQuery('.edit_details_message').html('<p style="color: red;">Please enter a valid email.</p>');
            return false; // Prevent form submission
        }


    jQuery.ajax({
        type: 'POST',
        url: ajax_login_object.ajaxurl,
        data: {
            'action': action,
            'guestname': guestname,
            'guestphone': guestphone,
            'guestemail': guestemail,
            'guestid': guestid,
            'guestGroup': guestGroup, // Include the guestGroup in the data sent
            'security': security
        },
        success: function (data) {
            jQuery('.edit_details_message').html(data);
            if (guestname !== "" && guestphone !== "" && guestemail !== "") {
                var url = window.location.href.split('&')[0];
               setTimeout(function() {
                    window.location.reload();
                }, 1000); 
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
});


//select guest group / unselect guest group
document.querySelectorAll('.guestlist-table').forEach(function(table) {
    const firstCheckbox = table.querySelector('thead tr th:first-child input[type="checkbox"]');

    firstCheckbox.addEventListener('change', function() {
        const checkboxes = table.querySelectorAll('tbody tr td:first-child input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = firstCheckbox.checked;
        });
    });
});

jQuery(document).ready(function($) {
    // Track deleted groups
    var deletedGroups = [];
    // Add new group to the list
    $('#add_new_group_button').on('click', function () {
        var groupName = $('#add_new_group_input').val().trim();
        if (groupName !== '') {
            $('#guest_group_list_section').append(
                '<li class="d-flex justify-content-between align-items-center">' +
                '<span>' + groupName + '</span>' +
                '<a href="javascript:" class="action-links remove-group" data-group-name="' + groupName + '">' +
                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6" stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>' +
                '</svg></a></li>'
            );
            $('#add_new_group_input').val('');
        }
    });
    // Remove a group from the list
    $(document).on('click', '.remove-group', function () {
        var groupName = $(this).data('group-name');
        deletedGroups.push(groupName);
        $(this).closest('li').remove();
    });
    // Handle form submission
    $('#update_guest_group_button').on('click', function (e) {
         var event_id = $('#update_guest_group_button').attr('event-id');
        e.preventDefault();
        var groupNames = [];
        $('#guest_group_list_section li span').each(function () {
            groupNames.push($(this).text());
        });
        if (groupNames.length === 0) {
             show_alert_message('GuestList', 'Please add at least one group before updating.');
            return;
        }
        // Make AJAX request
        jQuery.ajax({
            type: 'POST',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'update_guest_groups',
                'groupNames': groupNames,
                'event_id': event_id,
                'deletedGroups': deletedGroups.length ? deletedGroups : [], // Only include if not empty
                'security': $('#security').val()
            },
            success: function (data) {
                jQuery('.guestlist_guest_details_message').html(data);
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX Error: ' + textStatus, errorThrown);
            }
        });
    });
});
// Save Rsvp Id In Database
jQuery(document).ready(function ($) {


    // Handle the 'Next' button click
    $('#save-rsvp-data').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission
        var guestName = $('#guestName').val();
        var rsvp_id = $('#save-rsvp-data').attr('rsvp-id');
        var guestContact = $('#guestContact').val();
        var eventTitle = $('#eventtitle').val();
        var eventDate = $('#eventdate').val();
        var itinerary = $('#itinerary').val();
        var guestMessage = $('#guestMessage').val();
        var videoSrc = $('#uploaded-video').attr('src') || '';
        var youtubeSrc = $('#youtube-iframe').attr('src') || '';
        var previewURL = $(this).attr('btn-url');
        var event_id = $(this).attr('event-id');
        var card_id = $(this).attr('card-id');
        var itineraryData = [];
        var registryData = [];
        var event_venue_name = $('#event_venue_name').val();
        var event_venue_address = $('#event_venue_address').val();
        var event_venue_address_link = $('#event_venue_address_link').val();

        var eventtitlecss = $('#eventtitle').attr('style'); // Get the DOM element
        var guestNamecss = $('#guestName').attr('style'); // Get the DOM element
        var guestContactcss = $('#guestContact').attr('style'); // Get the DOM element
        var guestMessagecss = $('#guestMessage').attr('style'); // Get the DOM element
        var eventdatecss = $('#eventdate').attr('style'); // Get the DOM element
        var itinerarycss = $('#itinerary').attr('style'); // Get the DOM element

        var canvasElement = $('#canvasElement');
        var backgroundImage = canvasElement.css('background-image');    
        var rsvp_bg_url = backgroundImage.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');

        if (eventTitle === '') {
            show_alert_message('RSVP', '<p style="color:red;">Please enter your event title.</p>');
            return; // Stop further execution
        }
        else if (guestName === '') {
            show_alert_message('RSVP', '<p style="color:red;">Please enter Host Name.</p>');
            return; // Stop further execution
        }
        else if (guestContact == '') {
            show_alert_message('RSVP', '<p style="color:red;">Please enter Host Contact.</p>');
            return; // Stop further execution
        }
        // Collect itinerary data
        $('#program-time tr').each(function () {
            var program_name = $(this).find('td:nth-child(1)').text().trim();
            var program_time = $(this).find('td:nth-child(2)').text().trim();
            if (program_name !== '' && program_time !== '') {
                itineraryData.push({ program_name: program_name, program_time: program_time });
            }
        });
        // Collect registry data
        $('.gift-registry-input').each(function () {
            var companyName = $(this).find('input[type="text"]').val().trim();
            var url = $(this).find('input[type="url"]').val().trim();
            if (companyName !== '' && url !== '') {
                registryData.push({ name: companyName, url: url });
            }
        });
        showPreloader("Saving RSVP");
        $.ajax({
            type: 'POST',
            url: ajax_login_object.ajaxurl,
            data: {
                action: 'sanas_save_rsvp_data_callback',
                security: $('#sanassaversvpsecurity').val(),
                guestName: guestName,
                eventTitle: eventTitle,
                itinerary: itinerary,
                eventDate: eventDate,
                guestContact: guestContact,
                guestMessage: guestMessage,
                eventtitlecss: eventtitlecss,
                guestNamecss: guestNamecss,
                guestContactcss: guestContactcss,
                guestMessagecss: guestMessagecss,
                eventdatecss: eventdatecss,
                itinerarycss: itinerarycss,
                videoSrc: videoSrc,
                youtubeSrc: youtubeSrc,
                rsvp_bg_url: rsvp_bg_url,                
                rsvp_id: rsvp_id,
                event_id: event_id,
                itineraryData: JSON.stringify(itineraryData),
                registryData: JSON.stringify(registryData),
                event_venue_name: event_venue_name,
                event_venue_address: event_venue_address,
                event_venue_address_link: event_venue_address_link
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#registry-form-message').html('<p class="text-success">' + data.message + '</p>'); 
                    $('#back-page-redirect').attr('rsvp-id', data.post_id);
                    $('#save-rsvp-data').attr('rsvp-id', data.post_id);
                    var triggercall=$("#triggercall").val();
                    if(triggercall){
                        window.location.href = triggercall;
                    }else{
                        window.location.href = previewURL + '&card_id=' + card_id + '&event_id=' + event_id;
                    }
                } 
                else {
                    $('#registry-form-message').html('<p class="text-danger">' + data.message + '</p>'); 
                }
            },
            error: function () {
                $('#registry-form-message').html('<p class="text-danger">Error: AJAX request failed.</p>'); 
            },
            complete: function() {
                hidePreloader(); // Hide loading indicator after the call completes
            }
        });
    });
    // Handle the 'Add More' button click
   $('.add-gift').on('click', function (e) {
        e.preventDefault();
        var newGift = `
            <div class="gift-registry-input">
                <div class="delete-btn">
                    <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                </div>
                <input type="text" placeholder="Company Name">
                <input type="url" placeholder="Enter URL">
            </div>
        `;
        // Insert the new gift registry input above the 'Add More' button
        $(this).before(newGift);
    });
       // Delete Row Button Click Event
    $('#program-time').on('click', '.deleteRowBtn', function () {
        $(this).closest('tr').remove();
    });
    // Handle delete button click
    $(document).on('click', '.deleteRowBtn', function (e) {
        e.preventDefault();
        $(this).closest('.gift-registry-input').remove();
    });
});
jQuery(document).ready(function ($) {
    $('#back-page-redirect').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission
        var guestName = $('#guestName').val().trim();
        var rsvp_id = $('#save-rsvp-data').attr('rsvp-id');
        var guestContact = $('#guestContact').val();
        var eventTitle = $('#eventtitle').val();
        var eventDate = $('#eventdate').val();
        var guestMessage = $('#guestMessage').val().trim();
        var videoSrc = $('#uploaded-video').attr('src') || '';
        var youtubeSrc = $('#youtube-iframe').attr('src') || '';
        var previewURL = $(this).attr('btn-url');
        var event_id = $(this).attr('event-id');
        var card_id = $(this).attr('card-id');
        var itineraryData = [];
        var registryData = [];
        var itinerary = $('#itinerary').val();
        var event_venue_name = $('#event_venue_name').val();
        var event_venue_address = $('#event_venue_address').val();
        var event_venue_address_link = $('#event_venue_address_link').val();
        // Collect itinerary data

        var eventtitlecss = $('#eventtitle').attr('style'); // Get the DOM element
        var guestNamecss = $('#guestName').attr('style'); // Get the DOM element
        var guestContactcss = $('#guestContact').attr('style'); // Get the DOM element
        var guestMessagecss = $('#guestMessage').attr('style'); // Get the DOM element
        var eventdatecss = $('#eventdate').attr('style'); // Get the DOM element
        var itinerarycss = $('#itinerary').attr('style'); // Get the DOM element



        if (eventTitle === '') {
            show_alert_message('RSVP', '<p style="color:red;">Please enter your event title.</p>');
            return; // Stop further execution
        }
        else if (guestName === '') {
            show_alert_message('RSVP', '<p style="color:red;">Please enter Host Name.</p>');
            return; // Stop further execution
        }
        else if (guestContact == '') {
            show_alert_message('RSVP', '<p style="color:red;">Please enter Host Contact.</p>');
            return; // Stop further execution
        }

        $('#program-time tr').each(function () {
            var program_name = $(this).find('td:nth-child(1)').text().trim();
            var program_time = $(this).find('td:nth-child(2)').text().trim();
            if (program_name !== '' && program_time !== '') {
                itineraryData.push({ program_name: program_name, program_time: program_time });
            }
        });
        // Collect registry data
        $('.gift-registry-input').each(function () {
            var companyName = $(this).find('input[type="text"]').val().trim();
            var url = $(this).find('input[type="url"]').val().trim();
            if (companyName !== '' && url !== '') {
                registryData.push({ name: companyName, url: url });
            }
        });
        $.ajax({
            type: 'POST',
            url: ajax_login_object.ajaxurl,
            data: {
                action: 'sanas_save_rsvp_data_callback',
                security: $('#sanassaversvpsecurity').val(),
                guestName: guestName,
                itinerary: itinerary,
                eventTitle: eventTitle,
                eventDate: eventDate,
                guestContact: guestContact,
                guestMessage: guestMessage,
                eventtitlecss: eventtitlecss,
                guestNamecss: guestNamecss,
                guestContactcss: guestContactcss,
                guestMessagecss: guestMessagecss,
                eventdatecss: eventdatecss,
                itinerarycss: itinerarycss,                
                videoSrc: videoSrc,
                youtubeSrc: youtubeSrc,
                rsvp_id: rsvp_id,
                event_id: event_id,
                itineraryData: JSON.stringify(itineraryData),
                registryData: JSON.stringify(registryData),
                event_venue_name: event_venue_name,
                event_venue_address: event_venue_address,
                event_venue_address_link: event_venue_address_link
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#registry-form-message').html('<p class="text-success">' + data.message + '</p>'); 
                    $('#back-page-redirect').attr('rsvp-id', data.post_id);
                    $('#save-rsvp-data').attr('rsvp-id', data.post_id);
                      window.location.href = previewURL + '&card_id=' + card_id + '&event_id=' + event_id;
                } 
                else {
                    $('#registry-form-message').html('<p class="text-danger">' + data.message + '</p>'); 
                }
            },
            error: function () {
                $('#registry-form-message').html('<p class="text-danger">Error: AJAX request failed.Please try after some time.</p>'); 
            }
        });
    });
});
jQuery(document).ready(function($) {
    $('#send-invitation-btn').on('click', function(e) {
        e.preventDefault();  // Prevent default form submission
        // Show loading message or change button state
        $('.status').show().text('Sending invitations...');
        // Collect selected email addresses
        var selectedEmails = [];
        var guestIds = [];
        $('.guest-checkbox:checked').each(function() {
            selectedEmails.push($(this).data('email'));
            guestIds.push($(this).data('guestid'));
        });
        if (selectedEmails.length === 0) {
             show_alert_message('GuestList', 'No guests selected.');
            $('.status').hide();
            return false;
        }
        var preview_url = $(this).attr('data-preview-url');  
        var mailtitle = $(this).attr('data-title');  

        var preview_image   = $('#event_front_card_preview').val(); 
        var event_id        = $('#event_id').val(); 

        var homePageUrl = 'https://thegenius.co/wpdemo3';

        // Disable button to prevent multiple submissions
        $(this).attr('disabled', 'disabled');
        // AJAX request
        $.ajax({
            type: 'POST',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'sanas_send_invitations',
                'emails': JSON.stringify(selectedEmails),
                'guestids': JSON.stringify(guestIds),
                'preview_url': preview_url,
                'preview_image': preview_image,
                'mailtitle': mailtitle,
                'event_id': event_id,
                'security': ajax_login_object.nonce
            },
            success: function(response) {
                // Handle success response
                //console.log(response);
                $('#send-invitation-btn').removeAttr('disabled');
                $('.status').html('Invitations sent successfully!').addClass('mt20').show();
                // Show success modal with dynamic image
                $('body').append(`
                    <div class="modal fade" id="invationModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title fs-5">Your invitation has been <br> successfully sent</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="img">
                                        <img id="guestinvitionPreview" src="${preview_image}" width="525" height="765" alt="Image preview will appear here">
                                    </div>
                                    <div class="modal-footer">
                                        <a href="${homePageUrl}" class="btn btn-secondary btn-block">Back to Home</a>
                                    </div>
                                    <div class="text">
                                        <p>Checkout wedding vendors at</p>
                                        <a target="_blank" href="https://www.sanashub.com/">Sana’s hub.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
                $('#invationModal').modal('show');

                $('.btn-close').on('click', function() {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                // Handle error response
                $('#send-invitation-btn').removeAttr('disabled');
                $('.status').html('Failed to send invitations. Please try again.').addClass('mt20').show();
                $('#errorModal').modal('show');
            }
        });
    });

    $('#invite-action-submit').on('click', function(e) {
        e.preventDefault();  // Prevent default form submission

         var checkedValues = [];

         var status = '';
         var prestatus = '';
        // Loop through each checkbox and check if it is checked
        $('.check-box-from input[type="checkbox"]').each(function() {
            if ($(this).is(':checked')) {
                checkedValues.push($(this).attr('data-value'));
                status = $(this).attr('data-value');
                prestatus = $(this).attr('data-prevalue');
            }
        });


        // Check if at least one checkbox is checked
        if (checkedValues.length === 0) {
            alert('Please select at least one from Will you be joining us?.');
            return; // Exit the function if no checkbox is checked
        }

        var mesg=$('#mesg').val();
        var kidsguest=$('#kids-guest').text();
        var adultguest=$('#adult-guest').text();
        var prekidsguest=$('#kids-guest').attr('data-prevalue');
        var preadultguest=$('#adult-guest').attr('data-prevalue');
        var guestid=$(this).attr('data-guestid');
        var eventid=$(this).attr('data-eventid');

        if(adultguest=='0')
        {
            alert('Please select at least one adult guest?.');
            return; // Exit the function if no checkbox is checked
        }

        jQuery.ajax({
            type: 'POST',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'sanas_guest_invitation_response',
                'status': status,
                'guestid':guestid,
                'eventid':eventid,
                'kidsguest':kidsguest,
                'adultguest':adultguest,
                'mesg':mesg,
                'prestatus': prestatus,
                'prekidsguest': prekidsguest,
                'preadultguest': preadultguest,
                'security': $('#sanasguestpreviewsecurity').val(),
            },
            success: function (data) {

                //send mail to guest
                // jQuery.ajax({
                //     type: 'POST',
                //     url: ajax_login_object.ajaxurl,
                //     data: {
                //         'action': 'sanas_guest_invitation_response_mail',
                //         'guestid':guestid,
                //         'security': $('#sanasguestpreviewsecurity').val(),
                //     },
                // });

                show_alert_message('Invitations', 'Thanks for provide your response!');

                  // var url = window.location.href.split('&')[0];
                  setTimeout(function() {      window.location.reload(); }, 2000); 
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
 });



    $('#open-invite-action-submit').on('click', function(e) {
        e.preventDefault();  // Prevent default form submission



        var name=$('#name').val();
        var email=$('#email').val();
        var phone=$('#phone').val();
        var mesg=$('#mesg').val();
        var event_userid=$('#event_userid').val();
        var event_id=$('#event_id').val();
        var guest_preview_url=$('#guest_preview_url').val();

        //Select From NEXT AND PREVIUS
        var kidsguest=$('#kids-guest').text();
        var adultguest=$('#adult-guest').text();


      // Regular expression for validating phone number (10 digits)
        var phoneRegex = /^\d{11}$/;

        // Regular expression for validating email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (phone === "" && email === "") {
         $('.guestlist_details_message').html('<p style="color: red;">Please fill in either the phone number or email</p>');
            return false; // Prevent form submission
        }

        if (phone !== "" && !phoneRegex.test(phone)) {
         $('.guestlist_details_message').html('<p style="color: red;">Please enter a valid 11-digit phone number.</p>');

            return false; // Prevent form submission
        }

        if (email !== "" && !emailRegex.test(email)) {
         $('.guestlist_details_message').html('<p style="color: red;">Please enter a valid email.</p>');
            return false; // Prevent form submission
        }

        if(adultguest=='0')
        {
            $('.guestlist_details_message').html('<p style="color: red;">Please select at least one adult guest?.</p>');
            return; // Exit the function if no checkbox is checked
        }

        jQuery.ajax({
            type: 'POST',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'sanas_open_guest_invitation_response',
                'phone': phone,
                'name': name,
                'email':email,
                'event_userid':event_userid,
                'guest_preview_url':guest_preview_url,
                'event_id':event_id,
                'kidsguest':kidsguest,
                'adultguest':adultguest,
                'mesg':mesg,
                'security': $('#sanasguestpreviewsecurity').val(),
            },
            success: function (response) {

                if (response.success) {
                  

                  show_alert_message('Invitations', response.data.message);

                  setTimeout(function() {      
                    window.location.href = response.data.url;

                    }, 2000); 

                }else{
                    $('.guestlist_details_message').html('<p style="color: red;">'+response.data.message+'</p>');
                }

            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
 });


    $('.btn-side-bar').on('click', function(e) {

       var trigger=$(this).attr("data-trigger");       
       var dataurl=$(this).attr("data-url");

       $("#triggercall").val(dataurl); 

       if(trigger=="cover"){
            $( "#save-front-canvas-data" ).trigger( "click" );
       }
       else if(trigger=="details"){
            $( "#save-back-canvas-db" ).trigger( "click" );
       }     
       else if(trigger=="rsvp"){
            $( "#save-rsvp-data" ).trigger( "click" );
       }     
       else if(trigger=="preview"){
            window.location.href = dataurl;
       }     
       else if(trigger=="guestlist"){
            window.location.href = dataurl;            
       }     

    });


});

if(document.getElementById('submitButton')){
 document.getElementById('submitButton').addEventListener('click', function(event) {
  // Prevent form submission
  event.preventDefault();

  // Get input values
  var contact = document.getElementById('guestcontact').value;
  var email = document.getElementById('guestemail').value;

  // Define validation functions
  function isValidPhoneNumber(phone) {
    var phonePattern = /^\d{10}$/; // Adjust regex pattern as needed
    return phonePattern.test(phone);
  }

  function isValidEmail(email) {
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
  }

  // Clear previous error messages
  document.getElementById('contactError').style.display = 'none';
  document.getElementById('emailError').style.display = 'none';

  // Perform validation
  var validContact = isValidPhoneNumber(contact);
  var validEmail = isValidEmail(email);

  if (validContact && validEmail) {
    // If both are valid, submit the form or proceed with your logic
    alert('Form is valid. Submitting...');
    // Example: document.getElementById('yourFormId').submit();
  } else {
    // If not valid, show error messages
    if (!validContact) {
      document.getElementById('contactError').style.display = 'block';
    }
    if (!validEmail) {
      document.getElementById('emailError').style.display = 'block';
    }
  }
});
}


jQuery(document).ready(function ($) {
    $('#category-list').on('change', function () {
        var categoryID = $(this).val();

        var device_id = $('#device_id').val();
        
        $('#gallery-search').val('');
        
        $.ajax({
            url: ajax_login_object.ajaxurl,
            method: 'POST',
            data: {
                action: 'sanas_load_category_images', // Prefixed action
                category_id: categoryID,
                device_id: device_id
            },
            success: function (response) {

               $('#gallery-container').html(response);
                
                 // Bind click event on dynamically loaded images
                $('#gallery-container').on('click', '.tamplate-iteam img', function () {
                    var imgSrc = $(this).attr('src');
                    setBackgroundImage(imgSrc); // Set background image
                });
            },
            error: function () {
                $('#gallery-container').html('<p>Error loading images. Please try again.</p>');
            }
        });
    });


    // Gallery caption search AJAX
    $('#gallery-search').on('keyup', function () {
        var searchTerm = $(this).val();

        $.ajax({
             url: ajax_login_object.ajaxurl,
            method: 'POST',
            data: {
                action: 'sanas_search_gallery_by_caption',
                search_term: searchTerm
            },
            success: function (response) {
                $('#gallery-container').html(response); // Update gallery container with images
                 // Bind click event on dynamically loaded images
                $('#gallery-container').on('click', '.tamplate-iteam img', function () {
                    var imgSrc = $(this).attr('src');
                    setBackgroundImage(imgSrc); // Set background image
                });

            },
            error: function () {
                $('#gallery-container').html('<p>Error loading gallery. Please try again.</p>');
            }
        });
    });
});

jQuery(document).ready(function ($) {
    $('#category-list-back').on('change', function () {
        var categoryID = $(this).val();

        var device_id = $('#device_id').val();

        $.ajax({
            url: ajax_login_object.ajaxurl,
            method: 'POST',
            data: {
                action: 'sanas_load_category_images_back', // Prefixed action
                category_id: categoryID,
                device_id: device_id
            },
            success: function (response) {
                $('#gallery-container-back').html(response);
                $('#gallery-container').on('click', '.tamplate-iteam img', function () {
                    var imgSrc = $(this).attr('src');
                    setBackgroundImage(imgSrc); // Set background image
                });                
            },
            error: function () {
                $('#gallery-container-back').html('<p>Error loading images. Please try again.</p>');
            }
        });
    });

    $('#gallery-search-back').on('keyup', function () {
        var searchTerm = $(this).val();

        $.ajax({
             url: ajax_login_object.ajaxurl,
            method: 'POST',
            data: {
                action: 'sanas_search_gallery_by_caption_back',
                search_term: searchTerm
            },
            success: function (response) {
                $('#gallery-container').html(response); // Update gallery container with images
                 // Bind click event on dynamically loaded images
                $('#gallery-container').on('click', '.tamplate-iteam img', function () {
                    var imgSrc = $(this).attr('src');
                    setBackgroundImage(imgSrc); // Set background image
                });

            },
            error: function () {
                $('#gallery-container').html('<p>Error loading gallery. Please try again.</p>');
            }
        });
    });


$('#copyUrlButton').click(function() {
    // Get the URL from the <p> tag with id="copyurl"
    const url = $('#copyurl').text();

    // Use the Clipboard API to copy the URL to the clipboard
    navigator.clipboard.writeText(url).then(() => {
      $('#statusMessage').text('URL copied to clipboard!');
    }).catch(err => {
      console.error('Failed to copy: ', err);
      $('#statusMessage').text('Failed to copy URL.');
    });
  });

});

