function rating(rate, message) {
    return {
        rate: rate,
        messageKey: message
    };
}

function uncapitalize(str) {
    return str.substring(0, 1).toLowerCase() + str.substring(1);
}

function show_meter(obj, key, message)
{
    
    var obj_id = jQuery(obj).attr("id");
    var meter = jQuery("#"+obj_id).closest("form").find(".password-meter");
    meter.find(".password-meter-bar").removeClass().addClass("password-meter-bar").addClass("password-meter-" + key);
    meter.find(".password-meter-message")
    .removeClass()
    .addClass("password-meter-message")
    .addClass("password-meter-message-" + key)
    .text(message);
	
    jQuery("#"+obj_id).closest("form").find('#password-meter-message').attr('rel',key);
	
}

jQuery(document).ready(function() {
	
    var err_messages={
        "similar-to-username"   : Validate.ErrMsg.similartousername,
        "mismatch"              : Validate.ErrMsg.mismatch,
        "too-short"             : Validate.ErrMsg.tooshort,
        "very-weak"             : Validate.ErrMsg.veryweak,
        "weak"                  : Validate.ErrMsg.weak,
        "username-required"     : Validate.ErrMsg.usernamerequired,
        "email-required"        : Validate.ErrMsg.emailrequired,
        "valid-email-required"  : Validate.ErrMsg.validemailrequired,
        "username-exists"       : Validate.ErrMsg.usernameexists,
        "email-exists"          : Validate.ErrMsg.emailexists
	        
    }
	
    var LOWER = /[a-z]/,
    UPPER = /[A-Z]/,
    DIGIT = /[0-9]/,
    DIGITS = /[0-9].*[0-9]/,
    SPECIAL = /[^a-zA-Z0-9]/,
    SAME = /^(.)\1+$/;
	
    var messages={
        "similar-to-username" : Validate.MeterMsg.similartousername,
        "mismatch" : Validate.MeterMsg.mismatch,
        "too-short" : Validate.MeterMsg.tooshort,
        "very-weak" : Validate.MeterMsg.veryweak,
        "weak" : Validate.MeterMsg.weak,
        "good" : Validate.MeterMsg.good,
        "strong" : Validate.MeterMsg.strong
    }
	
	
    jQuery('#upme-registration-form').submit(function(e){
        //e.preventDefault();

        // Remove validation check images on username and email
        jQuery("#upme-reg-login-img").remove();
        jQuery("#upme-reg-email-img").remove();
        jQuery("#upme-reg-login-msg").remove();
        jQuery("#upme-reg-email-msg").remove();

        // Disable submit button to prevent duplicate submissions
        jQuery('#upme-register').attr('disabled',true);
		
        if(jQuery('#upme-registration-form').data('success') == 'true')
        {
			
        }
        else
        {
            e.preventDefault();
            var err = false;
            var err_msg = '';
            var email_reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
            jQuery('#upme-registration-form').find('.required').each(function(){
				
                if(jQuery(this).attr('type') == 'radio' || jQuery(this).attr('type') == 'checkbox')
                {
                    // Cleaning the name of the element as in case of checkbox [] will create problem.
                    var clean_name = jQuery(this).attr('name').replace(']','').replace('[','');
					
                    var count = 0;

                    if(jQuery("input[name^="+clean_name+"]:checked").size() == 0)
                    {
                        err = true;
                        err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ jQuery(this).attr('title') +' is required.</span>';
                        jQuery(this).addClass('error');
                    }
                    else if(jQuery(this).hasClass('error'))
                    {
                        jQuery(this).removeClass('error');
                    }
                }
                else
                {
                    if(jQuery(this).val() == '')
                    {
                        err = true;
                        err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ jQuery(this).attr('title') +' is required.</span>';
                        jQuery(this).addClass('error');
                    }
                    else if(jQuery(this).hasClass('error'))
                    {
                        jQuery(this).removeClass('error');
                    }
                }
				
            });
			
            if(!jQuery('#reg_user_email').hasClass('error'))
            {
                if(!email_reg.test(jQuery('#reg_user_email').val()))
                {
                    err = true;
                    err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ err_messages['valid-email-required']+'</span>';
                    jQuery('#reg_user_email').addClass('error');
                }
                else
                {
                    if(jQuery('#reg_user_email').hasClass('error'))
                        jQuery('#reg_user_email').removeClass('error');
                }
            }
			
            // Check for Password
			
			
			
            if(jQuery('#reg_user_pass').length > 0)
            {
				
                if(!jQuery('#reg_user_pass').hasClass('error'))
                {
                    var attr = jQuery('#password-meter-message').attr('rel');
					
                    if(typeof(attr) == 'undefined')
                    {
                        jQuery('#reg_user_pass').trigger('keyup');
                        var attr = jQuery('#password-meter-message').attr('rel');
                    }
					
                    if(('good' == attr || 'strong' == attr) && jQuery('#reg_user_pass_confirm').val() == jQuery('#reg_user_pass').val())
                    {
                        if(jQuery('#reg_user_pass_confirm').hasClass('error'))
                            jQuery('#reg_user_pass_confirm').removeClass('error');
						
                        if(jQuery('#reg_user_pass').hasClass('error'))
                            jQuery('#reg_user_pass').removeClass('error');
                    }
                    else
                    {
                        var err_key =jQuery('#password-meter-message').attr('rel');
						
                        if(err_key == 'good' || err_key == 'strong')
                        {
                            err = true;
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ err_messages['mismatch']+'</span>';
                        }
                        else
                        {
                            err = true;
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ err_messages[err_key]+'</span>';
                        }
						
                        jQuery('#reg_user_pass').addClass('error');
                        jQuery('#reg_user_pass_confirm').addClass('error');
                    }
                }
            }
			
            if(err == true && err_msg!='')
            {
                jQuery('#pass_err_holder').css('display','block');
                jQuery('#pass_err_block').html(err_msg);

                // Redirect to top of the registration page to view errors without scrolling
                var registrationCordinates = jQuery("#upme-registration").position();
                jQuery("html, body").animate({
                    scrollTop: registrationCordinates.top
                }, 2000);

                // Enable submit button on errors
                jQuery('#upme-register').attr('disabled',false);
                                
            }
            else
            {
                jQuery.post(
                    Validate.ajaxurl,
                    {
                        'action': 'check_email_username',
                        'user_name':   jQuery('#reg_user_login').val(),
                        'email_id': jQuery('#reg_user_email').val()
                    },
                    function(response){
					    	
                        if(response.msg == 'success')
                        {
                            jQuery('#upme-registration-form').data('success','true');
                            jQuery('#upme-registration-form').submit();
                        }
                        else if(response.msg == 'both_error')
                        {
                            jQuery('#reg_user_login').addClass('error');
                            jQuery('#reg_user_email').addClass('error');
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ err_messages['username-exists']+'</span>';
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ err_messages['email-exists']+'</span>';
                        }
                        else if(response.msg == 'user_name_error')
                        {
                            if(jQuery('#reg_user_login').hasClass('error'))
                                jQuery('#reg_user_login').removeClass('error');
					    		
                            jQuery('#reg_user_login').addClass('error');
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ err_messages['username-exists']+'</span>';
                        }
                        else if(response.msg == 'email_error')
                        {
                            if(jQuery('#reg_user_email').hasClass('error'))
                                jQuery('#reg_user_email').removeClass('error');
					    		
                            jQuery('#reg_user_email').addClass('error');
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i><strong>'+Validate.Err+':</strong> '+ err_messages['email-exists']+'</span>';
                        }
					    	
                        if(response.msg != 'success')
                        {
                            jQuery('#pass_err_holder').css('display','block');
                            jQuery('#pass_err_block').html(err_msg);
                            // Enable submit button on errors
                            jQuery('#upme-register').attr('disabled',false);

                            // Redirect to top of the registration page to view errors without scrolling
                            var registrationCordinates = jQuery("#upme-registration").position();
                            jQuery("html, body").animate({
                                scrollTop: registrationCordinates.top
                            }, 2000);
                        }
					    	
					    	
                    },"json");
					
            }
			
        }
    });
	
	
    if(jQuery('#reg_user_pass').length > 0)
    {
        jQuery('#reg_user_pass').keyup(function(){
            var key = 'weak';
            var password = jQuery('#reg_user_pass').val();
			
            var lower = LOWER.test(password),
            upper = UPPER.test(uncapitalize(password)),
            digit = DIGIT.test(password),
            digits = DIGITS.test(password),
            special = SPECIAL.test(password);
            var username = jQuery('#reg_user_login').val();
			
            if (!password || password.length < 7)
                key = 'too-short';
            else if (username && password.toLowerCase().match(username.toLowerCase()))
                key = 'similar-to-username';
            else if(SAME.test(password))
                key = 'very-weak';
            else if (lower && upper && digit || lower && digits || upper && digits || special)
                key = 'strong';
            else if (lower && upper || lower && digit || upper && digit)
                key = 'good';
            else
                key = 'weak';
			
            show_meter(jQuery(this),key, messages[key]);

        });
		
        jQuery('#reg_user_pass').focus(function(){
            jQuery(this).trigger('keyup');
        });
		
        jQuery('#reg_user_pass').blur(function(){
            jQuery(this).trigger('keyup');
        });
    }
	
	
    if(jQuery('#reg_user_pass_confirm').length > 0)
    {
        jQuery('#reg_user_pass_confirm').keyup(function(){
            var password = jQuery('#reg_user_pass').val();
			
            if(password != jQuery(this).val())
                show_meter(jQuery(this),'mismatch', messages['mismatch']);
            else
                jQuery('#reg_user_pass').trigger('keyup');
        });
		
        jQuery('#reg_user_pass_confirm').blur(function(){
            jQuery(this).trigger('keyup');
        });
		
        jQuery('#reg_user_pass_confirm').focus(function(){
            jQuery(this).trigger('keyup');
        });
    }


    

    // Validate profile edit form
    jQuery('.upme-edit-profile-form').submit(function(e){

        var edit_form = jQuery(this);
        var user_id = jQuery(edit_form).find('#upme-edit-usr-id').val();

        jQuery(this).removeClass('error');

        if(jQuery(edit_form).data('success') == 'true')
        {
            
        }
        else
        {
            e.preventDefault();
            var err = false;
            var err_msg = '';
            var email_reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var filtered_names = [];
			
            jQuery(edit_form).find('.required').each(function(){
				
                if(jQuery(this).attr('type') == 'radio' || jQuery(this).attr('type') == 'checkbox')
                {
                    // Cleaning the name of the element as in case of checkbox [] will create problem.
                    var clean_name = jQuery(this).attr('name').replace(']','').replace('[','');
					
                    var count = 0;
					

                    if(jQuery("input[name^="+clean_name+"]:checked").size() == 0)
                    {
                        err = true;
                        if(jQuery.inArray(clean_name,filtered_names) == '-1'){
                            err_msg+='<span class="upme-error upme-error-block" upme-data-name="'+clean_name+'" ><i class="upme-icon-remove"></i>'+ jQuery(this).attr('title') +' is required.</span>';
                            jQuery(this).addClass('error');
                        }
                        filtered_names.push(clean_name);
						
                    }
                    else if(jQuery(this).hasClass('error'))
                    {
                        jQuery(this).removeClass('error');
                    }
                }
                else if(jQuery(this).is('select')){

                    if(jQuery(this).val() == '')
                    {
                        err = true;
                        err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i>'+ jQuery(this).attr('title') +' is required.</span>';
                        jQuery(this).addClass('error');

                        
                    }
                    else if(jQuery(this).hasClass('error'))
                    {
                        jQuery(this).removeClass('error');
                    }

                }
                else
                {
                    if(jQuery(this).val() == '')
                    {
                        err = true;
                        err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i>'+ jQuery(this).attr('title') +' is required.</span>';
                        jQuery(this).addClass('error');
                    }
                    else if(jQuery(this).hasClass('error'))
                    {
                        jQuery(this).removeClass('error');
                    }
                }
				
            });

            //var user_id = jQuery('#upme-edit-profile-form').find('input[type="submit"]').attr("name").replace("upme-submit-", "");
            var email_field_id = '#user_email-'+ user_id;
						
            if(!jQuery(email_field_id).hasClass('error') && jQuery(email_field_id).length > 0 )
            {
                if(!email_reg.test(jQuery(email_field_id).val()))
                {
                    err = true;
                    
                    err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i>'+ err_messages['valid-email-required']+'</span>';
                    jQuery(email_field_id).addClass('error');
                }
                else
                {
                    if(jQuery(email_field_id).hasClass('error'))
                        jQuery(email_field_id).removeClass('error');
                }
            }


            var password_field_id = '#user_pass-'+ user_id;
            var password_confirm_field_id = '#user_pass_confirm-'+ user_id;

            if(jQuery(password_field_id).length > 0 && ("" != jQuery(password_field_id).val() || "" != jQuery(password_confirm_field_id).val() ))
            {
				
                if(!jQuery(password_field_id).hasClass('error'))
                {
                    var attr = jQuery(edit_form).find('#password-meter-message').attr('rel');
				
                    if(typeof(attr) == 'undefined')
                    {
                        jQuery(password_field_id).trigger('keyup');
                        var attr = jQuery(edit_form).find('#password-meter-message').attr('rel');
                   
                    }
					
                    if(('good' == attr || 'strong' == attr) && jQuery(password_confirm_field_id).val() == jQuery(password_field_id).val())
                    {
                        if(jQuery(password_confirm_field_id).hasClass('error'))
                            jQuery(password_confirm_field_id).removeClass('error');
						
                        if(jQuery(password_field_id).hasClass('error'))
                            jQuery(password_field_id).removeClass('error');
                    }
                    else
                    {
                
                        var err_key =jQuery(edit_form).find('#password-meter-message').attr('rel');
						
                        if(err_key == 'good' || err_key == 'strong')
                        {
                            err = true;
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i>'+ err_messages['mismatch']+'</span>';
                        }
                        else
                        {
                            err = true;
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i>'+ err_messages[err_key]+'</span>';
                        }
						
                        jQuery(password_field_id).addClass('error');
                        jQuery(password_confirm_field_id).addClass('error');
                    }
                }
            }
        
			
            // Check for Password
			
			
            if(err == true && err_msg!='')
            {


                jQuery(edit_form).prev('#upme-edit-form-err-holder').css('display','block');
                jQuery(edit_form).prev('#upme-edit-form-err-holder').html(err_msg);

                // Redirect to top of the registration page to view errors without scrolling
                var registrationCordinates = jQuery(edit_form).position();
                jQuery("html, body").animate({
                    scrollTop: registrationCordinates.top
                }, 2000);

                return false;
                                
            }else{

                jQuery.post(
                    Validate.ajaxurl,
                    {
                        'action': 'upme_check_edit_email',
                        'email_id': jQuery(email_field_id).val(),
                        'user_id' : user_id
                    },
                    function(response){
					    	
                        if(response.msg == 'success')
                        {
                          
                            jQuery(edit_form).data('success','true');
                            jQuery(edit_form).submit();
                        //return true;
                        }
                        else if(response.msg == 'email_error')
                        {
                            if(jQuery(email_field_id).hasClass('error'))
                                jQuery(email_field_id).removeClass('error');
					    		
                            jQuery(email_field_id).addClass('error');
                            err_msg+='<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i>'+ err_messages['email-exists']+'</span>';
                        }
					    	
                        if(response.msg != 'success')
                        {
                            jQuery(edit_form).prev('#upme-edit-form-err-holder').css('display','block');
                            jQuery(edit_form).prev('#upme-edit-form-err-holder').html(err_msg);
                                                               

                            // Redirect to top of the registration page to view errors without scrolling
                            var registrationCordinates = jQuery(edit_form).position();
                            jQuery("html, body").animate({
                                scrollTop: registrationCordinates.top
                            }, 2000);
                        }
					    	
					    	
                    },"json");


            }
			
        }
    });

    var password_field_class = '.upme-edit-user_pass';
    var password_confirm_field_class = '.upme-edit-user_pass_confirm';

    if(jQuery(password_field_class).length > 0)
    {
        
        jQuery(password_field_class).keyup(function(){

            var password_field = jQuery(this);
            
            var key = 'weak';
            var password = jQuery(password_field).val();
			
            var lower = LOWER.test(password),
            upper = UPPER.test(uncapitalize(password)),
            digit = DIGIT.test(password),
            digits = DIGITS.test(password),
            special = SPECIAL.test(password);
            
			
            if (!password || password.length < 7)
                key = 'too-short';
            else if(SAME.test(password))
                key = 'very-weak';
            else if (lower && upper && digit || lower && digits || upper && digits || special)
                key = 'strong';
            else if (lower && upper || lower && digit || upper && digit)
                key = 'good';
            else
                key = 'weak';
			
            show_meter(jQuery(this),key, messages[key]);

        });
		
        jQuery(password_field_class).focus(function(){
            jQuery(this).trigger('keyup');
        });
		
        jQuery(password_field_class).blur(function(){
            jQuery(this).trigger('keyup');
        });
    }

    if(jQuery(password_confirm_field_class).length > 0)
    {
        jQuery(password_confirm_field_class).keyup(function(){
            var confirm_field_id  = jQuery(this).attr("id");
            
            var password_field = jQuery("#"+confirm_field_id).closest('form').find('.upme-edit-user_pass');
            var password = jQuery(password_field).val();
			
            if(password != jQuery(this).val())
                show_meter(jQuery(this),'mismatch', messages['mismatch']);
            else
                jQuery(password_field).trigger('keyup');
        });
		
        jQuery(password_confirm_field_class).blur(function(){
            jQuery(this).trigger('keyup');
        });
		
        jQuery(password_confirm_field_class).focus(function(){
            jQuery(this).trigger('keyup');
        });
    }

    // Clear error messages on focus
    jQuery('.upme-edit-profile-form').find('.required').focus(function(){

        jQuery(this).removeClass('error');
    });

    jQuery(password_field_class).focus(function(){
        jQuery(this).removeClass('error');
    });

    jQuery(password_confirm_field_class).focus(function(){
        jQuery(this).removeClass('error');
    });

    /* Edit Profile Form: Validate username on focus out */
    var email_class = '.upme-edit-user_email';

    jQuery(email_class).focus(function(){
        jQuery(this).removeClass('error');
    });

    jQuery(email_class).blur(function(){

        var user_id = jQuery(this).closest('form').find('#upme-edit-usr-id').val();

        var newUserEmail = jQuery(this).val();
        var email = jQuery(this);
        var email_reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var message;

        jQuery(email).removeClass('error');

        jQuery("#upme-reg-email-img").remove();
        jQuery("#upme-reg-email-msg").remove();

        if('' == newUserEmail){
            message = Validate.ErrMsg.emailempty;
            jQuery(email).addClass('error');
            jQuery(email).after('<div id="upme-reg-email-msg" class="upme-input-text-inline-error" ><i id="upme-reg-email-img" original-title="Invalid" class="upme-icon-remove upme-input-text-font-cancel" ></i>' + message + '</div>');
               
        }else if(!email_reg.test(newUserEmail)){
            message = Validate.ErrMsg.emailinvalid;
            jQuery(email).addClass('error');
            jQuery(email).after('<div id="upme-reg-email-msg" class="upme-input-text-inline-error" ><i id="upme-reg-email-img" original-title="Invalid" class="upme-icon-remove upme-input-text-font-cancel" ></i>' + message + '</div>');
               
        }else{
            

        jQuery.post(
            UPMECustom.AdminAjax,
            {
                'action': 'upme_validate_edit_profile_email',
                'user_email':   newUserEmail,
                'user_id' : user_id
            },
            function(response){

                
                switch(response.msg){
                    case 'RegExistEmail':
                        message = Validate.ErrMsg.emailexists; 
                        break;
                    case 'RegValidEmail':
                        message = Validate.ErrMsg.emailvalid; 
                        break;
                    case 'RegInvalidEmail':
                        message = Validate.ErrMsg.emailinvalid;
                        break;
                    case 'RegEmptyEmail':
                        message = Validate.ErrMsg.emailempty;
                        break;
                }

                if(response.status){
                    jQuery(email).addClass('error');
                    jQuery(email).after('<div id="upme-reg-email-msg" class="upme-input-text-inline-error" ><i id="upme-reg-email-img" original-title="Invalid" class="upme-icon-remove upme-input-text-font-cancel" ></i>' + message + '</div>');
                }else{
                    jQuery(email).after('<div id="upme-reg-email-msg" class="upme-input-text-inline-success" ><i id="upme-reg-email-img" original-title="Valid" class="upme-icon-ok upme-input-text-font-accept" ></i>' + message + '</div>');
                }

            },"json");
        }

        
    });
	
	
	
});