<?php
/**
 * 
 * 
 *
/*
Plugin Name: Random Footer Quotes
Plugin URI: Nil
Description: Inserts random quotes in the footer
Version: 0.1
Author: Greg
License: GPLv2 or later
*/



function output_footer_markup(){
	
	$quote = get_random_quote();
	
	$markup =  '<div style="width: 960px; margin: 0 auto; padding-top: 80px; padding-bottom: 80px;"> 
					<h1>Full-Width, Left-Aligned</h1>
					<div class="testimonial-quote group">
						<img src="http://placehold.it/120x120">
						<div class="quote-container">
							<blockquote>
								<p>' . $quote['quote'] . '</p>
							</blockquote>  
							<cite><span>' . $quote['author'] . '</span>
							</cite>
						</div>
					</div>    
				</div>';
	

	
	echo $markup;
	
}

function get_random_quote(){
	
	$quote_categories = array(
	"funny",
	"inspire",
	"management",
	"love",
	"art",
	"students",
	);
	
	$random_category = $quote_categories[rand(0,count($quote_categories))]; 
	
	$request_url = 'http://quotes.rest/qod.json?category=' . $random_category;
	
	$result = file_get_contents($request_url);
	
	$result = json_decode($result,true);

	$quote = $result['contents']['quotes'][0]['quote'];
	
	echo "<div id='better-flag'>{$quote}</div>"; 
	
	$results = array('quote'=>$result['contents']['quotes'][0]['quote'],'author'=>$result['contents']['quotes'][0]['author']);
	
	return $results;
}


add_action('wp_footer','output_footer_markup');

wp_enqueue_style($handle = 'random_quote_footer_css',$src = '/wp-content/plugins/RandomFooterQuotes/css/footer_quote.css');