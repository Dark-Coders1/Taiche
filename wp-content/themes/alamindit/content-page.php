<?php
/**
 * Page Content Template
 *
 * This template is the default page content template. It is used to display the content of the
 * `page.php` template file, contextually, as well as in archive lists or search results.
 *
 * @package WooFramework
 * @subpackage Template
 */

/**
 * Settings for this template file.
 *
 * This is where the specify the HTML tags for the title.
 * These options can be filtered via a child theme.
 *
 * @link http://codex.wordpress.org/Plugin_API#Filters
 */
 global $woo_options;

 $heading_tag = 'h1';
 if ( is_front_page() ) { $heading_tag = 'h2'; }
 $title_before = '<' . $heading_tag . ' class="title">';
 $title_after = '</' . $heading_tag . '>';

 $page_link_args = apply_filters( 'woothemes_pagelinks_args', array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) );

$id = get_the_ID();

if($id == 3114 || $id == 2754 || $id == 2360 || $id == 2362 || $id == 2364 || $id == 2366 || $id == 2368 || $id == 2370 || $id == 2735 || $id == 2756 || $id == 37760 || $id == 2739 || $id == 4036 || $id == 4046 || $id == 4048 || $id == 3104 || $id == 8)
{ $style = 'style = "width: 660px"';}
 woo_post_before();
?>
<article <?php post_class(); echo $style; ?>>
<?php
	woo_post_inside_before();
?>
	<header>
		<?php the_title( $title_before, $title_after ); ?>
	</header>

	<section class="entry">
	    <?php
	    	if ( ! is_singular() ) {
	    		the_excerpt();
	    	} else {
	    		the_content( __( 'Continue Reading &rarr;', 'woothemes' ) );
	    	}
	    	wp_link_pages( $page_link_args );
	    ?>
	</section><!-- /.entry -->
	<div class="fix"></div>
<?php
	woo_post_inside_after();
?>
</article><!-- /.post -->
<?php
	woo_post_after();
	$comm = get_option( 'woo_comments' );
	if ( ( $comm == 'page' || $comm == 'both' ) && is_page() ) { comments_template(); }
?>
