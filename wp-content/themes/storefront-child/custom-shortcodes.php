<?php

/**
 * Create short code for subscribe links.
 * [subscribe text='Before Link Text' link='https://link']LinkName[/subscribe]
 *
 * @param $ats
 * @param $content
 *
 * @return string
 */
function subscribe_link_att($ats, $content = null) {
	$default = array(
		'link' => '#',
		'text' => 'Follow us on '
	);
	$sh_ats = shortcode_atts($default, $ats);
	$content = do_shortcode($content);
	return $sh_ats['text'] . '<a href="'.($sh_ats['link']).'">'.$content.'</a>';
}
add_shortcode('subscribe', 'subscribe_link_att');

/**
 * Create short code to view slider.
 *
 * @return false|void
 */
function get_slider() {
	return get_template_part( 'template-parts/slider' );
}
add_shortcode( 'slider', 'get_slider');