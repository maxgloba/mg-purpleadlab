<?php

namespace PixelYourSite\Pinterest;

use PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function getEddCustomAudiencesOptimizationParams( $post_id ) {
	
	$post = get_post( $post_id );
	
	$params = array(
		'content_name'  => '',
		'category_name' => '',
	);
	
	if ( ! $post ) {
		return $params;
	}
	
	$params['content_name']  = $post->post_title;
	$params['category_name'] = implode( ', ', PixelYourSite\getObjectTerms( 'download_category', $post_id ) );
	
	return $params;
	
}