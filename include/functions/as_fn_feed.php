<?php

function as_as_disable_feeds() {
	wp_redirect( home_url() );
	die;
}

// if active FEED
if(get_option('as_check_feed_db')):
	// Disable global RSS, RDF & Atom feeds.
	add_action( 'do_feed',      'as_disable_feeds', -1 );
	add_action( 'do_feed_rdf',  'as_disable_feeds', -1 );
	add_action( 'do_feed_rss',  'as_disable_feeds', -1 );
	add_action( 'do_feed_rss2', 'as_disable_feeds', -1 );
	add_action( 'do_feed_atom', 'as_disable_feeds', -1 );

	// Disable comment feeds.
	add_action( 'do_feed_rss2_comments', 'as_disable_feeds', -1 );
	add_action( 'do_feed_atom_comments', 'as_disable_feeds', -1 );

	// Prevent feed links from being inserted in the <head> of the page.
	add_action( 'feed_links_show_posts_feed',    '__return_false', -1 );
	add_action( 'feed_links_show_comments_feed', '__return_false', -1 );
	remove_action( 'wp_head', 'feed_links',       2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
endif;
