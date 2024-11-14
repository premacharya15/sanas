(function ($) {
    "use strict";
    $(window).on("scroll", function () {
        // header sticky
        if ($(".wl-header").length) {
            var headerScrollPos = 300;
            var stricky = $(".wl-header");
            if ($(window).scrollTop() > headerScrollPos) {
                setTimeout(function () {
                    stricky.addClass("sticky-fixed");
                })
                stricky.addClass("sticky-header--cloned");
            } else if ($(this).scrollTop() <= headerScrollPos) {
                stricky.removeClass("sticky-fixed");
                stricky.removeClass("sticky-header--cloned");
            }
        }
    });

    $(document).ready(function () {
        if ($('.header-right-end').length) {
            // mobail nav
            $(".header-right-end").click(function () {
                $(".mobile-nav-wrapper").addClass("expanded");
            });
            $(".mobile-nav-toggler").click(function () {
                $(".mobile-nav-wrapper").removeClass("expanded");
            });
            $(".header-right-end").click(function () {
                $("body").addClass("stop");
            });
            $(".mobile-nav-toggler").click(function () {
                $("body").removeClass("stop");
            });
        }
    });

    // $(document).on('click', function (e) {
    //         if (!$(e.target).closest('.form-boxed').length) {
    //             $('.form-boxed .login').removeClass('d-none');
    //             $('.form-boxed .content-succes').addClass('d-none');
    //             $('.form-boxed .sign-up').addClass('d-none');
    //             $('.form-boxed .cheng-password').addClass('d-none');
    //             $('.form-boxed .account-content-succes ').addClass('d-none');
    //             $('.form-boxed  .forgot').addClass('d-none');
    //         }
    //     });


    $('#colorPicker').on('input', function () {
        var selectedColor = $(this).val();
        $('.edit-text.selected-text').css('color', selectedColor);
    });

    function syncTextAndColor() {
    }
    syncTextAndColor();
    // coustum seceltion option 



    if ($('.featured-section').length) {
        // featured-vendors slider
        $('.featured-vendors').slick({
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



    if ($('.wl-left-slide-bar').length) {
        // iteam active class toggel
        $('.bg-img-iteam').click(function () {
            $('.bg-img-iteam').removeClass('active');
            $(this).addClass('active');
        });

        $('.tamplate-iteam').click(function () {
            $('.tamplate-iteam').removeClass('active');
            $(this).addClass('active');
        });

        $('.elements-iteam').click(function () {
            $('.elements-iteam').removeClass('active');
            $(this).addClass('active');
        });
    }
    if ($('.form-group-fluid').length) {
        // color piker value to text span
        $(' #color-picker-background, #mobail-color-picker-background').on('input', function () {
            var selectedColor = $(this).val();
            $('.color-target-code').text(selectedColor);
            $('#canvasElement').css('background-color', selectedColor);
            $('#canvasElement').css({
                'background-image': 'none'
            });

        });
        $('.color-squr data, .color-squr-1 span').click(function () {
            var hexValue = $(this).attr('color-hex-value');;
            $('#color-picker ,#mobail-color-picker , #color-picker-background, #mobail-color-picker-background').val(hexValue);
            $('.color-target-code').text(hexValue);
            $('#colorbg').val(hexValue);
        });
    }

    $('.color-squr-1>span').click(function () {
        var selectedColor = $(this).attr('color-hex-value');
        $('#canvasElement').css('background-color', selectedColor);
        $('#colorbg').val(selectedColor);
        $('#canvasElement').css({ 'background-image': 'none' });
    });

    if ($('.wl-left-slide-bar').length) {
        // selected text cheng and value textarea
        var previousText = '';

        function syncTextareaToEditText() {
            var newText = $('#selectedtext').val().trim();
            $('.edit-text.selected-text').each(function () {
                if ($(this).is('input[type="text"]') || $(this).is('input[type="number"]') || $(this).is('textarea') || $(this).is('input[type="date"]')) {
                    $(this).val(newText);
                } else {
                    $(this).text(newText);
                }
            });
        }
        function selectEditText(element) {
            $('.edit-text').removeClass('selected-text');
            $(element).addClass('selected-text');

            if ($(element).is('input[type="text"]') || $(element).is('input[type="number"]') || $(element).is('textarea') || $(element).is('input[type="date"]')) {
                $('#selectedtext').val($(element).val().trim());
            } else {
                $('#selectedtext').val($(element).text().trim());
            }
            previousText = $('#selectedtext').val();
        }
        $('.edit-text').click(function () {
            selectEditText(this);
        });
        $('#selectedtext').keyup(function () {
            syncTextareaToEditText();
        });
        $('#selectedtext').blur(function () {
            syncTextareaToEditText();
        });
    }
    if ($('.wl-left-slide-bar').length) {
        // text align
        $('.form-group .text-style-btn>a').click(function () {
            var selectedAlign = $(this).data('title');
            $('.form-group .text-style-btn>a').removeClass('active');
            $(this).addClass('active');
            updateTextAlign(selectedAlign);
        });
        function updateTextAlign(Align) {
            $('.selected-text').parent(this).css('text-align', Align);
        }
    }
    if ($('.select-wrapper').length) {
        // font size
        function setDropdownToDefault() {
            var firstOptionValue = $('#font-size option:first').val();
            if ($('#font-size').val() === '') {
                $('#font-size').val(firstOptionValue).change();
            }
        }
        setDropdownToDefault();
        $('#font-size').change(function () {
            var selectedFontSize = $(this).val();
            $('.edit-text.selected-text').css('font-size', selectedFontSize);
        });
        $('.edit-text').click(function () {
            var currentFontSize = $(this).css('font-size');
            var fontSizeValue = currentFontSize;
            if (currentFontSize.endsWith('px')) {
                fontSizeValue = currentFontSize;
            } else if (currentFontSize.endsWith('pt')) {
                fontSizeValue = parseFloat(currentFontSize) * 1.3333 + 'px';
            }
            var optionExists = false;
            $('#font-size option').each(function () {
                if ($(this).val() === fontSizeValue) {
                    optionExists = true;
                    return false;
                }
            });
            if (optionExists) {
                $('#font-size').val(fontSizeValue).change();
            } else {
                setDropdownToDefault();
            }
            $('.edit-text').removeClass('selected-text');
            $(this).addClass('selected-text');
        });
    }
    if ($('.select-wrapper').length) {
        // font-family
        function setDropdownToDefault() {
            var firstOptionValue = $('#font-family-select option:first').val();
            $('#font-family-select').val(firstOptionValue).change();
        }
        setDropdownToDefault();
        $('#font-family-select').change(function () {
            var selectedFontFamily = $(this).find('option:selected').data('title');
            $('.edit-text.selected-text').css('font-family', selectedFontFamily);
        });
        $('.edit-text').click(function () {
            var currentFontFamily = $(this).css('font-family');
            currentFontFamily = currentFontFamily.replace(/['"]/g, '');
            currentFontFamily = currentFontFamily.split(',')[0].trim();
            var optionExists = false;
            $('#font-family-select option').each(function () {
                var optionFontFamily = $(this).data('title').replace(/['"]/g, '').split(',')[0].trim();
                if (optionFontFamily === currentFontFamily) {
                    optionExists = true;
                    $('#font-family-select').val($(this).val()).change();
                    return false;
                }
            });
            if (!optionExists) {
                setDropdownToDefault();
            }
            $('.edit-text').removeClass('selected-text');
            $(this).addClass('selected-text');
        });
    }

    if ($('.select-wrapper').length) {
        // bodl italic underline
        $('.edit-text').click(function () {
            $('.text-style-btn-one > a').removeClass('active');
            var cssStyles = $(this).css(['font-weight', 'font-style', 'text-decoration', 'text-decoration-line']);
            var fontWeight = cssStyles['font-weight'] === 'bold' || cssStyles['font-weight'] === '700';
            var fontStyle = cssStyles['font-style'] === 'italic';
            var textDecoration = cssStyles['text-decoration'] === 'underline' || cssStyles['text-decoration-line'] === 'underline';
            var activeStyles = {
                'bold': fontWeight,
                'italic': fontStyle,
                'underline': textDecoration
            };
            $('.text-style-btn-one > a').each(function () {
                var style = $(this).data('title');
                if (activeStyles[style]) {
                    $(this).addClass('active');
                }
            });
        });
        $('.text-style-btn-one > a').click(function () {
            var style = $(this).data('title');
            $(this).toggleClass('active');
            var activeStyles = [];
            $('.text-style-btn-one > a.active').each(function () {
                activeStyles.push($(this).data('title'));
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
            $('.selected-text').css(cssStyles);
        }
    }

    // chart dashbord
    if ($('#guest_attending').length) {
        var con = 52;
        var pending = 24;
        var options = {
            series: [con, pending],
            colors: ['#28c38d', '#ff6666'],
            labels: [],
            markers: false,
            chart: {
                type: 'donut',
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
    if ($('#donut-chart-1').length) {
        var options = {
            series: [32, 28, 50],
            colors: ['#28c38d', '#ff6666', '#745fed'],
            labels: ['Photography', 'Catering', 'Venue'],
            markers: false,
            chart: {
                type: 'donut',
                width: 400
            },
            legend: {
                position: 'bottom'
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
                        width: 250
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
    if ($('body').length) {
        // background images cheng

        $('.bg-img-iteam img').click(function () {
            var newImgSrc = $(this).attr('src');
            $('section.wl-main-canvas .inner-colum').css('background-image', 'url("' + newImgSrc + '")');

            $('.bg-img-iteam').removeClass('active');
            $(this).parent().addClass('active');
        });
        var imgSrc = $('.tamplate-iteam>img').attr('src');
        $('section.wl-main-canvas .card-canvas>img').css('background-image', 'url("' + imgSrc + '")');

        $('.tamplate-iteam>img').click(function () {
            var newImgSrc = $(this).attr('src');
            $('section.wl-main-canvas .card-canvas>img').attr('src', newImgSrc);
            $('.tamplate-iteam').removeClass('active');
            $(this).parent().addClass('active');
        });
        $('#color-picker-background, #mobail-color-picker-background ').on('input', function () {
            var selectedColor = $(this).val();
            $('#canvasElement').css('background-color', selectedColor);
            $('#canvasElement').css({
                'background-image': 'none'
            });
        });

        var colorbg = $('#colorbg').val();
        if (colorbg) {
            $('#canvasElement').css('background-color', colorbg);
        }
        else {
            $('#canvasElement').css('background-color', initialColor);
        }

        var initialColor = $('#color-picker-background, #mobail-color-picker-background').val();
        $('#canvas-element').css('background-color', initialColor);
        $('.color-squr-1>data').click(function () {
            var selectedColor = $(this).attr('value');
            $('#canvasElement').css('background-color', selectedColor);
            $('#canvasElement').css({ 'background-image': 'none' });
        });
        $('.elements-iteam img').click(function () {
            var imgSrc = $(this).attr('src');

            $('#stiker-post').attr('src', imgSrc);

            $('.stiker-add').fadeIn();
            $('.stiker-add img').css('max-width', 57);
        });
    }
    if ($('.guest-count').length) {
        // rsvp guest count
        $('.guest-count .count .plues').on('click', function () {
            var totalGuestsElement = $(this).siblings('.total-guest');
            var currentCount = parseInt(totalGuestsElement.text(), 10);
            totalGuestsElement.text(currentCount + 1);
        });
        $('.guest-count .count .mines').on('click', function () {
            var totalGuestsElement = $(this).siblings('.total-guest');
            var currentCount = parseInt(totalGuestsElement.text(), 10);
            if (currentCount > 0) {
                totalGuestsElement.text(currentCount - 1);
            }
        });
    }
    // guest-list data table
    if ($('.table-responsive').length) {
        $('#budget-expense').DataTable();
        $('#guest-list-Table').DataTable();
        $('#vendor-table').DataTable();
        $('#guest-contact-list').DataTable();
    }
    if ($('.registry').length) {
        $('#program-time1').on('click', '.deletebtn', function () {
            $(this).closest('.gift-registry-input').remove();
        });
    }
    if ($('.wl-fuc-timing').length) {
        // rsvp page add event and time
        $('#add-event-btn').on('click', function () {
            var newRow = '<tr>' +
                '<td class="edit-text"  contenteditable="true">Event</td>' +
                '<td class="edit-text text-start"  contenteditable="true">Time</td>' +
                '<td><button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button></td>' +
                '</tr>';
            $('#program-time').append(newRow);
        });
    }
    if ($('.form-text-edit, .mobaile-form-text-edit').length) {
        // text color
        function syncTextAndColor() {
            var selectedTextColor = $('.edit-text.selected-text').css('color');
            var hexColor = rgbToHex(selectedTextColor);
            $('#color-picker').val(hexColor);
            $('#mobail-color-picker').val(hexColor);
            $('#color-picker-background').val(hexColor);
            $('#mobail-color-picker-background').val(hexColor);
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
            $('.edit-text.selected-text').css('color', color);
            syncTextAndColor();
        }
        $('.edit-text').click(function () {
            $('.edit-text').removeClass('selected-text');
            $(this).addClass('selected-text');
            syncTextAndColor();
        });
        $('.color-squr>data').click(function () {
            var color = $(this).attr('value');
            setTextColor(color);
        });
        $('#color-picker, #color-picker-background, #mobail-color-picker-background').on('input', function () {
            var selectedColor = $(this).val();
            setTextColor(selectedColor);
        });
    }
    // Delete Row Button Click Event
    $('#program-time').on('click', '.deletebtn', function () {
        $(this).closest('tr').remove();
    });
    if ($('.event-checkbox').length) {
        $('#selectAll').change(function () {
            $('.event-checkbox input[type="checkbox"]').prop('checked', this.checked);
        });
        $('.event-checkbox input[type="checkbox"]').change(function () {
            var allChecked = true;
            $('.event-checkbox input[type="checkbox"]').each(function () {
                if (!this.checked) {
                    allChecked = false;
                }
            });
            $('#selectAll').prop('checked', allChecked);
        });
    }
    if ($('.guests-box').length) {
        // all checkboc checked
        $('#all-select-chechbox').change(function () {
            $('.guests-box .table-box .table tr td input[type="checkbox"]').prop('checked', this.checked);
        });
        $('.guests-box .table-box .table tr td input[type="checkbox"]').change(function () {
            var allChecked = true;
            $(' .guests-box .table-box .table tr td input[type="checkbox"]').each(function () {
                if (!this.checked) {
                    allChecked = false;
                }
            });
            $('#all-select-chechbox').prop('checked', allChecked);
        });
    }
    if ($('.guests-box').length) {
        // all checkboc checked
        $('#all-select-chechbox-one').change(function () {
            $('.contact .table tr td input[type="checkbox"]').prop('checked', this.checked);
        });
        $('.contact .table tr td input[type="checkbox"]').change(function () {
            var allChecked = true;
            $(' .contact .table tr td input[type="checkbox"]').each(function () {
                if (!this.checked) {
                    allChecked = false;
                }
            });
            $('#all-select-chechbox-one').prop('checked', allChecked);
        });
    }
    if ($('.guest-list-footer').length) {
        // on off sweech
        $('.check-toggle').click(function () {
            $(this).toggleClass("active");
        });
    }
    //Tabs Box
    if ($('.tabs-box').length) {
        $('.tabs-box .tab-buttons .tab-btn').on('click', function (e) {
            e.preventDefault();
            var windowWidth = $(window).width();
            var target = $($(this).attr('data-tab'));
            var TabsContent = target.parents('.tabs-box').find('.tabs-content');
            if ($(target).is(':visible')) {
                return false;
            } else {
                $(this).parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                $(this).addClass('active-btn');
                target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab');
                $(target).fadeIn(300);
                $(target).addClass('active-tab');
            }
        });
    }
    // Tabs Box
    if ($('.tabs-box-3').length) {
        $('.tabs-box-3>.tab-buttons>.tab-btn').on('click', function (e) {
            e.preventDefault();
            var windowWidth = $(window).width();
            var target = $($(this).attr('data-tab'));
            var TabsContent = target.parents('.tabs-box-3').find('.tabs-content');

            if ($(target).is(':visible')) {
                return false;
            } else {
                $(this).parents('.tabs-box-3').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                $(this).addClass('active-btn');
                target.parents('.tabs-box-3').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box-3').find('.tabs-content').find('.tab').removeClass('active-tab');
                $(target).fadeIn(300);
                $(target).addClass('active-tab');
            }
        });
    }
    // table delete btn

    // enter valid email
    if ($('.search-popup').length) {
        // email validation
        // $('#emailForm').submit(function (event) {
        //     var email = $('#login-email, #sign-up-email , #forgot-email').val();
        //     if (!isValidEmail(email)) {
        //         $('.error-message').show();
        //         addErrorStyles();
        //         event.preventDefault();
        //     } else {
        //         $('.error-message').hide();
        //         removeErrorStyles();
        //     }
        // });
        // $('#login-email, #sign-up-email , #forgot-email').on('input', function () {
        //     var email = $(this).val();
        //     if (isValidEmail(email)) {
        //         $('.error-message').hide();
        //         removeErrorStyles();
        //     } else {
        //         $('.error-message').show();
        //         addErrorStyles();
        //         $('.btn-block').off('click');
        //     }
        // });
        function isValidEmail(email) {
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
        function addErrorStyles() {
            $('#login-email, #sign-up-email , #forgot-email').addClass('email-error');
        }
        function removeErrorStyles() {
            $('#login-email, #sign-up-email , #forgot-email').removeClass('email-error');
        }
    }
    if ($('.check-box-from-field').length) {
        // yes no not sore check box
        $('.check-box-from-field input[type="checkbox"]').change(function () {
            var checked = $(this).prop('checked');
            if (checked) {
                $('.check-box-from-field input[type="checkbox"]').not(this).prop('checked', false);
            }
        });
    }
    if ($('#add-group-popup').length) {
        // add meal
        $("#add-meal").addClass("d-none");

        $(".add-meal").click(function () {
            $("#add-meal").removeClass("d-none").addClass("d-block");
        });
        $('#add_meal_button').click(function () {
            var mealName = $('#add_meal_input').val().trim();
            if (mealName !== '') {
                var newItem = $('<li>').addClass('d-flex justify-content-between align-items-center');
                var span = $('<span>').text(mealName);
                var deleteLink = $('<a>').attr('href', 'javascript:').addClass('action-links')
                    .html('<span class="fa fa-trash"></span>');
                deleteLink.click(function () {
                    newItem.remove();
                });
                newItem.append(span).append(deleteLink);
                $('#add_new_meals_options').append(newItem);
                $('#add_meal_input').val('');
            }
        });
    }
    if ($('#add-group-popup').length) {
        // add group
        $('#add_new_group_button').click(function () {
            var groupName = $('#add_new_group_input').val().trim();
            if (groupName !== '') {
                var newItem = $('<li>').addClass('d-flex justify-content-between align-items-center');
                var span = $('<span>').text(groupName);
                var deleteLink = $('<a>').attr('href', 'javascript:').addClass('action-links')
                    .html('<span class="fa fa-trash"></span>');
                deleteLink.click(function () {
                    newItem.remove();
                });
                newItem.append(span).append(deleteLink);
                $('#guest_group_list_section').append(newItem);
                $('#add_new_group_input').val('');
            }
        });
    }
    if ($('#add_new_category').length) {
        // add category
        $('#add_new_category').click(function () {
            var categoryName = $('#add_new_category_input').val().trim();
            var categoryCost = $('#add_category_cost_input').val().trim();
            if (categoryName !== '' && categoryCost !== '') {
                var newItem = $('<li>');
                var link = $('<a>').attr('href', '#');
                var itemContent = $('<div>').addClass('ttl')
                    .html('<i class="fa-solid fa-tag"></i><span class="txt">' + categoryName + '</span>');
                var itemCost = $('<div>').addClass('count')
                    .html('<span>' + categoryCost + '</span>');
                link.append(itemContent).append(itemCost);
                newItem.append(link);
                $('#category_cost_section').append(newItem);
                $('#add_new_category_input').val('');
                $('#add_category_cost_input').val('');
            }
        });
    }
    if ($('.inner-box').length) {
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
            $('.flipper').each(function () {
                if (isElementInViewport($(this))) {
                    $(this).addClass('animated');
                } else {
                    $(this).removeClass('animated');
                }
            });
        }
        $(window).on('scroll', handleAnimation);
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
        var $disabledResults = $(".upload-Category");
        $disabledResults.select2();
    }
    if (jQuery('.select-wrapper , .group-option-inner , .contact-form').length) {
        // filter page select option
        var $disabledResults = jQuery(".select-inner , .category-list , .group-option , add-group , .Subject");
        $disabledResults.select2();
    }

    if (jQuery('#header-options').length) {
        jQuery('#header-options').click(function () {
            var headermsg = jQuery("#header-options-msg").val();
            show_alert_message('Are you sure you’d like to exit?', headermsg, 'yes');
        });
    }

    if (jQuery('#btn-exit').length) {

        jQuery('#btn-exit').click(function () {
            window.location.href = jQuery(this).attr('data-redirect');
        });
    }

});
// serch suggestion list
if (jQuery('.search-form').length) {
    var templateNames = [
        "Wedding",
        "Haldi",
        "Mahandi",
        "sangeet",
        "Reception",
        "Engagement",
        "Half Saree",
        "Dhoti",
        "Pooja",
        "Naming Ceremony",
        "Graduation",
        "Birthday",
        "1st Brithday",
        "16th Desi Brithday",
        "Baby Shower",
        "Diwali",
        "Garba",
        "Holi",
        "Personalised cards",
        "House Warming",
        "Desi Vendors",
        "Diamond Jewellery",
        "Blog",
    ];
    document.addEventListener("DOMContentLoaded", function () {
        var searchInput = document.getElementById('search');
        var suggestionList = document.getElementById('suggestionlist');
        if (!searchInput || !suggestionList) {
            console.error("Search input or suggestion list not found.");
            return;
        }
        searchInput.addEventListener('input', function () {
            var inputText = this.value.toLowerCase();
            var suggestions = [];

            templateNames.forEach(function (template) {
                if (template.toLowerCase().includes(inputText)) {
                    suggestions.push(template);
                }
            });
            showSuggestions(suggestions);
        });
        function showSuggestions(suggestions) {
            suggestionList.innerHTML = '';

            suggestions.forEach(function (suggestion) {
                var listItem = document.createElement('li');
                listItem.textContent = suggestion;
                suggestionList.appendChild(listItem);
            });
            suggestionList.style.display = suggestions.length > 0 ? 'block' : 'none';
        }
        document.addEventListener('click', function (e) {
            if (e.target && e.target.matches('#suggestionlist li')) {
                searchInput.value = e.target.textContent;
                suggestionList.style.display = 'none';
            }
        });
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target)) {
                suggestionList.style.display = 'none';
            }
        });
    });
}
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


// Function to show the preloader

function show_alert_message(title, msg, footer = 'no') {
    // Show the modal

    var modalElement = document.getElementById('modal_html_alert');
    var modal = new bootstrap.Modal(modalElement);

    // Update modal content
    modalElement.querySelector('.modal-title').innerHTML = title;
    modalElement.querySelector('.modal-body').innerHTML = msg;

    // Show the modal
    if (footer == 'no') {
        var footerElement = modalElement.querySelector('.modal-footer');
        footerElement.style.display = 'none';
    } else {
        var footerElement = modalElement.querySelector('.modal-footer');
        footerElement.style.display = 'flex';

    }

    modal.show();
}
// Example: Show the preloader manually and hide it after a delay
jQuery(window).on('load', function () {
    // Simulate loading process (e.g., fetching data)
    setTimeout(function () {
        hidePreloader();
    }, 500); // Adjust this time based on your actual loading process
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


    if ($('body').length) {
        // login popup
        $('.login-in,.sanas-login-popup').on('click', function (e) {
            e.stopPropagation();
            $('body').addClass('search-active');
            $('#ajaxvalue').val('0');
        });
        $('.login-complate').on('click', function () {
            $('body').removeClass('search-active');
        });

        $(document).keydown(function (e) {
            if (e.keyCode == 27) {
                $('body').removeClass('search-active');
            }
        });
        $('.form-boxed').on('click', function (e) {
            e.stopPropagation();
        });
        $('.close-search').on('click', function () {
            $('body').removeClass('search-active');
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.form-boxed').length) {
                $('body').removeClass('search-active');
            }
        });
    }

    // login form
    $('.form-boxed .btn-forgot').click(function (e) {
        e.preventDefault();
        $('.form-boxed  .forgot').removeClass('d-none');
        $('.form-boxed .login').addClass('d-none');
    });
    $('.form-boxed .cheng-password .btn-block').on('click', function () {
        $('.form-boxed .login').removeClass('d-none');
        $('.form-boxed .cheng-password').addClass('d-none');
    });
    $('.form-boxed .lower-social-box p .sign-up-2').on('click', function () {
        $('.form-boxed .sign-up').removeClass('d-none');
        $('.form-boxed .login').addClass('d-none');
    });
    $('.form-boxed .sign-in').on('click', function () {
        $('.form-boxed .login').removeClass('d-none');
        $('.form-boxed .sign-up').addClass('d-none');
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


