<?php
/**
 * Template Name: Newsletters
 *
 * The blog page template displays the "blog-style" template on a sub-page.
 *
 * @package WooFramework
 * @subpackage Template
 */

 get_header();
 global $woo_options;

?>
<?php get_header(); ?>
<h1>Newsletters</h1>
<?php

$myrows = $wpdb->get_results( "SELECT content FROM wp_archived_newsletters" );
print_r($myrows[1]->content);

?>
