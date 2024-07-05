<div class="wrap">
    <h2><?php _e('UPME - Settings','upme')?></h2>
    <div class="updated" id="upme-settings-saved" style="display:none;">
        <p><?php _e('Settings Saved','upme');?></p>
    </div>
    
    <div class="updated" id="upme-settings-reset" style="display:none;">
        <p><?php _e('Settings Reset Completed.','upme');?></p>
    </div>
    
    <div id="upme-tab-group" class="upme-tab-group vertical_tabs">
        <ul id="upme-tabs" class="upme-tabs">
            <li class="upme-tab active" id="upme-general-settings-tab"><?php _e('General Settings','upme');?></li>
            <li class="upme-tab" id="upme-profile-settings-tab"><?php _e('User Profile Settings','upme')?></li>
            <li class="upme-tab" id="upme-system-pages-tab"><?php _e('UPME System Pages','upme')?></li>
            <li class="upme-tab" id="upme-redirect-setting-tab"><?php _e('Redirect Settings','upme')?></li>
            <li class="upme-tab" id="upme-registration-option-tab"><?php _e('Registration Options','upme')?></li>
            <li class="upme-tab" id="upme-privacy-option-tab"><?php _e('Privacy Options','upme')?></li>
            <li class="upme-tab" id="upme-misc-messages-tab" ><?php _e('Messages','upme')?></li>
        </ul>
        <div id="upme-tab-container" class="upme-tab-container" style="min-height: 220px;">
            <div class="upme-tab-content-holder">
                <div class="upme-tab-content" id="upme-general-settings-content">
                    <h3>General Settings</h3>
                    <form id="upme-general-settings-form">
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><label for="style"><?php _e('Style', 'upme'); ?></label></th>
                                    <td>
                                        <?php 
                                            $custom_styles = glob(upme_path.'styles/*.css');
                                            $styles[] =  __('None - I will use custom CSS','upme');
                                            
                                            if(is_array($custom_styles))
                                            {
                                                foreach($custom_styles as $key=>$value)
                                                {
                                                    $name = str_replace('.css','',str_replace(upme_path.'styles/','',$value));
                                                    
                                                    $styles[$name] = $name;
                                                }
                                            }
                                            
                                            echo UPME_Html::drop_down(array('name'=>'style','id'=>'style'), $styles, $this->options['style']);
                                            
                                        ?><i class="upme-icon-question-sign upme-tooltip2 option-help" original-title="<?php _e('Select Theme Style or disable CSS output to use your own custom CSS.', 'upme') ?>"></i>
                                    </td>
                                </tr>
                                
                                <tr valign="top">
                                    <th scope="row"><label for="date_format"><?php _e('Date Format', 'upme'); ?></label></th>
                                    <td>
                                    <?php 
                                        $property = array('name'=>'date_format','id' => 'date_format');
                                        $data = array(
                                                    'mm/dd/yy' => date('m/d/Y'),
                                                    'yy/mm/dd' => date('Y/m/d'),
                                                    'dd/mm/yy' => date('d/m/Y'),
                                                    'yy-mm-dd' => date('Y-m-d'),
                                                    'dd-mm-yy' => date('d-m-Y'),
                                                    'mm-dd-yy' => date('m-d-Y'),
                                                    'MM d, yy' => date('F j, Y'),
                                                    'd M, y' => date('j M, y'),
                                                    'd MM, y' => date('j F, y'),
                                                    'DD, d MM, yy' => date('l, j F, Y')
                                                );
                                        echo UPME_Html::drop_down($property, $data, $this->options['date_format']);
                                    
                                    ?><i class="upme-icon-question-sign upme-tooltip2 option-help" original-title="<?php _e('Select the date format to be used for date picker.', 'upme') ?>"></i>
                                    </td>
                                </tr>
                                
                                <?php 
                                    $this->add_plugin_setting(
                                        'checkbox',
                                        'use_cron',
                                        __('Use WP Cron', 'upme'),
                                        '1',
                                        __('If checked, UPME will use WP Cron Feature to update User Search Cache.<br />
											When usign this option, make sure <code>DISABLE_WP_CRON</code> is not set to <code>TRUE</code> in <code>wp-config.php</code>', 'upme'),
                                        __('Using WP Cron will update your search cache automatically at regular intervals.', 'upme')
                                    );
                                    
                                    $this->add_plugin_setting(
                                        'select',
                                        'hide_frontend_admin_bar',
                                        __('Admin Bar', 'upme'),
                                        array(
                                            'enabled' => __('Enabled', 'upme'),
                                            'hide_from_non_admin' => __('Hide from Non-Admin Users', 'upme'),
                                            'hide_from_all' => __('Hide from All Users', 'upme')
                                        ),
                                        __('Optionally hide the WordPress admin bar for logged in users on frontend pages.', 'upme'),
                                        __('Enabled will show the WordPress admin bar to all users. You amy select an option to hide the admin bar on frontend for non-admin users or all users.', 'upme')
                                    );
                                ?>
                                
                                <tr valign="top">
                                    <th scope="row"><label>&nbsp;</label></th>
                                    <td>
                                        <?php 
                                            echo UPME_Html::button('button', array('name'=>'save-upme-general-settings-tab', 'id'=>'save-upme-general-settings-tab', 'value'=>'Save Changes', 'class'=>'button button-primary upme-save-options'));
                                            echo '&nbsp;&nbsp;';
                                            echo UPME_Html::button('button', array('name'=>'reset-upme-general-settings-tab', 'id'=>'reset-upme-general-settings-tab', 'value'=>__('Reset Options','upme'), 'class'=>'button button-secondary upme-reset-options'));
                                        ?>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="upme-tab-content" id="upme-profile-settings-content" style="display:none;">
                    <h3><?php _e('User Profile Settings','upme');?></h3>
                    <form id="upme-profile-settings-form">
                        <table class="form-table">
                            <tbody>
                                <?php 
                                    $this->add_plugin_setting(
                                            'select',
                                            'clickable_profile',
                                            __('Display Name / User Link Options', 'upme'),
                                            array(
                                                    1 => __('Link to user profiles', 'upme'),
                                                    2 => __('Link to author archives', 'upme'),
                                                    0 => __('No link, show as static text', 'upme')),
                                            __('Enable/disable linking of Display Names on user profiles', 'upme'),
                                            __('This is where the display name on user profiles will link.', 'upme')
                                    );

                                    $this->add_plugin_setting(
                                            'select',
                                            'profile_url_type',
                                            __('Profile Permalinks', 'upme'),
                                            array(
                                                1 => __('User ID', 'upme'),
                                                2 => __('Username', 'upme')),
                                            __('Select profile link type.<br />
												Username will be written as <code>profile/username/</code><br />
												User ID will be writtne as <code>profile/1/</code>', 'upme'),
                                            __('This is the rewrite rule used to link to user profiles.', 'upme')
                                    );
                                    
                                    $this->add_plugin_setting(
                                            'checkbox',
                                            'link_author_posts_page',
                                            __('Link Post Count to Author Archive', 'upme'),
                                            '1',
                                            __('If checked, post/entries count on user profiles will link to the Author archive page.', 'upme'),
                                            __('Unchecking this option will show post count in text only, without linking to Author archive.', 'upme')
                                    );
                                    
                                    $this->add_plugin_setting(
                                            'input',
                                            'avatar_max_size',
                                            __('Maximum allowed user image size', 'upme'), array(),
                                            sprintf(__('Provide file size in megabytes, decimal values are accepted. Your server configuration supports up to <strong>%s</strong>', 'upme'), ini_get('upload_max_filesize')),
                                            __('Users will receive an error message if they try to upload files larger than the limit set here.', 'upme')
                                    );
                                    
                                    $this->add_plugin_setting(
                                            'checkbox',
                                            'show_separator_on_profile',
                                            __('Show separators on profiles', 'upme'), array(),
                                            __('<p>If checked, separators will be displayed when viewing front-end profiles.<br />
                                                    Otherwise, separators are displayed only on the registration form and when editing profiles.<br />
                                                    If you are using this option, it is recommended to also enable the next option to show empty fields on profiles.</p>', 'upme'),
                                            __('Separators may be added & edited in the UPME Custom Fields section. When using this option, it is recommended to also check the option below to show empty fields on profiles.', 'upme')
                                    );
                                    
                                    $this->add_plugin_setting(
                                            'checkbox',
                                            'show_empty_field_on_profile',
                                            __('Show empty fields on profiles', 'upme'), array(),
                                            __('<p>If checked, empty fields will be displayed when viewing front-end profiles.<br />
                                                    Otherwise, only fields populated with data are when viewing front-end profiles.</p>', 'upme'),
                                            __('Empty fields are fields where a user has not filled in any data.', 'upme')
                                    );
                                ?>
                                
                                <tr valign="top">
                                    <th scope="row"><label>&nbsp;</label></th>
                                    <td>
                                        <?php 
                                            echo UPME_Html::button('button', array('name'=>'save-upme-profile-settings-tab', 'id'=>'save-upme-profile-settings-tab', 'value'=>'Save Changes', 'class'=>'button button-primary upme-save-options'));
                                            echo '&nbsp;&nbsp;';
                                            echo UPME_Html::button('button', array('name'=>'reset-upme-profile-settings-tab', 'id'=>'reset-upme-profile-settings-tab', 'value'=>__('Reset Options','upme'), 'class'=>'button button-secondary upme-reset-options'));
                                            
                                        ?>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="upme-tab-content" id="upme-system-pages-content" style="display:none;">
                    <h3><?php _e('UPME System Pages','upme');?></h3>
                    <p><?php _e('These pages are automatically created when UPME is activated. You can leave them as they are or change to custom pages here.', 'upme'); ?></p>
                    <form id="upme-system-pages-form">
                        <table class="form-table">
                            <tbody>
                            <?php 
                                $this->add_plugin_setting(
                                        'select',
                                        'profile_page_id',
                                        __('UPME Profile Page', 'upme'),
                                        $this->get_all_pages(),
                                        __('If you wish to change default UPME Profile page, you may set it here. Make sure you have the <code>[upme]</code> shortcode on this page.', 'upme'),
                                        __('This page is where users will view their own profiles, or view other user profiles from the member directory if allowed.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'select',
                                        'login_page_id',
                                        __('UPME Login Page', 'upme'),
                                        $this->get_all_pages(),
                                        __('If you wish to change default UPME login page, you may set it here. Make sure you have the <code>[upme_login]</code> shortcode on this page.', 'upme'),
                                        __('The default front-end login page.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'select',
                                        'registration_page_id',
                                        __('UPME Registration Page', 'upme'),
                                        $this->get_all_pages(),
                                        __('If you wish to change default UPME Registration page, you may set it here. Make sure you have the <code>[upme_registration]</code> shortcode on this page.', 'upme'),
                                        __('The default front-end Registration page where new users will sign up.', 'upme')
                                );
                            ?>
                            <tr valign="top">
                                <th scope="row"><label>&nbsp;</label></th>
                                <td>
                                    <?php 
                                        echo UPME_Html::button('button', array('name'=>'save-upme-system-pages-tab', 'id'=>'save-upme-system-pages-tab', 'value'=>'Save Changes', 'class'=>'button button-primary upme-save-options'));
                                        echo '&nbsp;&nbsp;';
                                        echo UPME_Html::button('button', array('name'=>'reset-upme-system-pages-tab', 'id'=>'reset-upme-system-pages-tab', 'value'=>__('Reset Options','upme'), 'class'=>'button button-secondary upme-reset-options'));
                                    ?>
                                </td>
                            </tr>
                            
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="upme-tab-content" id="upme-redirect-setting-content" style="display:none;">
                    <h3><?php _e('Redirect Settings','upme');?></h3>
                    <form id="upme-redirect-setting-form">
                        <table class="form-table">
                            <?php 
                                $this->add_plugin_setting(
                                        'checkbox',
                                        'redirect_backend_profile',
                                        __('Redirect Backend Profiles', 'upme'),
                                        '1',
                                        __('If checked, non-admin users who try to access backend WP profiles will be redirected to UPME Profile Page specified above.', 'upme'),
                                        __('Checking this option will send all users to the front-end UPME Profile Page if they try to access the default backend profile page in wp-admin. The page can be selected in the UPME System Pages settings.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'checkbox',
                                        'redirect_backend_login',
                                        __('Redirect Backend Login', 'upme'),
                                        '1',
                                        __('If checked, non-admin users who try to access backend login form will be redirected to the front end UPME Login Page specified above.', 'upme'),
                                        __('Checking this option will send all users to the front-end UPME Login Page if they try to access the default backend login form. The page can be selected in the UPME System Pages settings.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'checkbox',
                                        'redirect_backend_registration',
                                        __('Redirect Backend Registrations', 'upme'),
                                        '1',
                                        __('If checked, non-admin users who try to access backend registration form will be redirected to the front end UPME Registration Page specified above.', 'upme'),
                                        __('Checking this option will send all users to the front-end UPME Registration Page if they try to access the default backend registraiton form. The page can be selected in the UPME System Pages settings.', 'upme')
                                );
                                
                                
                                $login_page_options = $this->get_all_pages();
                                $login_page_options['0'] = __('Default', 'upme');
                                
                                $this->add_plugin_setting(
                                        'select',
                                        'login_redirect_page_id',
                                        __('Redirect After Login', 'upme'),
                                        $login_page_options,
                                        __('Users will be redirected to the page set here after successfully logging in. <br /> You may over-ride this setting for a specific login form by using the shortcode <code>[upme_login redirect_to="url_here"]</code>', 'upme'),
                                        __('Setting this option to Default will automatically use any redirect specified in the URL, and will not prevent redirect_to set in shortcode option from working. If no redirect is found in the URL and redirect_to option is not set in shortcode option, the login page will simply be reloaded to welcome the logged in user.', 'upme')
                                );
                                
                                $register_page_options = $this->get_all_pages();
                                $register_page_options['0'] = __('Default', 'upme');
                                
                                $this->add_plugin_setting(
                                        'select',
                                        'register_redirect_page_id',
                                        __('Redirect After Registration', 'upme'),
                                        $register_page_options,
                                        __('New users will be redirected to the page set here after successfully registering using the UPME registration form. <br /> You may over-ride this setting for a specific registration form by using the shortcode <code>[upme_registration redirect_to="url_here"]</code>', 'upme'),
                                        __('Setting this option to Default will show the Register Success message instead of redirecting to a custom page.', 'upme')
                                );
                            ?>
                            
                            <tr valign="top">
                                <th scope="row"><label>&nbsp;</label></th>
                                <td>
                                    <?php 
                                        echo UPME_Html::button('button', array('name'=>'save-upme-redirect-setting-tab', 'id'=>'save-upme-redirect-setting-tab', 'value'=>'Save Changes', 'class'=>'button button-primary upme-save-options'));
                                        echo '&nbsp;&nbsp;';
                                        echo UPME_Html::button('button', array('name'=>'reset-upme-redirect-setting-tab', 'id'=>'reset-upme-redirect-setting-tab', 'value'=>__('Reset Options','upme'), 'class'=>'button button-secondary upme-reset-options'));
                                    ?>
                                </td>
                            </tr>
                            
                        </table>
                    </form>
                </div>
                <div class="upme-tab-content" id="upme-registration-option-content" style="display:none;">
                    <h3><?php _e('Registration Options','upme');?></h3>
                    <form id="upme-registration-option-form">
                        <table class="form-table">
                            <?php 
                                $this->add_plugin_setting(
                                        'select',
                                        'set_password',
                                        __('User Selected Passwords', 'upme'),
                                        array(
                                                1 => __('Enabled, allow users to set password', 'upme'),
                                                0 => __('Disabled, email a random password to users', 'upme')),
                                        __('Enable or disable setting a user selected password at registration', 'upme'),
                                        __('If enabled, users can choose their own password at registration. If disabled, WordPress will email users a random password when they register.', 'upme')
                                );
                                
                                // Automatic Login Selection Start
                                $this->add_plugin_setting(
                                        'select',
                                        'automatic_login',
                                        __('Automatic Login After Registration', 'upme'),
                                        array(
                                                '1' => __('Enabled, log users in automatically after registration', 'upme'),
                                                '0' => __('Disabled, users must login normally after registration', 'upme')
                                        ),
                                        __('Enable or disable automatic login after registration.', 'upme'),
                                        __('If enabled, users will be logged automatically after registration and redirected to the page defined in Redirect After Registration setting. If disabled, users must login normally after registration.', 'upme')
                                );
                                // Automatic Login Selection End
                                // Captcha Plugin Selection Start
                                $this->add_plugin_setting(
                                        'select',
                                        'captcha_plugin',
                                        __('Captcha Plugin', 'upme'),
                                        array(
                                                'none' => __('None', 'upme'),
                                                'funcaptcha' => __('FunCaptcha', 'upme'),
                                                'recaptcha' => __('reCaptcha', 'upme')
                                        ),
                                        __('Select which captcha plugin you want to use on the registration form. Funcaptcha requires the Funcaptcha plugin, however reCaptcha is built into UPME and requires no additional plugin to be installed. <br /> You can enable or disable captcha with shortcode options: <code>[upme_registration captcha=yes]</code> or <code>[upme_registration captcha=no]</code>.', 'upme'),
                                        __('If you are using a captcha that requires a plugin, you must install and activate the selected captcha plugin. Some captcha plugins require you to register a free account with them, including FunCaptcha', 'upme')
                                );
        
                                // Captcha Plugin Selection End
                                $this->add_plugin_setting(
                                        'input',
                                        'captcha_label',
                                        __('CAPTCHA Field Label', 'upme'), array(),
                                        __('Enter text which you want to show in form in front of CAPTCHA.', 'upme'),
                                        __('Enter text which you want to show in form in front of CAPTCHA.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'input',
                                        'recaptcha_public_key',
                                        __('reCaptcha Public Key', 'upme'), array(),
                                        __('Enter your reCaptcha Public Key. You can sign up for a free reCaptcha account <a href="http://www.google.com/recaptcha" title="Get a reCaptcha Key" target="_blank">here</a>.', 'upme'),
                                        __('Your reCaptcha kays are required to use reCaptcha. You can register your site for a free key on the Google reCaptcha page.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'input',
                                        'recaptcha_private_key',
                                        __('reCaptcha Private Key', 'upme'), array(),
                                        __('Enter your reCaptcha Private Key.', 'upme'),
                                        __('Your reCaptcha kays are required to use reCaptcha. You can register your site for a free key on the Google reCaptcha page.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'textarea',
                                        'msg_register_success',
                                        __('Register success message', 'upme'),
                                        null,
                                        __('Show a text message when users complete the registration process.', 'upme'),
                                        __('This message will be shown to users after registration is complted.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'textarea',
                                        'html_register_success_after',
                                        __('Text/HTML below the Register Success message.', 'upme'),
                                        null,
                                        __('Show a text/HTML content under success message when users complete the registration process.', 'upme'),
                                        __('This message will be shown to users under the success messsage after registration is completed.', 'upme')
                                );
                            ?>
                            
                            <tr valign="top">
                                <th scope="row"><label>&nbsp;</label></th>
                                <td>
                                    <?php 
                                        echo UPME_Html::button('button', array('name'=>'save-upme-registration-option-tab', 'id'=>'save-upme-registration-option-tab', 'value'=>'Save Changes', 'class'=>'button button-primary upme-save-options'));
                                        echo '&nbsp;&nbsp;';
                                        echo UPME_Html::button('button', array('name'=>'reset-upme-registration-option-tab', 'id'=>'reset-upme-registration-option-tab', 'value'=>__('Reset Options','upme'), 'class'=>'button button-secondary upme-reset-options'));
                                    ?>
                                </td>
                            </tr>
                            
                        </table>
                    </form>
                </div>
                <div class="upme-tab-content" id="upme-privacy-option-content" style="display:none;">
                    <h3><?php _e('Privacy Options','upme');?></h3>
                    <form id="upme-privacy-option-form">
                        <table class="form-table">
                            <?php 
                                $this->add_plugin_setting(
                                        'select',
                                        'users_can_view',
                                        __('Logged-in user viewing of other profiles', 'upme'),
                                        array(
                                                1 => __('Enabled, logged-in users may view other user profiles', 'upme'),
                                                0 => __('Disabled, users may only view their own profile', 'upme')),
                                        __('Enable or disable logged-in user viewing of other user profiles. Admin users can always view all profiles.', 'upme'),
                                        __('If enabled, logged-in users are allowed to view other user profiles. If disabled, logged-in users may only view theor own profile.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'select',
                                        'guests_can_view',
                                        __('Guests viewing of profiles', 'upme'),
                                        array(
                                                1 => __('Enabled, make profiles publicly visible', 'upme'),
                                                0 => __('Disabled, users must login to view profiles', 'upme')),
                                        __('Enable or disable guest and non-logged in user viewing of profiles.', 'upme'),
                                        __('If enabled, profiles will be publicly visible to non-logged in users. If disabled, guests must log in to view profiles.', 'upme')
                                );
                            ?>
                            
                            <tr valign="top">
                                <th scope="row"><label>&nbsp;</label></th>
                                <td>
                                    <?php 
                                        echo UPME_Html::button('button', array('name'=>'save-upme-privacy-option-tab', 'id'=>'save-upme-privacy-option-tab', 'value'=>'Save Changes', 'class'=>'button button-primary upme-save-options'));
                                        echo '&nbsp;&nbsp;';
                                        echo UPME_Html::button('button', array('name'=>'reset-upme-privacy-option-tab', 'id'=>'reset-upme-privacy-option-tab', 'value'=>__('Reset Options','upme'), 'class'=>'button button-secondary upme-reset-options'));
                                    ?>
                                </td>
                            </tr>
                            
                            
                        </table>
                    </form>
                </div>
                <div class="upme-tab-content" id="upme-misc-messages-content" style="display:none;">
                    <h3><?php _e('Messages for Insuficient Permissions','upme');?></h3>
                    <form id="upme-misc-messages-form">
                        <table class="form-table">
                            <?php 
                                $this->add_plugin_setting(
                                        'textarea',
                                        'html_login_to_view',
                                        __('Guests cannot view profiles', 'upme'),
                                        null,
                                        __('Show a text/HTML message when guests try to view profiles if they are not allowed, asking them to login or register to view the profile.', 'upme'),
                                        __('This message will eb shown to guests who try to view profiles if it is not allowed in the above settings.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'textarea',
                                        'html_user_login_message',
                                        __('User must log-in to view/edit his profile', 'upme'),
                                        null,
                                        __('Show a text/HTML message asking the user to login to view or edit his own profile. Leave blank to show nothing.', 'upme'),
                                        __('This message is shown to users who try to view/edit their own profile but are not logged in.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'textarea',
                                        'html_private_content',
                                        __('User must log-in to view private content', 'upme'),
                                        null,
                                        __('Show a text/HTML message to guests and non-logged in users who try to view private member-only content. Leave blank to show nothing.', 'upme'),
                                        __('This message is shown to guests and non-logged in users who try to view private member-only content.', 'upme')
                                );
                                
                                $this->add_plugin_setting(
                                        'textarea',
                                        'html_registration_disabled',
                                        __('Registration Closed Message', 'upme'),
                                        null,
                                        __('Show a text/HTML message in place of the registration form when registration is closed. Registeration can be opened or closed from the WordPress general settings using the checkbox <code>Anyone can register</code>.', 'upme'),
                                        __('This message is shown to users who try to view the UPME registration form while you have registrations disabled.', 'upme')
                                );
                            ?>
                            <tr valign="top">
                                <th scope="row"><label>&nbsp;</label></th>
                                <td>
                                    <?php 
                                        echo UPME_Html::button('button', array('name'=>'save-upme-misc-messages-tab', 'id'=>'save-upme-misc-messages-tab', 'value'=>'Save Changes', 'class'=>'button button-primary upme-save-options'));
                                        echo '&nbsp;&nbsp;';
                                        echo UPME_Html::button('button', array('name'=>'reset-upme-misc-messages-tab', 'id'=>'reset-upme-misc-messages-tab', 'value'=>__('Reset Options','upme'), 'class'=>'button button-secondary upme-reset-options'));
                                        
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
