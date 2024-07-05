<div class="wrap"><h2><img src="<?php echo WP_PLUGIN_URL; ?>/sb-login/img/icon2.png" alt="i"> SB Login Plugin</h2>
<br/><div style="width: 65%; float: left;">
<div class="postbox" style="display: block;float:left;margin:5px;clear:left; width: 99%;">
	<h3 class="hndle" style="padding:5px;"><span>About "SB Login" Plugin</span></h3>
<div class="inside"><p align="justify">"SB Login" is a simple, smart and easy to use wordpress plugin. Using this very simple plugin on your wordpress blog/site you can show a login form, a registration form and a password reset form in the same place using Ajax functionality. User can easily Login, Register and Reset their password without leaving the page. After login you can know how many posts and comments have been made in this blog. You can also know which posts you have last visited and where you have commented.</p></div></div>

<div class="postbox" style="display: block;float:left;margin:5px;clear:left; width: 99%;">
	<h3 class="hndle" style="padding:5px;"><span>Widget Usage Instructions</span></h3>
<div class="inside">
<p align="justify">Go to <strong>Appearance > Widgets</strong>. Then drag and drop the <strong>SB Login</strong> widget on your theme's sidebar to activate it.</p>
</div></div>


<div class="postbox" style="display: block;float:left;margin:5px;clear:left; width: 99%;">
	<h3 class="hndle" style="padding:5px;"><span>Shortcode Usage Instructions</span></h3>
<div class="inside">
<p> <b>Put this shortcode in your blog post/page/widget:</b><br/>

Just copy it: <code><span style="color: #000000"><span style="color: #0000BB"> &#91;sblogin&#93;</span></span></code><br/>
</p><p>
<b> Or, insert this php code in your theme or any other template file:</b><br/>
<br/>
Just copy it: <code><span style="color: #000000"><span style="color: #0000BB">   &#60;&#63;php echo do_shortcode&#40;&#39;&#91;sblogin&#93;&#39;&#41;; </span><span style="color: #0000BB">&#63;&#62;</span></span>
</code>
</p></div></div>


<div class="postbox" style="display: block;float:left;margin:5px;clear:left; width: 99%;">
	<h3 class="hndle" style="padding:5px;"><span>F.A.Q.</span></h3>
<div class="inside">
<p> <b>Q: Tabs Not Working</b><br/>
<b>A:</b> Most probably Java Script problem. If you are using any plugin that minify Java script which is causing the problem. Don't enable Java Script Minification.
<p> <b>Q: Widget not working</b><br/>
<b>A:</b> Most good themes contain the required wp_head/wp_footer hooks - if yours does not you will need to slap your developer on the back of the head and add them to your theme's header and footer.php files.

</div></div>
<div class="postbox" style="display: block;float:left;margin:5px;clear:left; width: 99%;">
	<h3 class="hndle" style="padding:5px;"><span>Currently Available Translations</span></h3>
<div class="inside">
<p align="justify">Currently available translation files are:<br>
Arabic by Samy Ahmed<br>Bengali<br>French by darth<br>German by Jens Meyer<br>Italian by <a href="http://www.iononmollo.it/" target="_blank">Redazione</a><br>Persian by <a href="http://www.alimir.ir/" target="_blank">Ali Mirzaei</a><br>Russian by <a href="http://dvascheta.ru/" target="_blank">Alexey Anisimov</a><br>
If you have your own translation file of your language just mail it to me, I will add it in the next update and will give you the credit.<br>
My mail: <a href="mailto:fidaalhasan@gmail.com">fidaalhasan@gmail.com</a></p>
</div></div>


<div class="postbox" style="display: block;float:left;margin:5px;clear:left; width: 99%;">
	<h3 class="hndle" style="padding:5px;"><span>About the team</span></h3>
<div class="inside">
<p align="justify">
<p style="text-align: center;"><a href="http://webcarezone.com" target="_blank"><img src="<?php echo WP_PLUGIN_URL; ?>/sb-login/img/wcz.png"></a></p>
This great plugin is written by Web Care Zone team. Web Care Zone is one of the most leading Web Design & Development company in Bangladesh. Their services are: Website Design, Logo Design, Search Engine Optimization, Website Security, Website Speed Optimization, Facebook Page Design and many more. In recent years they started to contribute in WordPress.<br>
<b>Mobile:</b> +880-1677690868<br>
<b>Mail:</b> contact@webcarezone.com<br>
<b>Web:</b> <a href="http://webcarezone.com" target="_blank">www.webcarezone.com</a></p>
</div></div>
</div>

<?php echo sbl_sidebar(); ?>

</div>
