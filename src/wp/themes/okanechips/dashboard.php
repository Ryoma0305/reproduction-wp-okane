<?php
/**************************************************
ダッシュボード
**************************************************/
function post_metaboxhidden_dashboard($result, $option, $user){
	return array(
		'dashboard_right_now',
		'dashboard_activity',
		'dashboard_quick_press',
		'dashboard_primary',
    'dashboard_site_health'
	);
}
add_filter('get_user_option_metaboxhidden_dashboard', 'post_metaboxhidden_dashboard', 10, 3);
add_filter('get_user_option_managedashboardcolumnshidden', 'post_metaboxhidden_dashboard', 10, 3);
remove_action('welcome_panel', 'wp_welcome_panel');

function on_add_dashboard($type){
	global $util;
	echo '<div class="post-activity-widget">';
	echo '<div class="post-activity-block">';
 	if ( $type == 'post') {
		$dbQuery = new WP_Query(array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => 10
		));
		echo '<h3>最近の投稿</h3>';
		if( $dbQuery->have_posts() ){
			echo '<div class="dashboard-post-list">';
			while( $dbQuery->have_posts() ){
				$dbQuery->the_post();
				echo '<div class="item">';
				echo '<div class="item__img">';
				$image = '';
				if( has_post_thumbnail(get_the_ID()) ){
					$imageObj = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'list-thumb');
					$image = $imageObj[0];
				}else{
					$image = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
				}
				if( $image ){
					echo '<img src="'.$image.'" alt="">';
				}
				echo '</div>';
				echo '<div class="item__txt">';
        echo '<div class="item__meta">';
        echo '<span class="item__date">'.get_the_date("Y.m.d").'</span>';
				$category = get_the_category(get_the_ID());
				if( $category ){
					echo '<ul class="item__cat">';
	        $str = '';
	        foreach($category as $cat){
	            $str .= '<li>'.$cat->name.'</li>';
	        }
	        echo rtrim($str);
	        echo '</ul>';
				}
        echo '</div>';
				echo '<a href="'.get_permalink().'" class="item__ttl">'.get_the_title().'</a>';
				echo '<span class="edit">【<a href="'.get_edit_post_link().'">編集</a>】</span>';
				$tags = get_the_tags(get_the_ID());
				if( $tags ){
					echo '<ul class="item__corner">';
	        $str = '';
	        foreach($tags as $tag){
	            $str .= '<li>'.$tag->name.'</li>';
	        }
	        echo rtrim($str);
	        echo '</ul>';
				}
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
		}
    wp_reset_postdata();
	}
		echo '</div>';
		echo '</div>';
}

function on_add_dashboard_setup(){
	global $wp_meta_boxes;
	$widget_array = array();
	// 新着記事
	array_push($widget_array, 'widget_post');
	wp_add_dashboard_widget('widget_post', '新着記事', function(){
		on_add_dashboard('post');
	});
	// 配置
	foreach( $widget_array as $key ) {
		$widget = $wp_meta_boxes['dashboard']['normal']['core'][$key];
		unset($wp_meta_boxes['dashboard']['normal']['core'][$key]);
		if( $key == 'widget_post' ) {
			array_push($wp_meta_boxes['dashboard']['normal']['core'], $widget);
		} else {
			array_push($wp_meta_boxes['dashboard']['side']['core'], $widget);
		}
	}
}
add_action('wp_dashboard_setup', 'on_add_dashboard_setup');
