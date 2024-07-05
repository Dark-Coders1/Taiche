/*
Copyright (C) 2013  Fida Al Hasan

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

(function($){
	// Tabs
	jQuery('ul.nd_tabs li:first').addClass('active');
	jQuery('form.nd_form, div.nd_logged_in').hide();
	jQuery('form.nd_form:first, div.nd_logged_in:first').show();
	jQuery('ul.nd_tabs li a:not(ul.nd_tabs li.tab_right a), form.nd_form a.forgotten').click(function(){
		jQuery('form.nd_form, div.nd_logged_in').hide();
		jQuery('ul.nd_tabs li').removeClass('active');
		jQuery(this).parent().addClass('active');
		jQuery( jQuery(this).attr('href') ).fadeIn();
		return false;
	});
	
	// Ajax
	jQuery('form.nd_form').submit(function(){
		var thisform = this;
		jQuery('div.nd_form_inner').block({ message: null, overlayCSS: { 
	        backgroundColor: '#fff', 
	        opacity:         0.6 
	    } });
		jQuery.ajax({
			type: 'POST',
			url: jQuery(thisform).attr('action'),
			data: jQuery(thisform).serialize(),
			success: function( result ){
				jQuery('ul.errors, ul.messages').remove();
				result = jQuery.trim( result );
				if (result=='SUCCESS') {
					window.location = jQuery(thisform).attr('action');
				} else if (result.substring(8,0) =='SUCCESS:') {
					message = result.substr(8);
					jQuery('div.nd_form_inner', thisform).prepend('<ul class="messages"><li>' + message + '</li></ul>');
					jQuery('div.nd_form_inner').unblock();
				} else {
					jQuery('div.nd_form_inner', thisform).prepend('<ul class="errors"><li>' + result + '</li></ul>');
					jQuery('div.nd_form_inner').unblock();
				}
			}
		});
		return false;
	});
})(jQuery);