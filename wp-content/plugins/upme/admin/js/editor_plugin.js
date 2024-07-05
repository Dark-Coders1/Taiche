(
	function(){
	
		tinymce.create(
			"tinymce.plugins.UPMEShortcodes",
			{
				init: function(d,e) {},
				createControl:function(d,e)
				{
				
					if(d=="upme_shortcodes_button"){
					
						d=e.createMenuButton( "upme_shortcodes_button",{
							title:"Insert UPME Shortcode",
							icons:false
							});
							
							var a=this;d.onRenderMenu.add(function(c,b){
							
								c=b.addMenu({title:"Login / Registration Forms"});
									a.addImmediate(c,"Front-end Registration Form", '[upme_registration]');
									a.addImmediate(c,"Registration Form with Custom Redirect", '[upme_registration redirect_to="http://url_here"]');
									a.addImmediate(c,"Registration Form with Captcha", '[upme_registration captcha=yes]');
									a.addImmediate(c,"Registration Form without Captcha", '[upme_registration captcha=no]');
									a.addImmediate(c,"Front-end Login Form", '[upme_login]');
									a.addImmediate(c,"Sidebar Login Widget (use in text widget)", '[upme_login use_in_sidebar=yes]');
									a.addImmediate(c,"Login Form with Custom Redirect", '[upme_login redirect_to="http://url_here"]');
									a.addImmediate(c,"Logout Button", '[upme_logout]');
									a.addImmediate(c,"Logout Button with Custom Redirect", '[upme_logout redirect_to="http://url_here"]');
								
								b.addSeparator();
								
								c=b.addMenu({title:"Single Profile"});
										a.addImmediate(c,"Logged in User Profile","[upme]" );
										a.addImmediate(c,"Logged in User Profile showing User ID","[upme show_id=true]" );
										a.addImmediate(c,"Post Author Profile","[upme id=author]" );
										a.addImmediate(c,"Specific User Profile","[upme id=X]" );
								
								b.addSeparator();
								
								c=b.addMenu({title:"Multiple Profiles / Member List"});
									a.addImmediate(c,"Group of Specific Users", '[upme group=user_id1,user_id2,user_id3,etc]');
									a.addImmediate(c,"All Users", '[upme group=all users_per_page=10]');
									a.addImmediate(c,"All Users in Compact View", '[upme group=all view=compact users_per_page=10]');
									a.addImmediate(c,"All Users in Compact View, Half Width", '[upme group=all view=compact width=2 users_per_page=10]');
									a.addImmediate(c,"Users Based on User Role", '[upme group=all role=subscriber users_per_page=10]');
									a.addImmediate(c,"Administrator Users Only", '[upme group=all role=administrator users_per_page=10]');
									a.addImmediate(c,"All Users Ordered by Display Name", '[upme group=all order=asc orderby=display_name users_per_page=10]');
									a.addImmediate(c,"All Users Ordered by Post Count", '[upme group=all order=desc orderby=post_count users_per_page=10]');
									a.addImmediate(c,"All Users Ordered by Registration Date", '[upme group=all order=desc orderby=registered users_per_page=10]');
									a.addImmediate(c,"All Users showing User ID", '[upme group=all show_id=true users_per_page=10]');
									a.addImmediate(c,"Search Profiles", '[upme_search operator=OR]');
									a.addImmediate(c,"Search with Custom Field Filters", '[upme_search filters=meta1,meta2,meta3]');
								
								b.addSeparator();
								
								a.addImmediate(b,"Private Content (Login Required)", '[upme_private]Place member only content here[/upme_private]');
								
								b.addSeparator();
								
								c=b.addMenu({title:"Shortcode Option Examples"});
									a.addImmediate(c,"Hide User Statistics", '[upme show_stats=no]');
									a.addImmediate(c,"Hide User Social Bar", '[upme show_social_bar=no]');
									a.addImmediate(c,"1/2 Width Profile View", '[upme width=2]');
									a.addImmediate(c,"Compact View (No extra fields)", '[upme view=compact]');
									a.addImmediate(c,"Customized Profile Fields", '[upme view=meta_id1,meta_id2,meta_id3]');
									a.addImmediate(c,"Show User ID on Profiles", '[upme show_id=true]');

							});
						return d
					
					} // End IF Statement
					
					return null
				},
		
				addImmediate:function(d,e,a){d.add({title:e,onclick:function(){tinyMCE.activeEditor.execCommand( "mceInsertContent",false,a)}})}
				
			}
		);
		
		tinymce.PluginManager.add( "UPMEShortcodes", tinymce.plugins.UPMEShortcodes);
	}
)();