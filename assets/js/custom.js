(function ($) {
    "use strict";
    jQuery(window).on("scroll", function () {
        // header sticky
        if (jQuery(".wl-header").length) {
            var headerScrollPos = 300;
            var stricky = jQuery(".wl-header");
            if (jQuery(window).scrollTop() > headerScrollPos) {
                setTimeout(function () {
                    stricky.addClass("sticky-fixed");
                })
                stricky.addClass("sticky-header--cloned");
            } else if (jQuery(this).scrollTop() <= headerScrollPos) {
                stricky.removeClass("sticky-fixed");
                stricky.removeClass("sticky-header--cloned");
            }
        }
    });

    jQuery(document).ready(function () {
        callSearchSVG();
    });
    
    function callSearchSVG() {
        const svgIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="26" height="26" viewBox="0 0 50 50">
            <path d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"></path>
        </svg>`;
    
        setInterval(function () {
            jQuery(".dt-search label").each(function () {
                const label = jQuery(this);
                if (label.text().trim() === "Search:") {
                    label.html(svgIcon);
                    label.off("click").on("click", function () {
                        label.siblings("input[type=search]").toggle();
                    });
                    label.siblings("input[type=search]").off("focusout").on("focusout", function () {
                        jQuery(this).toggle();
                    });
                }
            });
        }, 500);
    }
    
// jQuery(document).on('click', function (e) {
//         if (!jQuery(e.target).closest('.form-boxed').length) {
//             jQuery('.form-boxed .login').removeClass('d-none');
//             jQuery('.form-boxed .content-succes').addClass('d-none');
//             jQuery('.form-boxed .sign-up').addClass('d-none');
//             jQuery('.form-boxed .cheng-password').addClass('d-none');
//             jQuery('.form-boxed .account-content-succes ').addClass('d-none');
//             jQuery('.form-boxed  .forgot').addClass('d-none');
//         }
//     });


    jQuery('#colorPicker').on('input', function () {
        var selectedColor = jQuery(this).val();
        jQuery('.edit-text.selected-text').css('color', selectedColor);
    });

    function syncTextAndColor() {
    }
    syncTextAndColor();
    // coustum seceltion option 

    jQuery(document).ready(function () {
    if (jQuery('.header-right-end').length) {
        // mobail nav
        jQuery(".header-right-end").on("click", function () {
            jQuery(".mobile-nav-wrapper").toggleClass("expanded");
        });
        jQuery(".mobile-nav-toggler").on("click", function () {
            jQuery(".mobile-nav-wrapper").toggleClass("expanded");
        });
        // jQuery(".header-right-end").click(function () {
        //     jQuery("body").addClass("stop");
        // });
        // jQuery(".mobile-nav-toggler").click(function () {
        //     jQuery("body").removeClass("stop");
        // });
    }
});
    if (jQuery('.featured-section').length) {
        // featured-vendors slider
        jQuery('.featured-vendors').slick({
            autoplay: true,
            autoplaySpeed: 5000,
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1600,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }



    if (jQuery('.wl-left-slide-bar').length) {
        // iteam active class toggel
        jQuery('.bg-img-iteam').click(function () {
            jQuery('.bg-img-iteam').removeClass('active');
            jQuery(this).addClass('active');
        });

        jQuery('.tamplate-iteam').click(function () {
            jQuery('.tamplate-iteam').removeClass('active');
            jQuery(this).addClass('active');
        });

        jQuery('.elements-iteam').click(function () {
            jQuery('.elements-iteam').removeClass('active');
            jQuery(this).addClass('active');
        });
    }
    if (jQuery('.form-group-fluid').length) {
        // color piker value to text span
        jQuery(' #color-picker-background, #mobail-color-picker-background').on('input', function () {
            var selectedColor = jQuery(this).val();
            jQuery('.color-target-code').text(selectedColor);
            jQuery('#canvasElement').css('background-color', selectedColor);
             jQuery('#canvasElement').css({
            'background-image': 'none'
        });

        });
        jQuery('.color-squr data, .color-squr-1 span').click(function () {
            var hexValue = jQuery(this).attr('color-hex-value');;
            jQuery('#color-picker ,#mobail-color-picker , #color-picker-background, #mobail-color-picker-background').val(hexValue);
            jQuery('.color-target-code').text(hexValue);
            jQuery('#colorbg').val(hexValue);
        });
    }

    jQuery('.color-squr-1>span').click(function () {
        var selectedColor = jQuery(this).attr('color-hex-value');
        jQuery('#canvasElement').css('background-color', selectedColor);
        jQuery('#colorbg').val(selectedColor);
        jQuery('#canvasElement').css({ 'background-image': 'none' });
    });

    if (jQuery('.wl-left-slide-bar').length) {
        // selected text cheng and value textarea
        var previousText = '';

        function syncTextareaToEditText() {
            var newText = jQuery('#selectedtext').val().trim();
            jQuery('.edit-text.selected-text').each(function () {
                if (jQuery(this).is('input[type="text"]') || jQuery(this).is('input[type="number"]') || jQuery(this).is('textarea') || jQuery(this).is('input[type="date"]')) {
                    jQuery(this).val(newText);
                } else {
                    jQuery(this).text(newText);
                }
            });
        }
        function selectEditText(element) {
            jQuery('.edit-text').removeClass('selected-text');
            jQuery(element).addClass('selected-text');

            if (jQuery(element).is('input[type="text"]') || jQuery(element).is('input[type="number"]') || jQuery(element).is('textarea') || jQuery(element).is('input[type="date"]')) {
                jQuery('#selectedtext').val(jQuery(element).val().trim());
            } else {
                jQuery('#selectedtext').val(jQuery(element).text().trim());
            }
            previousText = jQuery('#selectedtext').val();
        }
        jQuery('.edit-text').click(function () {
            selectEditText(this);
        });
        jQuery('#selectedtext').keyup(function () {
            syncTextareaToEditText();
        });
        // jQuery('#selectedtext').blur(function () {
        //     syncTextareaToEditText();
        // });
    }
    if (jQuery('.wl-left-slide-bar').length) {
        // text align
        jQuery('.form-group .text-style-btn>a').click(function () {
            var selectedAlign = jQuery(this).data('title');
            jQuery('.form-group .text-style-btn>a').removeClass('active');
            jQuery(this).addClass('active');
            updateTextAlign(selectedAlign);
        });
        function updateTextAlign(Align) {
            jQuery('.selected-text').parent(this).css('text-align', Align);
        }
    }
    if (jQuery('.select-wrapper').length) {
        // font size
        function setDropdownToDefault() {
            var firstOptionValue = jQuery('#font-size option:first').val();
            if (jQuery('#font-size').val() === '') {
                jQuery('#font-size').val(firstOptionValue).change();
            }
        }
        setDropdownToDefault();
        jQuery('#font-size').change(function () {
            var selectedFontSize = jQuery(this).val();
            jQuery('.edit-text.selected-text').css('font-size', selectedFontSize);
        });
        jQuery('.edit-text').click(function () {
            var currentFontSize = jQuery(this).css('font-size');
            var fontSizeValue = currentFontSize;
            if (currentFontSize.endsWith('px')) {
                fontSizeValue = currentFontSize;
            } else if (currentFontSize.endsWith('pt')) {
                fontSizeValue = parseFloat(currentFontSize) * 1.3333 + 'px';
            }
            var optionExists = false;
            jQuery('#font-size option').each(function () {
                if (jQuery(this).val() === fontSizeValue) {
                    optionExists = true;
                    return false;
                }
            });
            if (optionExists) {
                jQuery('#font-size').val(fontSizeValue).change();
            } else {
                setDropdownToDefault();
            }
            jQuery('.edit-text').removeClass('selected-text');
            jQuery(this).addClass('selected-text');
        });
    }
    const currentUrl = window.location.href;
    const params = new URLSearchParams(window.location.search);
    if (params.get('dashboard') === 'rsvp') {
        const search_address = document.getElementById('search_address');
        search_address.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        const guestMessage = document.getElementById('guestMessage');
        guestMessage.addEventListener('input', function () {
            this.style.height = 'auto'; 
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
    if (jQuery('.select-wrapper').length) {
        // font-family
        function setDropdownToDefault() {
            var firstOptionValue = jQuery('#font-family-select option:first').val();
            jQuery('#font-family-select').val(firstOptionValue).change();
        }
        setDropdownToDefault();
        jQuery('#font-family-select').change(function () {
            var selectedFontFamily = jQuery(this).find('option:selected').data('title');
            jQuery('.edit-text.selected-text').css('font-family', selectedFontFamily);
        });
        jQuery('.edit-text').click(function () {
            var currentFontFamily = jQuery(this).css('font-family');
            currentFontFamily = currentFontFamily.replace(/['"]/g, '');
            currentFontFamily = currentFontFamily.split(',')[0].trim();
            var optionExists = false;
            jQuery('#font-family-select option').each(function () {
                var optionFontFamily = jQuery(this).data('title').replace(/['"]/g, '').split(',')[0].trim();
                if (optionFontFamily === currentFontFamily) {
                    optionExists = true;
                    jQuery('#font-family-select').val(jQuery(this).val()).change();
                    return false;
                }
            });
            if (!optionExists) {
                setDropdownToDefault();
            }
            jQuery('.edit-text').removeClass('selected-text');
            jQuery(this).addClass('selected-text');
        });
    }
    
    if (jQuery('.select-wrapper').length) {
        // bodl italic underline
        jQuery('.edit-text').click(function () {
            jQuery('.text-style-btn-one > a').removeClass('active');
            var cssStyles = jQuery(this).css(['font-weight', 'font-style', 'text-decoration', 'text-decoration-line']);
            var fontWeight = cssStyles['font-weight'] === 'bold' || cssStyles['font-weight'] === '700';
            var fontStyle = cssStyles['font-style'] === 'italic';
            var textDecoration = cssStyles['text-decoration'] === 'underline' || cssStyles['text-decoration-line'] === 'underline';
            var activeStyles = {
                'bold': fontWeight,
                'italic': fontStyle,
                'underline': textDecoration
            };
            jQuery('.text-style-btn-one > a').each(function () {
                var style = jQuery(this).data('title');
                if (activeStyles[style]) {
                    jQuery(this).addClass('active');
                }
            });
        });
        jQuery('.text-style-btn-one > a').click(function () {
            var style = jQuery(this).data('title');
            jQuery(this).toggleClass('active');
            var activeStyles = [];
            jQuery('.text-style-btn-one > a.active').each(function () {
                activeStyles.push(jQuery(this).data('title'));
            });
            updateTextStyle(activeStyles);
        });
        function updateTextStyle(styles) {
            var cssStyles = {
                'font-weight': '',
                'font-style': '',
                'text-decoration': '',
                'text-decoration-line': ''
            };
            styles.forEach(function (style) {
                if (style === 'bold') {
                    cssStyles['font-weight'] = 'bold';
                } else if (style === 'italic') {
                    cssStyles['font-style'] = 'italic';
                } else if (style === 'underline') {
                    cssStyles['text-decoration'] = 'underline';
                    cssStyles['text-decoration-line'] = 'underline';
                }
            });
            jQuery('.selected-text').css(cssStyles);
        }
    }

    // chart dashbord
    if (jQuery('#guest_attending').length) {
        var con = 52;
        var pending = 24;
        var options = {
            series: [con, pending],
            colors: ['#28c38d', '#ff6666'],
            labels: [],
            markers: false,
            chart: {
                type: 'donut',
                height: '370px',
                width: '100%'
            },
            legend: {
                position: 'bottom'
            }
        };
        options.labels = ['sent (' + options.series[0] + ')', 'Pending (' + options.series[1] + ')']
        var chart = new ApexCharts(document.querySelector("#guest_attending"), options);
        chart.render();
    }

    if (jQuery('body').length) {
        // background images cheng

        jQuery('.bg-img-iteam img').click(function () {
            var newImgSrc = jQuery(this).attr('src');
            jQuery('section.wl-main-canvas .inner-colum').css('background-image', 'url("' + newImgSrc + '")');

            jQuery('.bg-img-iteam').removeClass('active');
            jQuery(this).parent().addClass('active');
        });
        var imgSrc = jQuery('.tamplate-iteam>img').attr('src');
        jQuery('section.wl-main-canvas .card-canvas>img').css('background-image', 'url("' + imgSrc + '")');

        jQuery('.tamplate-iteam>img').click(function () {
            var newImgSrc = jQuery(this).attr('src');
            jQuery('section.wl-main-canvas .card-canvas>img').attr('src', newImgSrc);
            jQuery('.tamplate-iteam').removeClass('active');
            jQuery(this).parent().addClass('active');
        });
        jQuery('#color-picker-background, #mobail-color-picker-background ').on('input', function () {
            var selectedColor = jQuery(this).val();
            jQuery('#canvasElement').css('background-color', selectedColor);
            jQuery('#canvasElement').css({
                'background-image': 'none'
            });
        });

    var colorbg = jQuery('#colorbg').val();
    if(colorbg){
    jQuery('#canvasElement').css('background-color', colorbg);
    }
    else{
    jQuery('#canvasElement').css('background-color', initialColor);
    }

        var initialColor = jQuery('#color-picker-background, #mobail-color-picker-background').val();
        jQuery('#canvas-element').css('background-color', initialColor);
        jQuery('.color-squr-1>data').click(function () {
            var selectedColor = jQuery(this).attr('value');
            jQuery('#canvasElement').css('background-color', selectedColor);
            jQuery('#canvasElement').css({ 'background-image': 'none' });
        });
        jQuery('.elements-iteam img').click(function () {
            var imgSrc = jQuery(this).attr('src');

            jQuery('#stiker-post').attr('src', imgSrc);

            jQuery('.stiker-add').fadeIn();
            jQuery('.stiker-add img').css('max-width', 57);
        });
    }
    if (jQuery('.guest-count').length) {
        // rsvp guest count
        jQuery('.guest-count .count .plues').on('click', function () {
            var totalGuestsElement = jQuery(this).siblings('.total-guest');
            var currentCount = parseInt(totalGuestsElement.text(), 10);
            totalGuestsElement.text(currentCount + 1);
        });
        jQuery('.guest-count .count .mines').on('click', function () {
            var totalGuestsElement = jQuery(this).siblings('.total-guest');
            var currentCount = parseInt(totalGuestsElement.text(), 10);
            if (currentCount > 0) {
                totalGuestsElement.text(currentCount - 1);
            }
        });
    }
    // guest-list data table
    if (jQuery('.table-responsive').length) {
        // jQuery('#guest-list-Table').DataTable({
        //     searching: true,
        //     paging: true,
        //     "ordering": true,
        //     "order": [],
        //     columnDefs: [
        //         { orderable: false, targets: [0, 3, 5, 6] },
        //     ]
        // });
        // jQuery('.budget-table-sort').DataTable({
        //     columnDefs: [
        //         { orderable: false, targets: [0, 2, 3, 4, 5, 6] },
        //     ],
        //     "createdRow": function (row, data, dataIndex) {
        //         if (dataIndex === jQuery('.budget-table-sort').DataTable().data().length - 1) {
        //             jQuery('td', row).each(function () {
        //                 jQuery(this).attr('data-order', '');
        //             });
        //         }
        //         // Check if this is the total row
        //         if (data[0] === 'Total') {
        //             jQuery(row).addClass('expense-total-row');
        //         }
        //     },
        //     "drawCallback": function(settings) {
        //         // Move the total row to the bottom
        //         var api = this.api();
        //         var totalRow = api.rows('.expense-total-row').nodes();
        //         if (totalRow.length) {
        //             jQuery(totalRow).appendTo(api.table().body());
        //         }
        //     }
        // });
        jQuery('.vendor-table-list').DataTable({
            columnDefs: [
                { orderable: false, targets: [0,2,3,4,5] },
            ]
        });
        jQuery('#guest-list-Table').DataTable({
            searching: true,
            paging: true,
            "order": [],
            "ordering": true,
            columnDefs: [
                { orderable: false, targets: [0, 3, 5, 6] },
            ]
        });
        // jQuery('#guest-contact-list').DataTable();
        jQuery('.todo-table').DataTable({
            searching: false,
            paging: false,
            "order": [],
            "ordering": true,
            columnDefs: [
                { orderable: false, targets: [0, 2, 3, 4, 5] },
            ],
            language: {
                info: ""
            }
        });
        jQuery('.my-vendor-table').DataTable({
            "order": [],
            "ordering": true,
            columnDefs: [
                { orderable: false, targets: [1, 2, 3, 4, 5] },
            ],
        });
    }
    if (jQuery('.registry').length) {
        jQuery('#program-time1').on('click', '.deletebtn', function () {
            jQuery(this).closest('.gift-registry-input').remove();
        });
    }
    if (jQuery('.wl-fuc-timing').length) {
        // rsvp page add event and time
        jQuery('#add-event-btn').on('click', function () {
            var newRow = '<tr>' +
                '<td class="edit-text text-start" contenteditable="true" data-placeholder="Evening"></td>' +
                '<td class="edit-text text-start" contenteditable="true" data-placeholder="7 PM"></td>' +
                '<td><button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button></td>' +
                '</tr>';
            jQuery('#program-time').append(newRow);
        });
    }
    if (jQuery('.form-text-edit, .mobaile-form-text-edit').length) {
        // text color
        function syncTextAndColor() {
            var selectedTextColor = jQuery('.edit-text.selected-text').css('color');
            var hexColor = rgbToHex(selectedTextColor);
            jQuery('#color-picker').val(hexColor);
            jQuery('#mobail-color-picker').val(hexColor);
            jQuery('#color-picker-background').val(hexColor);
            jQuery('#mobail-color-picker-background').val(hexColor);
        }
        function rgbToHex(rgb) {
            var rgbArray = rgb.match(/\d+/g);
            if (rgbArray) {
                var r = parseInt(rgbArray[0]);
                var g = parseInt(rgbArray[1]);
                var b = parseInt(rgbArray[2]);
                return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
            }
            return '#000000';
        }
        function setTextColor(color) {
            jQuery('.edit-text.selected-text').css('color', color);
            syncTextAndColor();
        }
        jQuery('.edit-text').click(function () {
            jQuery('.edit-text').removeClass('selected-text');
            jQuery(this).addClass('selected-text');
            syncTextAndColor();
        });
        jQuery('.color-squr>data').click(function () {
            var color = jQuery(this).attr('value');
            setTextColor(color);
        });
        jQuery('#color-picker, #color-picker-background, #mobail-color-picker-background').on('input', function () {
            var selectedColor = jQuery(this).val();
            setTextColor(selectedColor);
        });
    }
    // Delete Row Button Click Event
    jQuery('#program-time').on('click', '.deletebtn', function () {
        jQuery(this).closest('tr').remove();
    });
    if (jQuery('.event-checkbox').length) {
        jQuery('#selectAll').change(function () {
            jQuery('.event-checkbox input[type="checkbox"]').prop('checked', this.checked);
        });
        jQuery('.event-checkbox input[type="checkbox"]').change(function () {
            var allChecked = true;
            jQuery('.event-checkbox input[type="checkbox"]').each(function () {
                if (!this.checked) {
                    allChecked = false;
                }
            });
            jQuery('#selectAll').prop('checked', allChecked);
        });
    }
    if (jQuery('.guests-box').length) {
        // all checkboc checked
        jQuery('#all-select-chechbox').change(function () {
            jQuery('.guests-box .table-box .table tr td input[type="checkbox"]').prop('checked', this.checked);
        });
        jQuery('.guests-box .table-box .table tr td input[type="checkbox"]').change(function () {
            var allChecked = true;
            jQuery(' .guests-box .table-box .table tr td input[type="checkbox"]').each(function () {
                if (!this.checked) {
                    allChecked = false;
                }
            });
            jQuery('#all-select-chechbox').prop('checked', allChecked);
        });
    }
    if (jQuery('.guests-box').length) {
         // all checkboc checked
        jQuery('#all-select-chechbox-one').change(function () {
            jQuery('.contact .table tr td input[type="checkbox"]').prop('checked', this.checked);
        });
        jQuery('.contact .table tr td input[type="checkbox"]').change(function () {
            var allChecked = true;
            jQuery(' .contact .table tr td input[type="checkbox"]').each(function () {
                if (!this.checked) {
                    allChecked = false;
                }
            });
            jQuery('#all-select-chechbox-one').prop('checked', allChecked);
        });
    }
    if (jQuery('.guest-list-footer').length) {
        // on off sweech
        jQuery('.check-toggle').click(function () {
            jQuery(this).toggleClass("active");
        });
    }
    //Tabs Box
    if (jQuery('.tabs-box').length) {
        jQuery('.tabs-box .tab-buttons .tab-btn').on('click', function (e) {
            e.preventDefault();
            var windowWidth = jQuery(window).width();
            var target = jQuery(jQuery(this).attr('data-tab'));
            var TabsContent = target.parents('.tabs-box').find('.tabs-content');
            if (jQuery(target).is(':visible')) {
                return false;
            } else {
                jQuery(this).parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                jQuery(this).addClass('active-btn');
                target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab');
                jQuery(target).fadeIn(300);
                jQuery(target).addClass('active-tab');
            }
        });
    }
    // Tabs Box
    if (jQuery('.tabs-box-3').length) {
        jQuery('.tabs-box-3>.tab-buttons>.tab-btn').on('click', function (e) {
            e.preventDefault();
            var windowWidth = jQuery(window).width();
            var target = jQuery(jQuery(this).attr('data-tab'));
            var TabsContent = target.parents('.tabs-box-3').find('.tabs-content');

            if (jQuery(target).is(':visible')) {
                return false;
            } else {
                jQuery(this).parents('.tabs-box-3').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                jQuery(this).addClass('active-btn');
                target.parents('.tabs-box-3').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box-3').find('.tabs-content').find('.tab').removeClass('active-tab');
                jQuery(target).fadeIn(300);
                jQuery(target).addClass('active-tab');
            }
        });
    }
    // table delete btn

    // enter valid email
    if (jQuery('.search-popup').length) {
        // email validation
        // jQuery('#emailForm').submit(function (event) {
        //     var email = jQuery('#login-email, #sign-up-email , #forgot-email').val();
        //     if (!isValidEmail(email)) {
        //         jQuery('.error-message').show();
        //         addErrorStyles();
        //         event.preventDefault();
        //     } else {
        //         jQuery('.error-message').hide();
        //         removeErrorStyles();
        //     }
        // });
        // jQuery('#login-email, #sign-up-email , #forgot-email').on('input', function () {
        //     var email = jQuery(this).val();
        //     if (isValidEmail(email)) {
        //         jQuery('.error-message').hide();
        //         removeErrorStyles();
        //     } else {
        //         jQuery('.error-message').show();
        //         addErrorStyles();
        //         jQuery('.btn-block').off('click');
        //     }
        // });
        function isValidEmail(email) {
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
        function addErrorStyles() {
            jQuery('#login-email, #sign-up-email , #forgot-email').addClass('email-error');
        }
        function removeErrorStyles() {
            jQuery('#login-email, #sign-up-email , #forgot-email').removeClass('email-error');
        }
    }
    if (jQuery('.check-box-from-field').length) {
        // yes no not sore check box
        jQuery('.check-box-from-field input[type="checkbox"]').change(function () {
            var checked = jQuery(this).prop('checked');
            if (checked) {
                jQuery('.check-box-from-field input[type="checkbox"]').not(this).prop('checked', false);
            }
        });
    }
    if (jQuery('#add-group-popup').length) {
        // add meal
        jQuery("#add-meal").addClass("d-none");

        jQuery(".add-meal").click(function () {
            jQuery("#add-meal").removeClass("d-none").addClass("d-block");
        });
        jQuery('#add_meal_button').click(function () {
            var mealName = jQuery('#add_meal_input').val().trim();
            if (mealName !== '') {
                var newItem = jQuery('<li>').addClass('d-flex justify-content-between align-items-center');
                var span = jQuery('<span>').text(mealName);
                var deleteLink = jQuery('<a>').attr('href', 'javascript:').addClass('action-links')
                    .html('<span class="fa fa-trash"></span>');
                deleteLink.click(function () {
                    newItem.remove();
                });
                newItem.append(span).append(deleteLink);
                jQuery('#add_new_meals_options').append(newItem);
                jQuery('#add_meal_input').val('');
            }
        });
    }
    if (jQuery('#add-group-popup').length) {
        // add group
        jQuery('#add_new_group_button').click(function () {
            var groupName = jQuery('#add_new_group_input').val().trim();
            if (groupName !== '') {
                var newItem = jQuery('<li>').addClass('d-flex justify-content-between align-items-center');
                var span = jQuery('<span>').text(groupName);
                var deleteLink = jQuery('<a>').attr('href', 'javascript:').addClass('action-links')
                    .html('<span class="fa fa-trash"></span>');
                deleteLink.click(function () {
                    newItem.remove();
                });
                newItem.append(span).append(deleteLink);
                jQuery('#guest_group_list_section').append(newItem);
                jQuery('#add_new_group_input').val('');
            }
        });
    }
    if (jQuery('#add_new_category').length) {
        // add category
        jQuery('#add_new_category').click(function () {
            var categoryName = jQuery('#add_new_category_input').val().trim();
            var categoryCost = jQuery('#add_category_cost_input').val().trim();
            if (categoryName !== '' && categoryCost !== '') {
                var newItem = jQuery('<li>');
                var link = jQuery('<a>').attr('href', '#');
                var itemContent = jQuery('<div>').addClass('ttl')
                    .html('<i class="fa-solid fa-tag"></i><span class="txt">' + categoryName + '</span>');
                var itemCost = jQuery('<div>').addClass('count')
                    .html('<span>' + categoryCost + '</span>');
                link.append(itemContent).append(itemCost);
                newItem.append(link);
                jQuery('#category_cost_section').append(newItem);
                jQuery('#add_new_category_input').val('');
                jQuery('#add_category_cost_input').val('');
            }
        });
    }
    if (jQuery('.inner-box').length) {
        //scroll on animation
        function isElementInViewport(el) {
            var rect = el[0].getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
        function handleAnimation() {
            jQuery('.flipper').each(function () {
                if (isElementInViewport(jQuery(this))) {
                    jQuery(this).addClass('animated');
                } else {
                    jQuery(this).removeClass('animated');
                }
            });
        }
        jQuery(window).on('scroll', handleAnimation);
        handleAnimation();
    }
})
    (window.jQuery);

jQuery(document).ready(function () {
    "use strict";
    if (jQuery(".mobile-nav-container .mobile-menu-list").length) {
        let dropdownAnchor = jQuery(
            ".mobile-nav-container .mobile-menu-list .dropdown > a"
        );
        dropdownAnchor.each(function () {
            let self = jQuery(this);
            let toggleBtn = document.createElement("BUTTON");
            toggleBtn.setAttribute("aria-label", "dropdown toggler");
            toggleBtn.innerHTML = "<i class='fa-solid fa-chevron-down'></i>";
            self.append(function () {
                return toggleBtn;
            });
            self.find("button").on("click", function (e) {
                e.preventDefault();
                let self = jQuery(this);
                self.toggleClass("expanded");
                self.parent().toggleClass("expanded");
                self.parent().parent().children("ul").slideToggle();
            });
        });
    }
});



jQuery(document).ready(function () {
    if (jQuery('.upload-Category').length) {
        // filter page select option
        var $disabledResults = jQuery(".upload-Category");
        $disabledResults.select2();
    }
    if (jQuery('.select-wrapper , .group-option-inner , .contact-form').length) {
        // filter page select option
        var $disabledResults = jQuery(".select-inner , .category-list , .group-option , add-group , .Subject");
        $disabledResults.select2();
    }

if (jQuery('#header-options').length) {    
    jQuery('#header-options').click(function () {
        var headermsg=jQuery("#header-options-msg").val();
        show_alert_message('Are you sure you’d like to exit?', headermsg,'yes');
    });    
}

if (jQuery('#btn-exit').length) {    

    jQuery('#btn-exit').click(function () {
        window.location.href = jQuery(this).attr('data-redirect');
    });    
}    

});
// serch suggestion list
if (jQuery('.nav-link').length) {
    // mobail nav-link active class
    const tabLinks = document.querySelectorAll('.wl-left-slide-bar>.inner-colum>.nav-pills>.nav-link');
    tabLinks.forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();
            tabLinks.forEach(t => t.classList.remove('previous', 'next'));
            const index = Array.from(tabLinks).indexOf(tab);
            if (index > 0) {
                tabLinks[index - 1].classList.add('previous');
            }
            if (index < tabLinks.length - 1) {
                tabLinks[index + 1].classList.add('next');
            }
        });
    });
}


function show_alert_message2(title,msg,footer = 'no'  ) {
// Show the modal

    var modalElement = document.getElementById('modal_html_alert');
    var modal = new bootstrap.Modal(modalElement);

    // Update modal content
    modalElement.querySelector('.modal-title').innerHTML  = title;
    modalElement.querySelector('.modal-body').innerHTML  = msg;

    // Show the modal
   if(footer=='no')
   {
       var footerElement = modalElement.querySelector('.modal-footer');
         footerElement.style.display = 'none';
   }else{
       var footerElement = modalElement.querySelector('.modal-footer');
         footerElement.style.display = 'flex';

   }

    modal.show();
}

function show_alert_message(title,msg,footer = 'no'  ) {
// Show the modal

    var modalElement = document.getElementById('modal_html_alert');
    var modal = new bootstrap.Modal(modalElement);

    // Update modal content
    modalElement.querySelector('.modal-title').innerHTML  = title;
    modalElement.querySelector('.modal-body').innerHTML  = msg;

    // Show the modal
   if(footer=='no')
   {
       var footerElement = modalElement.querySelector('.modal-footer');
         footerElement.style.display = 'none';
   }else{
       var footerElement = modalElement.querySelector('.modal-footer');
         footerElement.style.display = 'flex';

   }

    modal.show();
}
// Example: Show the preloader manually and hide it after a delay
jQuery(window).on('load', function() {
    // Simulate loading process (e.g., fetching data)
    setTimeout(function() {
        hidePreloader();
    }, 500); // Adjust this time based on your actual loading process
});

jQuery(window).on('beforeunload', function() {
    showPreloader();
});
// Function to show the preloader
function showPreloader(mgm) {
    jQuery('#preloder-overlay').fadeIn(100);
    jQuery('.loading-message').html(mgm)
    jQuery('#preloder-overlay').addClass('d-block'); // Show with fade effect
    jQuery('#preloder-overlay').removeClass('d-none'); // Show with fade effect
}

// Function to hide the preloader
function hidePreloader() {
   jQuery('#preloder-overlay').fadeOut(300); // Hide with fade effect
   jQuery('#preloder-overlay').addClass('d-none');
   jQuery('#preloder-overlay').removeClass('d-block');
} 

jQuery(document).ready(function ($) {


    if (jQuery('body').length) {
        // login popup
        jQuery('.login-in,.sanas-login-popup').on('click', function (e) {
            e.stopPropagation();
            var datahref = jQuery(this).attr('data-href');
            jQuery('#datahref').val(datahref);
            jQuery('#datahref1').val(datahref);

            var cardId =jQuery(this).parents('.card-preview').attr('data-card-id');
            var forntImg = jQuery(this).parents('.card-preview').attr('data-front-img');
            var backImg = jQuery(this).parents('.card-preview').attr('data-back-img');
            var cardTitle = jQuery(this).parents('.card-preview').attr('data-card-title');
            var bgcolor = jQuery(this).parents('.card-preview').attr('data-bgcolor-code');

            jQuery('#popup-card-id').val(cardId);
            jQuery('#popup-front-img').val(forntImg);
            jQuery('#popup-back-img').val(backImg);
            jQuery('#popup-card-title').val(cardTitle);
            jQuery('#popup-bgcolor-code').val(bgcolor);

            jQuery('#popup-card-id1').val(cardId);
            jQuery('#popup-front-img1').val(forntImg);
            jQuery('#popup-back-img1').val(backImg);
            jQuery('#popup-card-title1').val(cardTitle);
            jQuery('#popup-bgcolor-code1').val(bgcolor);

            jQuery('body').addClass('search-active');
            jQuery('#ajaxvalue').val('0');
        });
        jQuery('.login-complate').on('click', function () {
            jQuery('body').removeClass('search-active');
        });

        jQuery(document).keydown(function (e) {
            if (e.keyCode == 27) {
                jQuery('body').removeClass('search-active');
            }
        });
        jQuery('.form-boxed').on('click', function (e) {
            e.stopPropagation();
        });
        jQuery('.close-search').on('click', function () {
            jQuery('body').removeClass('search-active');
            // Reset the form to show the login form
    jQuery('.form-boxed .login').removeClass('d-none');
    jQuery('.form-boxed .forgot').addClass('d-none');
            jQuery('.form-boxed .cheng-password').addClass('d-none');
            jQuery('.form-boxed .sign-up').addClass('d-none');
        });      

        jQuery(document).on('click', function (e) {
            if (!jQuery(e.target).closest('.form-boxed').length) {
                jQuery('body').removeClass('search-active');
            }
        });
    }

    // login form
    jQuery('.form-boxed .btn-forgot').click(function (e) {
        e.preventDefault();
        jQuery('.form-boxed  .forgot').removeClass('d-none');
        jQuery('.form-boxed .login').addClass('d-none');
    });
    jQuery('.form-boxed .cheng-password .btn-block').on('click', function () {
        jQuery('.form-boxed .login').removeClass('d-none');
        jQuery('.form-boxed .cheng-password').addClass('d-none');
    });
    jQuery('.form-boxed .lower-social-box p .sign-up-2').on('click', function () {
        jQuery('.form-boxed .sign-up').removeClass('d-none');
        jQuery('.form-boxed .login').addClass('d-none');
    });
     jQuery('.form-boxed .sign-in').on('click', function () {
        jQuery('.form-boxed .login').removeClass('d-none');
        jQuery('.form-boxed .sign-up').addClass('d-none');
    });




if (jQuery('.search-popup, .form-content').length) {
    // password eye icon
        jQuery('.search-popup .eye-icon, .form-content .eye-icon').on('click', function () {
            var formGroup = jQuery(this).closest('.form-group');
            var passwordInput = formGroup.find('.password-control');
            var eyeIcon = jQuery(this).find('.fa-regular');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordInput.attr('type', 'password');
                eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
}

    // Check if the URL contains the reset_password query parameter
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('reset_password') && urlParams.get('reset_password') === '1') {
        // Show the reset password popup if the parameter is present
        jQuery('body').addClass('search-active');
        jQuery('.form-boxed .login').addClass('d-none');
        jQuery('.form-boxed .cheng-password').removeClass('d-none');
    }

});

function changeAlignText(align, event) {
    event.preventDefault();
    const selectedText = jQuery('.edit-text.selected-text');
    if (selectedText.length) {
        selectedText.css('text-align', align);
    } else {
        console.log('No text element is selected.');
    }
}


jQuery(document).ready(function($) {
    $('.sanas-card-preview').click(function(e) {
        e.preventDefault();
        
        var cardId = $(this).attr('data-card-id');
        var frontImage = $(this).find('.flipper .front img').attr('src');
        var backImage = $(this).find('.flipper .back img').attr('src');
        var cardTitle = $(this).find('.card-box-title h4').text();
        var bgcolor = $(this).attr('data-bg-color');

        $('#card-preview-popup').attr('data-card-id', cardId);
        
        $('#card-preview-popup').modal('show');
        
        $('#card-preview-popup .modal-title').text(cardTitle || 'Card Preview');

        $('.preview-container').attr('style', `background: ${bgcolor};`);
        
        if (frontImage) {
            $('#cover-preview').html(`
                <div class="preview-image" style="aspect-ratio: 1;">
                    <img src="${frontImage}" alt="Front design" class="img-fluid flipper animated" style="width: auto;">
                </div>
            `);
        }
        
        if (backImage) {
            $('#detail-preview').html(`
                <div class="preview-image" style="aspect-ratio: 1;">
                    <img src="${backImage}" alt="Back design" class="img-fluid flipper animated" style="width: auto;">
                </div>
            `);
        }
    });

    $('.preview-tab').click(function() {
        $('.preview-tab').removeClass('active');
        $(this).addClass('active');
        
        var tab = $(this).attr('data-tab');
        if (tab === 'detail') {
            $('.preview-container .flipper').addClass('flipped');
        } else {
            $('.preview-container .flipper').removeClass('flipped');
        }
    });

    $('.edit-design').click(function() {
        var cardId = $('#card-preview-popup').attr('data-card-id');
        window.location.href = '/user-dashboard/?dashboard=cover&card_id=' + cardId;
    });
});


// all categories popup
// jQuery(document).ready(function($) {
//     $('#view-all-categories').on('click', function() {
//         $('#all-categories-popup').modal('show');
//     });

//     $('.category-item button').on('click', function() {
//         var categoryName = $(this).find('.list-group-item-name').text();
//         var targetTab = $(this).attr('data-bs-target');

//         console.log(categoryName);
//         console.log(targetTab);

//         $('#pills-tab .nav-link').each(function() {
//             if ($(this).attr('data-bs-target') === targetTab) {
//                 $(this).text(categoryName);
//             }
//         });

//         // remove all tab-pane
//         $('.tab-pane').removeClass('active');
//         $(targetTab).addClass('active');
//         $('.nav-link').removeClass('d-none');

//         $('#all-categories-popup').modal('hide');
//     });
// });






// all categories popup
jQuery(document).ready(function($) {
    $('#view-all-categories').on('click', function() {
        $('#all-categories-popup').modal('show');
    });

    // $('.category-grid .category-item').on('click', function() {
    //     var index = $(this).index('.category-item');
    //     $('#pills-tab .nav-item .nav-link').each(function(i) {
    //         if (i === index) {
    //             $(this).addClass('active').removeClass('d-none');
    //             $(this).trigger('click');
    //         } else {
    //             $(this).addClass('d-none').removeClass('active');
    //         }
    //     });
    // });

    $('.category-item button').on('click', function() {

        var index = $(this).parent().index('.category-item');
        $('#pills-tab .nav-item .nav-link').each(function(i) {
            if (i === index) {
                $(this).addClass('active').removeClass('d-none');
                $(this).trigger('click');
            } else {
                $(this).addClass('d-none').removeClass('active');
            }
        });

        var categoryName = $(this).find('.list-group-item-name').text();
        var targetTab = $(this).data('bs-target');

        $('#pills-tab .nav-link').each(function() {
            if ($(this).data('bs-target') === targetTab) {
                $(this).text(categoryName);
            }
        });

        $('.tab-pane').removeClass('show active');
        $(targetTab).addClass('show active');

        $('#all-categories-popup').modal('hide');
    });
    
            // jQuery('.category-grid .category-item').on('click', function() {
            //     var index = jQuery(this).index('.category-item');
            //     jQuery('#pills-tab .nav-item').each(function() {
            //         jQuery(this).find('.nav-link').removeClass('active');
            //         jQuery(this).find('.nav-link').removeClass('d-none');
            //     });
                
            // });

        // var categoryName = $(this).find('.list-group-item-name').text();
        // var targetTab = $(this).attr('data-category-name');

        // console.log(categoryName);
        // console.log(targetTab);

        // $('#pills-tab .nav-link').each(function() {
        //     if ($(this).attr('data-category-name') === targetTab) {
        //         $(this).text(categoryName);
        //     }
        // });

        // // remove all tab-pane
        // $('.tab-pane').removeClass('active');
        // $(targetTab).addClass('active');
        // $('.nav-link').removeClass('d-none');

        // $('#all-categories-popup').modal('hide');
    // });
});