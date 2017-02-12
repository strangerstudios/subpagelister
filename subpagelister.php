<?php
/*
Plugin Name: Subpagelister
Plugin URI: http://www.strangerstudios.com/plugins/subpagelister/
Description: Dynamic content organization with flexible display options.
Version: 1.0
Author: kimannwall, strangerstudios
Author URI: http://www.strangerstudios.com
*/

define( 'SUBPAGELISTER_DIR', dirname(__FILE__) );
define( 'SUBPAGELISTER_URL', plugins_url( '', __FILE__ ) );
define( 'SUBPAGELISTER_VERSION', '1.0' );

/*
	Enqueue Stylesheet
*/
function subpagelister_init_styles()
{	
	wp_enqueue_style( 'subpagelister_frontend', SUBPAGELISTER_URL . '/css/subpagelister.css', array(), SUBPAGELISTER_VERSION);	
}
add_action( 'wp_enqueue_scripts', 'subpagelister_init_styles' );	

/**
 * Shows the subpages (in page order) and excerpts.
 *
 * @param array $args Configuration arguments.
 */
function subpagelister_shortcode_handler( $atts, $content=null, $code='' ) {
	global $post;
	
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// $code    ::= the shortcode found, when == callback name
	// examples: [subpagelist exclude="1,2,3" show="excerpt" link="button" orderby="menu_order"]
	
	extract( shortcode_atts ( array (
		'exclude'			=> NULL,
		'layout'				=> NULL,
		'link'				=> true,
		'link_text'			=> '(more...)',
		'orderby'			=> 'menu_order',
		'order'				=> 'ASC',
		'post_parent'		=> $post->ID,
		'show'				=> 'excerpt',
		'show_children'		=> false,
		'thumbnail'			=> false,
		'thumbnail_align'	=> false,
	), $atts ) );
	
	if ( empty($link) || strtolower( $link ) === 'false' ) {
		$link = false;
	}
	
	if ( $show_children === '0' || strtolower( $show_children ) === 'false' || strtolower( $show_children ) === 'no' ) {
		$show_children = false;
	}
				
	if ( empty($thumbnail) || strtolower( $thumbnail ) === 'false' ) {
		$thumbnail = false;
	} elseif ( strtolower( $thumbnail ) === 'true' ) {
		$thumbnail = 'thumbnail';
	}
	
	if( !empty( $thumbnail_align ) ) {
		if( strtolower( $thumbnail_align ) === 'center' ) {
			$thumbnail_align = 'aligncenter';
		} elseif( strtolower( $thumbnail_align ) === 'left' ) {
			$thumbnail_align = 'alignleft';
		} else {
			$thumbnail_align = 'alignright';
		}
	}
	
	// prep exclude array
	$exclude = str_replace( ' ', '', $exclude );
	$exclude_array = explode( ',', $exclude );
		
	// our return string
	$r = '';
	$r = '<div class="subpagelist">';

	// get posts
	$args = array (
		'post_type'		=> 'page',
		'showposts'		=> -1,
		'orderby'		=> $orderby,
		'post_parent'	=> $post_parent,
		'order'			=> $order,
		'post__not_in'	=> $exclude_array
	);
	$subpageposts = get_posts( $args );
	
	$layout_cols = preg_replace( '/[^0-9]/', '', $layout );	
	if ( !empty ( $layout_cols ) ) {
		$subpageposts_chunks = array_chunk( $subpageposts, $layout_cols );
	} else {
		$subpageposts_chunks = array_chunk( $subpageposts, '1' );
	}

  	//to show excerpts or full content. save the old value to revert
	global $more;
	$oldmore = $more;

	// the Loop
	$nchunks = count( $subpageposts_chunks );		
	for( $i = 0; $i < $nchunks; $i++ ):
		$row = $subpageposts_chunks[$i];
		$r .= '<div class="row">';
		foreach( $row as $post ):  
			setup_postdata( $post );
			$r .= '<div class="medium-';			
			if ( $layout === '2col' ) {
				$r .= '6';
			} elseif ( $layout === '3col' ) {
				$r .= '4';
			} elseif ( $layout === '4col' ) {
				$r .= '3';
			} else {
				$r .= '12';
			}
			$r .= ' columns">';
			$r .= '<article id="post-' . get_the_ID() . '" class="' . implode( " ", get_post_class() ) . ' subpagelist_item">';
		
			if ( has_post_thumbnail() && empty( $layout ) && !empty( $thumbnail ) ) {
				if( empty( $thumbnail_align ) ) {
					$thumbnail_align = "alignright";	
				}
				if ( $link) {
					$r .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, $thumbnail, array('class' => $thumbnail_align ) ) . '</a>';
				} else {
					$r .= get_the_post_thumbnail( $post->ID, $thumbnail, array('class' => $thumbnail_align) );
				}
			}
			
			$r .= '<header class="entry-header">';
			$r .= '<h1 class="entry-title">';
	
			if ( $link ) {
				$r .= '<a href="' . get_permalink() . '" rel="bookmark">';
				$r .= the_title('','',false);
				$r .= '</a>';
			} else {
				$r .= the_title( '', '', false );
			}
						
			$r .= '</h1>';
			$r .= '</header>';		
			$r .= '<div class="entry-content">';		
	
			if ( has_post_thumbnail() && !empty( $layout ) && !empty( $thumbnail ) ) {	
				if( empty( $thumbnail_align ) ) {							
					if ( $layout === '3col' || $layout === '4col' ) {
						$thumbnail_align = "aligncenter";
					} else {
						$thumbnail_align = "alignright";
					}
				}
				if ( $link ) {
					$r .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, $thumbnail, array('class' => $thumbnail_align ) ) . '</a>';
				} else {
					$r .= get_the_post_thumbnail( $post->ID, $thumbnail, array( 'class' => $thumbnail_align ) );
				}
			}
										
			if ( $show === "excerpt" ) {
				$more = 0;
				$r .= apply_filters('the_content', preg_replace("/\[subpagelist[^\]]*\]/", "", get_the_excerpt( '' ) ) );
			} elseif ( $show === "content" ) {
				$more = 1;
				$r .= apply_filters('the_content', preg_replace("/\[subpagelist[^\]]*\]/", "", get_the_content( '' ) ) );					
			} else {
				$r .= '';
			}
			
			if ( !empty( $show_children ) )
			{
				$r .= '<ul class="subpagelist_children">';
				$r .= '<li class="page_item page-item-' . $post->ID . '"><a href="' . get_permalink() . '" rel="bookmark">' . the_title('','',false) . '</a></li>';
				$r .= wp_list_pages( array( 'child_of' => $post->ID, 'depth' => '-1', 'echo' => false, 'exclude' => $exclude, 'sort_column' => 'menu_order', 'title_li' => '' ) );
				$r .= '</ul>';			
			}
			
			if ( $link )
			{
				$r .= '<p><a href="' . get_permalink() . '" rel="bookmark" class="more-link';
				if ( $link === "button" ) {
					$r .= ' subpagelist_btn';
				}
				if ( $layout === '3col' || $layout === '4col' ) {
					$r .= ' subpagelist_btn-block';
				}
				$r .= '">';
				$r .= $link_text;
				$r .= '</a></p>';
			}
								
			$r .= '</div>'; //end entry-content
			$r .= '</article>';
			$r .= '</div>'; //end columns		
		
			endforeach;
		$r .= '</div>'; //end row
		
		if ( $i < $nchunks - 1 ) {
			$r .= "<hr />";
		}
		
	endfor;

	$r .= '</div>'; // end subpagelist

	//Reset Query
	wp_reset_query();

	//revert
	$more = $oldmore;
	
	return $r;
}
add_shortcode( 'subpagelist', 'subpagelister_shortcode_handler' );

function subpagelister_remove_subpagelist_from_excerpt( $excerpt )
{
	$excerpt = preg_replace( "/\[subpagelist[^\]]*\]/", "", $excerpt );
	return $excerpt;
}
add_filter( 'the_excerpt', 'subpagelister_remove_subpagelist_from_excerpt' );
