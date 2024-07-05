jQuery(document).ready(function($) {

    /* Nice file upload */
    // Calling hidden and native element's action
    $('.upme-fileupload').click(function(){
        if($('#file_'+$(this).attr('id')).length > 0)
            $('#file_'+$(this).attr('id')).click();
    });

    // replace selected image path in custom div
    $('.upme-fileupload-field').change(function(){
        if($('#'+$(this).attr('name')).length > 0)
            $('#'+$(this).attr('name')).text($(this).val());
		
    });

    /* Tooltips */
    if($('.upme-tooltip').length > 0)
    {
        $('.upme-tooltip').tipsy({
            trigger: 'hover',
            offset: 4
        });
    }
	

    if($('.upme-go-to-page').length > 0)
    {
        $('.upme-go-to-page').on('change', function(){
        	if($(this).val() != 0)
        	{
            	jQuery('#userspage').val($(this).val());
            	jQuery( "#upme_search_form" ).submit();
        	}
        });
    }
	
	
    /* Check/uncheck */
    $('.upme-hide-from-public').click(function(e){
        e.preventDefault();
        if ($(this).find('i').hasClass('upme-icon-check-empty')) {
            $(this).find('i').addClass('upme-icon-check').removeClass('upme-icon-check-empty');
            $(this).find('input[type=hidden]').val(1);
        } else {
            $(this).find('i').addClass('upme-icon-check-empty').removeClass('upme-icon-check');
            $(this).find('input[type=hidden]').val(0);
        }
    });

    $('.upme-rememberme').click(function(e){
        e.preventDefault();
        if ($(this).find('i').hasClass('upme-icon-check-empty')) {
            $(this).find('i').addClass('upme-icon-check').removeClass('upme-icon-check-empty');
            $(this).find('input[type=hidden]').val(1);
        } else {
            $(this).find('i').addClass('upme-icon-check-empty').removeClass('upme-icon-check');
            $(this).find('input[type=hidden]').val(0);
        }
    });
	
		
    /* Toggle edit inline */
    $('.upme-field-edit a.upme-fire-editor').click(function(e){
        e.preventDefault();

        // Hide success message on edit or profile button click
        $('.upme-success').remove();

        this_form = $(this).parent().parent().parent().parent().parent();
        if ($(this_form).find('.upme-edit').is(':hidden')) {
            if ($(this_form).find('.upme-view').length > 0) {
                $(this_form).find('.upme-view').slideUp(function() {
                    $(this_form).find('.upme-edit').slideDown();
                    $(this_form).find('.upme-field-edit a.upme-fire-editor').html(UPMECustom.ViewProfile);
                });
            } else {
                $(this_form).find('.upme-main').show();
                $(this_form).find('.upme-edit').slideDown();
                $(this_form).find('.upme-field-edit a.upme-fire-editor').html(UPMECustom.ViewProfile);
            }
        } else {
            $(this_form).find('.upme-edit').slideUp(function() {
                if ($(this_form).find('.upme-main').hasClass('upme-main-compact')) {
                    $(this_form).find('.upme-main').hide();
                }
                $(this_form).find('.upme-view').slideDown();
                $(this_form).find('.upme-field-edit a.upme-fire-editor').html(UPMECustom.EditProfile);
            });
        }


        // Hide all the edit form error messages when switchin between edit and view
        $('#upme-edit-form-err-holder').html('').hide();
        $('#upme-edit-profile-form .error').removeClass('error');
    });
	
    /* Registration Form: Blur on email */
    jQuery('.upme-registration').find('#reg_user_email').change(function(){
        var new_user_email = $(this).val();
        jQuery('.upme-registration .upme-pic').load(UPMECustom.UPMEUrl+'ajax/upme-get-avatar.php?email=' + new_user_email );
    });
	
    /* Change display name as User type in */
    jQuery('.upme-registration').find('#reg_user_login').bind('change keydown keyup',function(){
        jQuery('.upme-registration .upme-name .upme-field-name').html( jQuery('#reg_user_login').val() );
    });


    // New Password request JS Code

    jQuery('[id^=upme-forgot-pass-]').on('click', function(){

        var counter = jQuery(this).attr('id').replace('upme-forgot-pass-','');
        
        jQuery('#upme-login-form-'+counter).css('display','none');
        jQuery('#upme-forgot-pass-holder-'+counter).css('display','block');
        jQuery('#login-heading-'+counter).html(UPMECustom.ForgotPass);
        
    });
    
    jQuery('[id^=upme-back-to-login-]').on('click', function(){

        var counter = jQuery(this).attr('id').replace('upme-back-to-login-',''); 
        
        jQuery('#upme-login-form-'+counter).css('display','block');
        jQuery('#upme-forgot-pass-holder-'+counter).css('display','none');
        jQuery('#login-heading-'+counter).html(UPMECustom.Login);
        
    });
    
    jQuery('[id^=upme-forgot-pass-btn-]').on('click', function(){

        var counter = jQuery(this).attr('id').replace('upme-forgot-pass-btn-','');
        
        if(jQuery('#user_name_email-'+counter).val() == '')
        {
            alert(UPMECustom.Messages.EnterDetails);
        }
        else
        {
            jQuery.post(
                UPMECustom.AdminAjax,
                {
                    'action': 'request_password',
                    'user_details':   jQuery('#user_name_email-'+counter).val()
                },
                function(response){

                    var forgot_pass_msg=
                    {
                        "invalid_email" : UPMECustom.Messages.ValidEmail,
                        "invalid"       : UPMECustom.Messages.ValidEmail,
                        "not_allowed"   : UPMECustom.Messages.NotAllowed,
                        "mail_error"    : UPMECustom.Messages.EmailError,
                        "success"       : UPMECustom.Messages.PasswordSent,
                        "default"       : UPMECustom.Messages.WentWrong
                    }

                    if(typeof(forgot_pass_msg[response]) == 'undefined')
                    {
                        alert(forgot_pass_msg['default']);
                    }
                    else
                    {
                        alert(forgot_pass_msg[response]);
                        if(response == 'success')
                            jQuery('#upme-back-to-login-'+counter).trigger('click');
                    }
    				    	
                }
                );
        }
    });

    jQuery("[id^=upme-forgot-pass-holder-]").css('display','none');


    /* Registration Form: Validate email on focus out */
    $('.upme-registration').find('#reg_user_email').blur(function(){

        var newUserEmail = $(this).val();
        var email = $(this);
        var email_reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var message;

        $("#upme-reg-email-img").remove();
        $("#upme-reg-email-msg").remove();

        if('' == newUserEmail){
            message = UPMECustom.Messages.RegEmptyEmail;
            $(email).addClass('error');
            $(email).after('<div id="upme-reg-email-msg" class="upme-input-text-inline-error" ><i id="upme-reg-email-img" original-title="Invalid" class="upme-icon-remove upme-input-text-font-cancel" ></i>' + message + '</div>');
               
        }else if(!email_reg.test(newUserEmail)){
            message = UPMECustom.Messages.RegInvalidEmail;
            $(email).addClass('error');
            $(email).after('<div id="upme-reg-email-msg" class="upme-input-text-inline-error" ><i id="upme-reg-email-img" original-title="Invalid" class="upme-icon-remove upme-input-text-font-cancel" ></i>' + message + '</div>');
               
        }else{
            

        jQuery.post(
            UPMECustom.AdminAjax,
            {
                'action': 'validate_register_email',
                'user_email':   newUserEmail
            },
            function(response){

                
                switch(response.msg){
                    case 'RegExistEmail':
                        message = UPMECustom.Messages.RegExistEmail;
                        break;
                    case 'RegValidEmail':
                        message = UPMECustom.Messages.RegValidEmail;
                        break;
                    case 'RegInvalidEmail':
                        message = UPMECustom.Messages.RegInvalidEmail;
                        break;
                    case 'RegEmptyEmail':
                        message = UPMECustom.Messages.RegEmptyEmail;
                        break;
                }

                if(response.status){
                    $(email).addClass('error');
                    $(email).after('<div id="upme-reg-email-msg" class="upme-input-text-inline-error" ><i id="upme-reg-email-img" original-title="Invalid" class="upme-icon-remove upme-input-text-font-cancel" ></i>' + message + '</div>');
                }else{
                    $(email).after('<div id="upme-reg-email-msg" class="upme-input-text-inline-success" ><i id="upme-reg-email-img" original-title="Valid" class="upme-icon-ok upme-input-text-font-accept" ></i>' + message + '</div>');
                }

            },"json");
        }

        
    });

    /* Registration Form: Validate username on focus out */
    $('.upme-registration').find('#reg_user_login').blur(function(){

        var newUserLogin = $(this).val();
        var login = $(this);

        $("#upme-reg-login-img").remove();
        $("#upme-reg-login-msg").remove();

        if('' == newUserLogin){
            message = UPMECustom.Messages.RegEmptyUsername;
            $(login).addClass('error');
            $(login).after('<div id="upme-reg-login-msg" class="upme-input-text-inline-error" ><i id="upme-reg-login-img" original-title="Invalid" class="upme-icon-remove upme-input-text-font-cancel" ></i>' + message + '</div>');
                  
        }else{
            jQuery.post(
            UPMECustom.AdminAjax,
            {
                'action': 'validate_register_username',
                'user_login':   newUserLogin
            },
            function(response){

                var message;
                switch(response.msg){
                    case 'RegExistUsername':
                        message = UPMECustom.Messages.RegExistUsername;
                        break;
                    case 'RegValidUsername':
                        message = UPMECustom.Messages.RegValidUsername;
                        break;
                    case 'RegEmptyUsername':
                        message = UPMECustom.Messages.RegEmptyUsername;
                        break;
                    case 'RegInValidUsername':
                        message = UPMECustom.Messages.RegInValidUsername;
                        break;
                }
 
                if(response.status){
                    $(login).addClass('error');
                    $(login).after('<div id="upme-reg-login-msg" class="upme-input-text-inline-error" ><i id="upme-reg-login-img" original-title="Invalid" class="upme-icon-remove upme-input-text-font-cancel" ></i>' + message + '</div>');
                }else{
                    $(login).after('<div id="upme-reg-login-msg" class="upme-input-text-inline-success" ><i id="upme-reg-login-img" original-title="Valid" class="upme-icon-ok upme-input-text-font-accept" ></i>' + message + '</div>');
                }

            },"json");
        }

        
    });

    // Clear error messages on focus
    $('.upme-registration').find('#reg_user_login').focus(function(){
        $("#upme-reg-login-img").remove();
        $("#upme-reg-login-msg").remove();

        $(this).removeClass('error');
    });

    $('.upme-registration').find('#reg_user_email').focus(function(){
        $("#upme-reg-email-img").remove();
        $("#upme-reg-email-msg").remove();

        $(this).removeClass('error');
    });

    $('.upme-registration').find('#reg_user_pass').focus(function(){
        $(this).removeClass('error');
    });

    $('.upme-registration').find('#reg_user_pass_confirm').focus(function(){
        $(this).removeClass('error');
    });


    //  Delete uploaded images from edit profile screen
    $('body').on("click",".upme-delete-image-wrapper",function(){

        var userAction =confirm(UPMECustom.Messages.DelPromptMessage);
        if (userAction==true){
            var userId = $(this).attr("upme-data-user-id");
            var fieldName = $(this).attr("upme-data-field-name");
            var imgObject = $(this);

            $('#upme-spinner-'+fieldName).show();

            jQuery.post(
                UPMECustom.AdminAjax,
                {
                    'action': 'upme_delete_profile_images',
                    'user_id':   userId,
                    'field_name' : fieldName
                },
                function(response){
 
                    if(response.status){
                        $(imgObject).parent().remove();
                    }

                    $('#upme-spinner-'+fieldName).hide();

                },"json");
        }        
    });

    //  Delete user pic edit profile and image upload screens
    $('body').on("click",".upme-delete-userpic-wrapper",function(){

        var userAction =confirm(UPMECustom.Messages.DelPromptMessage);
        if (userAction==true){
            var userId = $(this).attr("upme-data-user-id");
            var fieldName = $(this).attr("upme-data-field-name");
            var imgObject = $(this);


            $('#upme-spinner-'+fieldName).show();

            jQuery.post(
                UPMECustom.AdminAjax,
                {
                    'action': 'upme_delete_profile_images',
                    'user_id':   userId,
                    'field_name' : fieldName
                },
                function(response){
 
                    if(response.status){
                        $(imgObject).parent().remove();
                    }

                    $('#upme-spinner-'+fieldName).hide();

                },"json");
        }        
    });

    // Submit the form on Crop link click
    //$('#upme-crop-submit').click(function(){
    //    $("#upme-crop-frm").submit();
    //});

    // Submit the form to initialize the cropping functionality
    $('#upme-crop-request').click(function(){
        var userId = $(this).attr("upme-data-user-id");
        $('#upme-crop-request-'+ userId).remove();
        $(this).append('<input id="upme-crop-request-'+ userId + '" type="hidden" name="upme-crop-request-'+ userId + '" value="1" />');
        $("#upme-crop-frm").submit();
    });

    // Validate the file upload field and submit the form to upload user picture
    $('#upme-upload-image').click(function(){

        $("#upme-crop-upload-err-block").html('');
        $("#upme-crop-upload-err-holder").hide();

        var dataMeta = $(this).attr("upme-data-meta");
        var dataId = $(this).attr("upme-data-id");
        var fileFieldValue = $('#file_'+ dataMeta + '-' + dataId).val();

        if("" == fileFieldValue){
            $("#upme-crop-upload-err-block").html('<span class="upme-error upme-error-block"><i class="upme-icon-remove"></i> '+UPMECustom.Messages.UploadEmptyMessage+'</span>');
            $("#upme-crop-upload-err-holder").show();
        }else{
            $("#upme-crop-upload-err-holder").hide();
            $('#file_'+ dataMeta + '-' + dataId).append('<input id="upme-upload-submit-'+ dataId + '" type="hidden" name="upme-upload-submit-'+ dataId + '" value="1" />');
        
            $("#upme-crop-frm").submit(); 
        }
        
    });

});

function change_page(page_num)
{
	if(jQuery( "#upme_search_form" ).length > 0)
	{
		jQuery('#userspage').val(page_num);
		jQuery( "#upme_search_form" ).submit();
	}
	else if(jQuery( "#upme-pagination-form" ).length > 0)
	{
		jQuery('#upme-pagination-form-per-page').val(page_num);
		jQuery( "#upme-pagination-form" ).submit();
	}
}
