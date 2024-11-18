<?php
if (class_exists('CSF')) {
    global $sanas_theme_options;
    $sanas_theme_options = 'sanas_theme_options';
    CSF::createOptions($sanas_theme_options, array(
        //framework title
        'framework_title' => esc_html__('Sanas Options', 'sanas'),
        'framework_class' => '',
        //menu settings
        'menu_title' => esc_html__('Sanas Options', 'sanas'),
        'menu_slug' => 'sanas_theme_options',
        'menu_type' => 'menu',
        'menu_capability' => 'manage_options',
        'menu_icon' => '',
        'menu_position' => null,
        'menu_hidden' => false,
        'menu_parent' => '',
        // menu extras
        'show_bar_menu' => true,
        'show_sub_menu' => true,
        'show_in_network' => true,
        'show_in_customizer' => false,
        'show_search' => true,
        'show_reset_all' => true,
        'show_reset_section' => true,
        'show_footer' => true,
        'show_all_options' => true,
        'show_form_warning' => true,
        'sticky_header' => true,
        'save_defaults' => true,
        'ajax_save' => true,
        // footer
        'footer_text' => '',
        'footer_after' => '',
        'footer_credit' => '',
        // database model
        'database' => '',
        'transient_time' => 0,
        // contextual help
        'contextual_help' => array(),
        'contextual_help_sidebar' => '',
        // typography options
        'enqueue_webfont' => true,
        'async_webfont' => false,
        // others
        'output_css' => true,
        // theme and wrapper classname
        'theme' => 'dark',
        'class' => '',
        // external default values
        'defaults' => array(),
    ));
    // Header Settings
    CSF::createSection($sanas_theme_options, array(
        'id' => 'sanas_header_settings',
        'title' => esc_html__('Header Settings', 'sanas'),
        'icon' => 'fa fa-header',
    ));
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_header_settings',
        'title' => esc_html__('Header Logo', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'subtitle' => esc_html__('Add your Information for Header Section', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_header_logo_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Logo', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_header_logo',
                'type' => 'media',
                'title' => esc_html__('Logo Image', 'sanas'),
                'library' => 'image',
                'preview' => true,
                'preview_size' => 'full',
                'button_title' => esc_attr__('Upload Logo', 'sanas'),
                'dependency' => array('sanas_header_logo_enable', '==', true),
            ),
            array(
                'id' => 'sanas_header_logo_width',
                'type' => 'slider',
                'title' => esc_html__('Logo  Width', 'sanas'),
                'min' => 0,
                'max' => 500,
                'default' => 126,
                'step' => 1,
                'unit' => 'px',
                'dependency' => array('sanas_header_logo_enable', '==', true),
            ),
            array(
                'id' => 'sanas_header_logo_height',
                'type' => 'slider',
                'title' => esc_html__('Logo  Height', 'sanas'),
                'min' => 0,
                'max' => 500,
                'default' => 58,
                'step' => 1,
                'unit' => 'px',
                'dependency' => array('sanas_header_logo_enable', '==', true),
            ),
        ),
    ));
    // Header Genral Options
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_header_settings',
        'title' => esc_html__('Header General Options', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'subtitle' => esc_html__('Add your Information for Header General Section', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_header_login_button_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Login Button', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_header_login_button_text',
                'type' => 'text',
                'title' => esc_html__('Login Button text', 'sanas'),
                'default' => esc_html__('Sign In / Sign Up', 'sanas'),
                'dependency' => array('sanas_header_login_button_enable', '==', true),
            ),
        ),
    ));
    // Login Settings
    CSF::createSection($sanas_theme_options, array(
        'id' => 'sanas_login_popup_settings',
        'title' => esc_html__('Login Settings', 'sanas'),
        'icon' => 'far fa-user',
    ));
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_login_popup_settings',
        'title' => esc_html__('Sign In Popup Settings', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'subtitle' => esc_html__('Add your Information for Sign In Popup', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_signin_popup_image_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Image', 'sanas'),
                'default' => true,
            ),
            array(
            'id' => 'sanas_signin_popup_image',
            'type' => 'media',
            'title' => esc_html__('Popup Image', 'sanas'),
            'library' => 'image',
            'preview' => true,
            'preview_size' => 'full',
            'button_title' => esc_attr__('Upload Image', 'sanas'),
            'dependency' => array('sanas_signin_popup_image_enable', '==', true),
            ),
            array(
                'id' => 'sanas_signin_popup_title_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_signin_popup_title',
                'type' => 'text',
                'title' => esc_html__('Popup Title', 'sanas'),
                'default' => esc_html__('Create unforgettable invites', 'sanas'),
                'dependency' => array('sanas_signin_popup_title_enable', '==', true),
            ),
            array(
                'id' => 'sanas_signin_popup_subtitle_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Sub Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_signin_popup_subtitle',
                'type' => 'text',
                'title' => esc_html__('Popup Sub Title', 'sanas'),
                'default' => esc_html__('Sign In account now', 'sanas'),
                'dependency' => array('sanas_signin_popup_subtitle_enable', '==', true),
            ),
            array(
                'id' => 'sanas_signin_popup_page_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Page', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_signin_popup_page_info',
                'type' => 'group',
                'title' => esc_html__('Sign In Page Info', 'sanas'),
                'dependency' => array('sanas_signin_popup_page_enable', '==', true),
                'fields' => array(
                    array(
                        'id' => 'sanas_signin_popup_page_title',
                        'title' => esc_html__('Title', 'sanas'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'sanas_signin_popup_page_url',
                        'type' => 'link',
                        'title' => 'Page Url',
                    ),
                ),
                'default' => array(
                    array(
                        'sanas_signin_popup_page_title' => esc_html__('Terms of Use', 'sanas'),
                    ),
                    array(
                        'sanas_signin_popup_page_title' => esc_html__('Privacy Policy', 'sanas'),
                    ),
                ),
            ),
        ),
    ));
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_login_popup_settings',
        'title' => esc_html__('Sign Up Popup Settings', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'subtitle' => esc_html__('Add your Information for Sign Up Popup', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_signup_popup_image_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Image', 'sanas'),
                'default' => true,
            ),
            array(
            'id' => 'sanas_signup_popup_image',
            'type' => 'media',
            'title' => esc_html__('Popup Image', 'sanas'),
            'library' => 'image',
            'preview' => true,
            'preview_size' => 'full',
            'button_title' => esc_attr__('Upload Image', 'sanas'),
            'dependency' => array('sanas_signup_popup_image_enable', '==', true),
            ),
            array(
                'id' => 'sanas_signup_popup_title_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_signup_popup_title',
                'type' => 'text',
                'title' => esc_html__('Popup Title', 'sanas'),
                'default' => esc_html__('Create unforgetable invites', 'sanas'),
                'dependency' => array('sanas_signup_popup_title_enable', '==', true),
            ),
            array(
                'id' => 'sanas_signup_popup_subtitle_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Sub Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_signup_popup_subtitle',
                'type' => 'text',
                'title' => esc_html__('Popup Sub Title', 'sanas'),
                'default' => esc_html__('Create an account now', 'sanas'),
                'dependency' => array('sanas_signup_popup_subtitle_enable', '==', true),
            ),
            array(
                'id' => 'sanas_signup_popup_page_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Page', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_signup_popup_page_info',
                'type' => 'group',
                'title' => esc_html__('Sign Up Page Info', 'sanas'),
                'dependency' => array('sanas_signup_popup_page_enable', '==', true),
                'fields' => array(
                    array(
                        'id' => 'sanas_signup_popup_page_title',
                        'title' => esc_html__('Title', 'sanas'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'sanas_signup_popup_page_url',
                        'type' => 'link',
                        'title' => 'Page Url',
                    ),
                ),
                'default' => array(
                    array(
                        'sanas_signup_popup_page_title' => esc_html__('Terms of Use', 'sanas'),
                    ),
                    array(
                        'sanas_signup_popup_page_title' => esc_html__('Privacy Policy', 'sanas'),
                    ),
                ),
            ),
        ),
    ));


    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_login_popup_settings',
        'title' => esc_html__('Email Popup Settings', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'subtitle' => esc_html__('Add your Information for Email Popup', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_email_popup_image_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Image', 'sanas'),
                'default' => true,
            ),
            array(
            'id' => 'sanas_email_popup_image',
            'type' => 'media',
            'title' => esc_html__('Popup Image', 'sanas'),
            'library' => 'image',
            'preview' => true,
            'preview_size' => 'full',
            'button_title' => esc_attr__('Upload Image', 'sanas'),
            'dependency' => array('sanas_email_popup_image_enable', '==', true),
            ),
            array(
                'id' => 'sanas_email_popup_title_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_email_popup_title',
                'type' => 'text',
                'title' => esc_html__('Popup Title', 'sanas'),
                'default' => esc_html__('Create unforgetable invites', 'sanas'),
                'dependency' => array('sanas_email_popup_title_enable', '==', true),
            ),
            array(
                'id' => 'sanas_email_popup_subtitle_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Sub Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_email_popup_subtitle',
                'type' => 'text',
                'title' => esc_html__('Popup Sub Title', 'sanas'),
                'default' => esc_html__('Verify Email Now', 'sanas'),
                'dependency' => array('sanas_email_popup_subtitle_enable', '==', true),
            ),
            array(
                'id' => 'sanas_email_popup_page_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Page', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_email_popup_page_info',
                'type' => 'group',
                'title' => esc_html__('EmailPage Info', 'sanas'),
                'dependency' => array('sanas_email_popup_page_enable', '==', true),
                'fields' => array(
                    array(
                        'id' => 'sanas_email_popup_page_title',
                        'title' => esc_html__('Title', 'sanas'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'sanas_email_popup_page_url',
                        'type' => 'link',
                        'title' => 'Page Url',
                    ),
                ),
                'default' => array(
                    array(
                        'sanas_email_popup_page_title' => esc_html__('Terms of Use', 'sanas'),
                    ),
                    array(
                        'sanas_email_popup_page_title' => esc_html__('Privacy Policy', 'sanas'),
                    ),
                ),
            ),
        ),
    ));
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_login_popup_settings',
        'title' => esc_html__('Password Popup Settings', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'subtitle' => esc_html__('Add your Information for Password Popup', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_password_popup_image_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Image', 'sanas'),
                'default' => true,
            ),
            array(
            'id' => 'sanas_password_popup_image',
            'type' => 'media',
            'title' => esc_html__('Popup Image', 'sanas'),
            'library' => 'image',
            'preview' => true,
            'preview_size' => 'full',
            'button_title' => esc_attr__('Upload Image', 'sanas'),
            'dependency' => array('sanas_password_popup_image_enable', '==', true),
            ),
            array(
                'id' => 'sanas_password_popup_title_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_password_popup_title',
                'type' => 'text',
                'title' => esc_html__('Popup Title', 'sanas'),
                'default' => esc_html__('Create unforgetable invites', 'sanas'),
                'dependency' => array('sanas_password_popup_title_enable', '==', true),
            ),
            array(
                'id' => 'sanas_password_popup_subtitle_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Sub Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_password_popup_subtitle',
                'type' => 'text',
                'title' => esc_html__('Popup Sub Title', 'sanas'),
                'default' => esc_html__('Change Password now', 'sanas'),
                'dependency' => array('sanas_password_popup_subtitle_enable', '==', true),
            ),
            array(
                'id' => 'sanas_password_popup_page_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Page', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_password_popup_page_info',
                'type' => 'group',
                'title' => esc_html__('Password Page Info', 'sanas'),
                'dependency' => array('sanas_password_popup_page_enable', '==', true),
                'fields' => array(
                    array(
                        'id' => 'sanas_password_popup_page_title',
                        'title' => esc_html__('Title', 'sanas'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'sanas_password_popup_page_url',
                        'type' => 'link',
                        'title' => 'Page Url',
                    ),
                ),
                'default' => array(
                    array(
                        'sanas_password_popup_page_title' => esc_html__('Terms of Use', 'sanas'),
                    ),
                    array(
                        'sanas_password_popup_page_title' => esc_html__('Privacy Policy', 'sanas'),
                    ),
                ),
            ),
        ),
    ));

    // Email Setting Settings
    CSF::createSection($sanas_theme_options,array(
        'id'        => 'sanas_email_settings',
        'title'     => esc_html__('Email Settings','sanas'),
        'icon'      => 'far fa-envelope'
    ));

    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_email_settings',
        'title' => esc_html__('Email Options', 'sanas'),
        'icon' => 'fas fa-sliders-h',
        'subtitle' => esc_html__('Email Options', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_enable_default_email',
                'type' => 'switcher',
                'title' => esc_html__('From Change Email & Name', 'sanas'),
                'default' => false,
            ),
            array(
                'id' => 'sanas_default_email_value',
                'type' => 'text',
                'title' => esc_html__('Change Sender Email address', 'sanas'),
                'default' => '',
            ),
            array(
                'id' => 'sanas_default_title_value',
                'type' => 'text',
                'title' => esc_html__('Change Sender Form Name', 'sanas'),
                'default' => '',
            ),
            array(
                'type' => 'notice',
                'style' => 'info',
                'content' => 'Sanas User Signup Email Template like %%username as User Name,%%website_url as Website URL',
            ),
            array(
                'id' => 'sanas_user_signup_subject',
                'type' => 'text',
                'title' => 'Sanas User Signup Subject',
            ),
            array(
                'id' => 'sanas_user_signup_body',
                'type' => 'wp_editor',
                'wpautop' => false,
                'title' => 'Sanas User Signup Body',
            ),
            array(
              'type'    => 'notice',
              'style'   => 'info',
              'content' => 'Forgot Password Email Template like %%username as User Name,%%website_url as Website URL%%,%%forgotlink as Forgot Passwordlink',
            ),
            array(
              'id'    => 'sanas_user_forgotpassword_subject',
              'type'  => 'text',
              'title' => 'Forgot Password Email Subject',
            ),                 
            array(
              'id'    => 'sanas_user_forgotpassword_body',
              'type'  => 'wp_editor',
              'wpautop' => false,
              'title' => 'Forgot Password Email Body',
            ),            
            array(
              'type'    => 'notice',
              'style'   => 'info',
              'content' => 'Reset Password Email Template like %%username as User Name,%%website_url as Website URL',
            ),
            array(
              'id'    => 'sanas_user_resetpassword_subject',
              'type'  => 'text',
              'title' => 'Reset Password Email Subject',
            ),                 
            array(
              'id'    => 'sanas_user_resetpassword_body',
              'type'  => 'wp_editor',
              'title' => 'Reset Password Email Body',
              'settings' => array(   'textarea_rows' => 10, 'tinymce' => array('wpautop' => false) ),
            ),            
            array(
              'type'    => 'notice',
              'style'   => 'info',
              'content' => 'Shortname for Password Email Template like %%username as User Name,%%website_url as Website URL',
            ),
            array(
              'id'    => 'sanas_guest_invite_email_subject',
              'type'  => 'text',
              'title' => 'Guest Invitation Email Subject',
            ),                 
            array(
              'id'    => 'sanas_guest_invite_email_body',
              'type'  => 'wp_editor',
              'title' => 'Guest Invitation Email Body',
              'settings' => array(   'textarea_rows' => 10, 'tinymce' => array('wpautop' => false) ),
            ),  
             array(
              'type'    => 'notice',
              'style'   => 'info',
              'content' => 'Shortname for Email Template like %%hostname Host Nane,%%eventname Event Name,%%eventdate Event Date,%%eventtime Event Time,%%eventlocation Event Location,%%eventimg Event Image,%%guestname Guest Name,%%invitelink Invitation Link',
            ),
            array(
              'id'    => 'sanas_guest_invite_firstime_subject',
              'type'  => 'text',
              'title' => 'Guest Invitation Firsttime Email Subject',
            ),                 
            array(
              'id'    => 'sanas_guest_invite_firstime_body',
              'type'  => 'wp_editor',
              'title' => 'Guest Invitation Firsttime Email Body',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
           ),
            array(
              'id'    => 'sanas_guest_declined_subject',
              'type'  => 'text',
              'title' => 'Guest Response Declined Subject',
            ),                 
            array(
              'id'    => 'sanas_guest_declined_body',
              'type'  => 'wp_editor',
              'title' => 'Guest Response Declined Body',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
           ),
            array(
              'id'    => 'sanas_guest_maybe_subject',
              'type'  => 'text',
              'title' => 'Guest Response Maybe Subject',
            ),                 
            array(
              'id'    => 'sanas_guest_maybe_body',
              'type'  => 'wp_editor',
              'title' => 'Guest Response Maybe Body',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
           ),            
           array(
              'id'    => 'sanas_guest_two_week_before_subject',
              'type'  => 'text',
              'title' => '2 Week Before Email Subject - unused',
            ),                 
            array(
              'id'    => 'sanas_guest_two_week_before_body',
              'type'  => 'wp_editor',
              'title' => '2 Week Before Email Body - unused',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
           ), 
            array(
              'id'    => 'sanas_guest_one_week_before_subject',
              'type'  => 'text',
              'title' => '1 Week Before Email Subject',
            ),                 
            array(
              'id'    => 'sanas_guest_one_week_before_body',
              'type'  => 'wp_editor',
              'title' => '1 Week Before Email Body',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
           ),
            array(
              'id'    => 'sanas_guest_one_week_before_accepted_subject',
              'type'  => 'text',
              'title' => '1 Week Before (Accepted) Subject',
            ),                 
            array(
              'id'    => 'sanas_guest_one_week_before_accepted_body',
              'type'  => 'wp_editor',
              'title' => '1 Week Before (Accepted) Body',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
           ),                       
           array(
              'id'    => 'sanas_guest_one_day_before_subject',
              'type'  => 'text',
              'title' => '1 Day Before (Accepted) Subject - unused',
            ),                 
            array(
              'id'    => 'sanas_guest_one_day_before_body',
              'type'  => 'wp_editor',
              'title' => '1 Day Before (Accepted) Body - unused',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
           ),                       
           array(
              'id'    => 'sanas_guest_next_day_afterparty_subject',
              'type'  => 'text',
              'title' => 'Next Day after party Subject',
            ),                 
            array(
              'id'    => 'sanas_guest_next_day_afterparty_body',
              'type'  => 'wp_editor',
              'title' => 'Next Day after party Body',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
           )
           ,                       
           array(
              'id'    => 'sanas_guest_1week_afterparty_subject',
              'type'  => 'text',
              'title' => 'After 1 week party Subject - unused',
            ),                 
            array(
              'id'    => 'sanas_guest_1week_afterparty_body',
              'type'  => 'wp_editor',
              'title' => 'After 1 week  party Body - unused',
              'settings' => array(   'textarea_rows' => 15, 'tinymce' => array('wpautop' => false) ),                       
            ),
            array(
                "type" => "notice",
                "style" => "info",
                "content" => "-----------------------------------",
            ),
            array(
                'id' => 'sanas_guest_3days_before_subject',
                'type' => 'text',
                'title' => '3 days before the event',
            ),
            array(
                'id' => 'sanas_guest_3days_before_body',
                'type' => 'wp_editor',
                'wpautop' => false,
                'title' => '3 days before the event',
            ),
            array(
                'id' => 'sanas_guest_1days_before_subject',
                'type' => 'text',
                'title' => '1 day before the event',
            ),
            array(
                'id' => 'sanas_guest_1days_before_body',
                'type' => 'wp_editor',
                'wpautop' => false,
                'title' => '1 day before the event',
            ),
            array(
                'id' => 'sanas_guest_everyweek_subject',
                'type' => 'text',
                'title' => 'every week until the event starts',
            ),
            array(
                'id' => 'sanas_guest_everyweek_body',
                'type' => 'wp_editor',
                'wpautop' => false,
                'title' => 'every week until the event starts',
            ),
            array(
                'id' => 'sanas_guest_yes_subject',
                'type' => 'text',
                'title' => 'guest response yes',
            ),
            array(
                'id' => 'sanas_guest_yes_body',
                'type' => 'wp_editor',
                'wpautop' => false,
                'title' => 'guest response yes',
            ),
            array(
                'id' => 'sanas_guest_update_subject',
                'type' => 'text',
                'title' => 'update guest info/count',
            ),
            array(
                'id' => 'sanas_guest_update_body',
                'type' => 'wp_editor',
                'wpautop' => false,
                'title' => 'update guest info/count',
            ),
            

    )));

    // Layout and Options Settings
    CSF::createSection($sanas_theme_options,array(
        'id'        => 'sanas_layout_settings',
        'title'     => esc_html__('Layout and Options','sanas'),
        'icon'      => 'fa fa-calculator'
    ));
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_layout_settings',
        'title' => esc_html__('404 Error Page', 'sanas'),
        'icon' => 'fa fa-exclamation-triangle',
        'subtitle' => esc_html__('Add your Information for Error Page', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_enable_error_banner_image',
                'type' => 'switcher',
                'title' => esc_html__('Enable Banner Image', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_error_banner_image',
                'type' => 'media',
                'title' => esc_html__('Error Image', 'sanas'),
                'library' => 'image',
                'preview' => true,
                'preview_size' => 'full',
                'button_title' => esc_attr__('Upload Image', 'sanas'),
                'dependency' => array('sanas_enable_error_banner_image', '==', true),
            ),
            array(
                'id' => 'sanas_enable_error_banner_title',
                'type' => 'switcher',
                'title' => esc_html__('Enable Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_error_banner_title',
                'type' => 'text',
                'title' => esc_html__('Error Title', 'sanas'),
                'default' => esc_html__('Oh no. We lost this page', 'sanas'),
                'dependency' => array('sanas_enable_error_banner_title', '==', true),
            ),
            array(
                'id' => 'sanas_enable_error_banner_subtitle',
                'type' => 'switcher',
                'title' => esc_html__('Enable Sub Title', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_error_banner_subtitle',
                'type' => 'text',
                'title' => esc_html__('Error Sub Title', 'sanas'),
                'default' => esc_html__('We searched everywhere but couldn’t find what you’re looking for. Let’s find a better place for you to go.', 'sanas'),
                'dependency' => array('sanas_enable_error_banner_subtitle', '==', true),
            ),
            array(
                'id' => 'sanas_enable_error_banner_button',
                'type' => 'switcher',
                'title' => esc_html__('Enable Button', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_error_banner_button_text',
                'type' => 'text',
                'title' => esc_html__('Button Text', 'sanas'),
                'default' => esc_html__('Go to Home page', 'sanas'),
                'dependency' => array('sanas_enable_error_banner_button', '==', true),
            ),
        ),
    ));
    CSF::createSection($sanas_theme_options,array(
        'id'        => 'sanas_dashboard_settings',
        'title'     => esc_html__('Dashboard Settings','sanas'),
        'icon'      => 'fa fa-cog'
    ));
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_dashboard_settings',
        'title' => esc_html__('Rsvp Settings', 'sanas'),
        'icon' => 'fa fa-exclamation-triangle',
        'subtitle' => esc_html__('Add your Information for Rsvp Page', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_enable_rsvp_image',
                'type' => 'switcher',
                'title' => esc_html__('Enable Rsvp Image', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_rsvp_image',
                'type' => 'media',
                'title' => esc_html__('Rsvp Image', 'sanas'),
                'library' => 'image',
                'preview' => true,
                'preview_size' => 'full',
                'button_title' => esc_attr__('Upload Image', 'sanas'),
                'dependency' => array('sanas_enable_rsvp_image', '==', true),
            ),
        ),
    ));
  CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_dashboard_settings',
        'title' => esc_html__('Sticker Images', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'fields' => array(
         array(
          'id'    => 'sanas_sticker_gallery',
          'type'  => 'gallery',
          'title' => 'Element Gallery',
        ),           
        ),
    ));
    
    // Footer Settings
    CSF::createSection($sanas_theme_options, array(
        'id' => 'sanas_footer_settings',
        'title' => esc_html__('Footer Settings', 'sanas'),
        'icon' => 'fas fa-chevron-down',
    ));
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_footer_settings',
        'title' => esc_html__('Genral Footer Settings', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'subtitle' => esc_html__('Add your Information for Footer Section', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_footer_button_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Button', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_footer_button_text',
                'type' => 'text',
                'title' => esc_html__('Button text', 'sanas'),
                'default' => esc_html__('Vendors - Get Listed Today', 'sanas'),
                'dependency' => array('sanas_footer_button_enable', '==', true),
            ),
            array(
                'id' => 'sanas_footer_button_link',
                'type' => 'link',
                'title' => 'Button Link',
                'dependency' => array('sanas_footer_button_enable', '==', true),
            ),
        ),
    ));
    CSF::createSection($sanas_theme_options, array(
        'parent' => 'sanas_footer_settings',
        'title' => esc_html__('Bottom Footer Settings', 'sanas'),
        'icon' => 'fa fa-arrow-up',
        'subtitle' => esc_html__('Add your Information for Bottom Footer Section', 'sanas'),
        'fields' => array(
            array(
                'id' => 'sanas_bottom_footer_enable',
                'type' => 'switcher',
                'title' => esc_html__('Enable Bottom Footer', 'sanas'),
                'default' => true,
            ),
            array(
                'id' => 'sanas_bottom_footer_text_one',
                'type' => 'text',
                'title' => esc_html__('Text 1', 'sanas'),
                'default' => esc_html__('@2024', 'sanas'),
                'dependency' => array('sanas_bottom_footer_enable', '==', true),
            ),
            array(
                'id' => 'sanas_bottom_footer_text_two',
                'type' => 'text',
                'title' => esc_html__('Text 2', 'sanas'),
                'default' => esc_html__('All Rights Reserved', 'sanas'),
                'dependency' => array('sanas_bottom_footer_enable', '==', true),
            ),
            array(
                'id' => 'sanas_bottom_footer_button_one_text',
                'type' => 'text',
                'title' => esc_html__('Button One text', 'sanas'),
                'default' => esc_html__("Sana's Hub", 'sanas'),
                'dependency' => array('sanas_bottom_footer_enable', '==', true),
            ),
            array(
                'id' => 'sanas_bottom_footer_button_one_link',
                'type' => 'link',
                'title' => 'Button One Link',
                'dependency' => array('sanas_bottom_footer_enable', '==', true),
            ),
            array(
                'id' => 'sanas_bottom_footer_button_two_text',
                'type' => 'text',
                'title' => esc_html__('Button Two text', 'sanas'),
                'default' => esc_html__("Terms of Use", 'sanas'),
                'dependency' => array('sanas_bottom_footer_enable', '==', true),
            ),
            array(
                'id' => 'sanas_bottom_footer_button_two_link',
                'type' => 'link',
                'title' => 'Button Two Link',
                'dependency' => array('sanas_bottom_footer_enable', '==', true),
            ),
            array(
                'id' => 'sanas_bottom_footer_button_three_text',
                'type' => 'text',
                'title' => esc_html__('Button Three text', 'sanas'),
                'default' => esc_html__("Privacy Policy", 'sanas'),
                'dependency' => array('sanas_bottom_footer_enable', '==', true),
            ),
            array(
                'id' => 'sanas_bottom_footer_button_three_link',
                'type' => 'link',
                'title' => 'Button Three Link',
                'dependency' => array('sanas_bottom_footer_enable', '==', true),
            ),
        ),
    ));
    // Backup Settings
    CSF::createSection($sanas_theme_options, array(
        'title' => esc_html__('Backup', 'sanas'),
        'icon' => 'fas fa-shield-alt',
        'fields' => array(
            array(
                'id' => 'sanas_theme_options_backup',
                'type' => 'backup',
            ),
        ),
    ));
}