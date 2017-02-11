<?php
/*
Plugin Name: Subpagelister
Plugin URI: http://www.strangerstudios.com/plugins/subpagelister/
Description: Shows a list of a given page’s subpages, with optional excerpt, link, button, and images.
Version: 1.0
Author: kimannwall, strangerstudios
Author URI: http://www.strangerstudios.com
*/

define('SUBPAGELISTER_DIR', dirname(__FILE__) );
define('SUBPAGELISTER_URL', plugins_url('', __FILE__));
define('SUBPAGELISTER_VERSION', '1.0.1');

/**
 * Shows the subpages (in page order) and excerpts.
 *
 * @param array $args Configuration arguments.
 */
function subpagelister_shortcode_handler($atts, $content=null, $code="") {
	global $post;
	
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// $code    ::= the shortcode found, when == callback name
	// examples: [subpagelist exclude="1,2,3" show="excerpt" link="true" orderby="menu_order"]
	
	extract(shortcode_atts(array(
		'exclude' => NULL,
		'layout' => NULL,
		'link' => true,
		'link_text' => '(more...)',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_parent' => $post->ID,
		'show' => 'excerpt',
		'show_children' => false,
		'thumbnail' => false,
	), $atts));
	
	if($link && strtolower($link) != "false")
		$link = true;
	else
		$link = false;

	if($show_children == "0" || $show_children == "false" || $show_children == "no")
		$show_children = false;
				
	if($thumbnail && strtolower($thumbnail) != "false")
	{
		/*if(strtolower($thumbnail) == "icon")
			$thumbnail = "icon";
		if(strtolower($thumbnail) == "medium")
			$thumbnail = "medium";
		elseif(strtolower($thumbnail) == "large")
			$thumbnail = "large";
		else
			$thumbnail = "thumbnail";
		*/
	}
	else
		$thumbnail = false;

	// prep exclude array
	$exclude = str_replace(" ", "", $exclude);
	$exclude_array = explode(",", $exclude);
		
	// our return string
	$r = "";
		
	// get posts
	$args = array(
		"post_type"=>"page",
		"showposts"=>-1,
		"orderby"=>$orderby,
		"post_parent"=>$post_parent,
		"order"=>$order,
		"post__not_in"=>$exclude_array
	);
	$subpageposts = get_posts($args);
	
	$layout_cols = preg_replace('/[^0-9]/', '', $layout);;	
	if(!empty($layout_cols))
		$subpageposts_chunks = array_chunk($subpageposts, $layout_cols);
	else
		$subpageposts_chunks = array_chunk($subpageposts, '1');

  	//to show excerpts. save the old value to revert
	global $more;
	$oldmore = $more;
	$more = 0;

	// the Loop
	$nchunks = count($subpageposts_chunks);		
	for($i = 0; $i < $nchunks; $i++):
		$row = $subpageposts_chunks[$i];
		$r .= '<div class="row">';
		foreach($row as $post): 
			setup_postdata($post);
			$r .= '<div class="medium-';			
			if($layout == '2col')
				$r .= '6';
			elseif($layout == '3col')
				$r .= '4';
			elseif($layout == '4col')
				$r .= '3';
			else
				$r .= '12';
			$r .= ' columns">';
			$r .= '<article id="post-' . get_the_ID() . '" class="' . implode(" ", get_post_class()) . ' subpagelist_item">';
		
			if ( has_post_thumbnail() && empty($layout) && !empty($thumbnail) && $thumbnail !== "icon")
			{
				if($layout == '3col' || $layout == '4col')
					$thumbnail_class = "aligncenter";
				else
					$thumbnail_class = "alignright";	
				if($link)
					$r .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail($post->ID, $thumbnail, array('class' => $thumbnail_class )) . '</a>';
				else
					$r .= get_the_post_thumbnail($post->ID, $thumbnail, array('class' => $thumbnail_class) );
			}
			
			$r .= '<header class="entry-header">';
			$r .= '<h1 class="entry-title">';
	
			if($link)
			{
				$r .= '<a href="' . get_permalink() . '" rel="bookmark">';
				$r .= the_title('','',false);
				$r .= '</a>';
			}
			else
			{
				$r .= the_title('','',false);
			}
						
			$r .= '</h1>';
			$r .= '</header>';		
			$r .= '<div class="entry-content">';		
	
			if ( has_post_thumbnail() && !empty($layout) && !empty($thumbnail) && $thumbnail !== "icon") 
			{			
				if($layout == '3col' || $layout == '4col')
					$thumbnail_class = "aligncenter";
				else
					$thumbnail_class = "alignright";		
				if($link)
					$r .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail($post->ID, $thumbnail, array('class' => $thumbnail_class )) . '</a>';
				else
					$r .= get_the_post_thumbnail($post->ID, $thumbnail, array('class' => $thumbnail_class) );
			}
										
			if($show == "excerpt")
				$r .= apply_filters('the_content', preg_replace("/\[subpagelist[^\]]*\]/", "", get_the_excerpt( '' )));
			elseif($show == "content")
				$r .= apply_filters('the_content', preg_replace("/\[subpagelist[^\]]*\]/", "", get_the_content( '' )));						
			else
				$r .= '';
				
			if(!empty($show_children))
			{
				$r .= '<ul class="subpagelist_children">';
				$r .= '<li class="page_item page-item-' . $post->ID . '"><a href="' . get_permalink() . '" rel="bookmark">' . the_title('','',false) . '</a></li>';
				$r .= wp_list_pages( array( 'child_of' => $post->ID, 'depth' => '-1', 'echo' => false, 'exclude' => $exclude, 'sort_column' => 'menu_order', 'title_li' => '' ) );
				$r .= '</ul>';			
			}
			
			if($link)
			{
				$r .= '<a class="more-link" href="' . get_permalink() . '" rel="bookmark">';
				$r .= $link_text;
				$r .= '</a>';
			}
								
			$r .= '</div>'; //end entry-content
			$r .= '</article>';
			$r .= '</div>'; //end columns		
		
			endforeach;
		$r .= '</div>'; //end row
		
		if($i < $nchunks - 1)
			$r .= "<hr />";
		
	endfor;

	//Reset Query
	wp_reset_query();

	//revert
	$more = $oldmore;
	
	return $r;
}
remove_shortcode('memberlite_subpagelist');	//replace shortcode bundled with Memberlite 2.0 and prior or anywhere else
add_shortcode('memberlite_subpagelist', 'subpagelister_shortcode_handler');

function subpagelister_remove_subpagelist_from_excerpt($excerpt)
{
	$excerpt = preg_replace("/\[subpagelist[^\]]*\]/", "", $excerpt);
	return $excerpt;
}
add_filter("the_excerpt", "subpagelister_remove_subpagelist_from_excerpt");
