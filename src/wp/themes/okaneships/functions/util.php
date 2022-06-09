<?php
/**************************************************
Util
**************************************************/
class Util {
	public function __construct(){
		// ツールバー非表示
		add_filter('show_admin_bar', '__return_false');
		// remove_action
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'rel_canonical');
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
		remove_action('wp_head', 'rest_output_link_wp_head');
		// remove_action('wp_head', 'wp_oembed_add_discovery_links');
		// remove_action('wp_head', 'wp_oembed_add_host_js');
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		// srcset
		add_filter( 'wp_calculate_image_sizes', '__return_false');
		add_filter( 'wp_calculate_image_srcset', '__return_false');
		// dns prefetch
		add_filter('wp_resource_hints', function($hints, $relation_type){
			if( 'dns-prefetch' === $relation_type ) {
				return array_diff(wp_dependencies_unique_hosts(), $hints);
			}
			return $hints;
		}, 10, 2);
		// アイキャッチ
		if( function_exists('add_theme_support') ){
			add_theme_support('post-thumbnails');
			add_image_size('ogimage', 1200, 630, true);
			add_image_size('detail_image', 600, 400, true);
			add_image_size('user_image', 400, 400, true);
			add_image_size('talk_image', 120, 120, true);
			add_image_size('banner-m', 728, 9999, false);
			add_image_size('banner-l', 970, 9999, false);
			add_image_size('banner-s', 300, 9999, false);
		}
		// 画像サイズ、メディア挿入デフォルトリンク先、メディア挿入デフォルトサイズ
		add_action('after_setup_theme', function(){
			if( get_option('large_size_w') != 1920 ) update_option('large_size_w', 1920);
			if( get_option('large_size_h') != 9999 ) update_option('large_size_h', 9999);
			if( get_option('medium_size_w') != 300 ) update_option('medium_size_w', 300);
			if( get_option('medium_size_h') != 300 ) update_option('medium_size_h', 300);
			if( get_option('thumbnail_size_w') != 180 ) update_option('thumbnail_size_w', 180);
			if( get_option('thumbnail_size_h') != 120 ) update_option('thumbnail_size_h', 120);
			if( get_option('uploads_use_yearmonth_folders') != '1' ) update_option('uploads_use_yearmonth_folders', '1');
			if( get_option('image_default_align') != 'none' ) update_option('image_default_align', 'none');
			if( get_option('image_default_link_type') != 'none' ) update_option('image_default_link_type', 'none');
			if( get_option('image_default_size') != 'large' ) update_option('image_default_size', 'large');
		});
		add_action('init', function(){
			remove_post_type_support('post', 'comments');
			remove_post_type_support('post', 'revisions');
			remove_post_type_support('post', 'trackbacks');
			// unregister_taxonomy_for_object_type('post_tag', 'post');
		});
		function my_image_sizes( $sizes ) {
			$my_sizes = array(
					'detail_image' => __('600 x 400'),
			);
			return array_merge( $sizes, $my_sizes );
		}
		add_filter( 'image_size_names_choose', 'my_image_sizes' );
	}

	public function get_total_post_views($id=null){
		if( $id == null ) return;
		$count = get_post_meta($id, 'post_total_views_count', true);
		if( $count == '' ) {
			$count = 0;
			delete_post_meta($id, 'post_total_views_count');
			add_post_meta($id, 'post_total_views_count', $count);
		}
		return $count;
	}

	public function set_total_post_views($id=null){
		if( $id == null || is_user_logged_in() ) return;
		$count = get_post_meta($id, 'post_total_views_count', true);
		if( $count == '' ) {
			$count = 1;
			delete_post_meta($id, 'post_total_views_count');
			add_post_meta($id, 'post_total_views_count', $count);
		} else {
			$count++;
			update_post_meta($id, 'post_total_views_count', $count);
		}
	}

	public function share($type, $post_id=null){
		$output = '';
		$text = $this->pageInfo()->title();
		$text = html_entity_decode($text);
		$url = $this->pageInfo()->url();
		if( $type == 'line' ) {
			$output = 'https://line.me/R/msg/text/?'.urlencode($url);
		} elseif( $type == 'facebook' ) {
			$output = 'https://www.facebook.com/share.php?u='.urlencode($url);
		} elseif( $type == 'twitter' ) {
			$output = 'https://twitter.com/share?text='.urlencode($text).'&url='.urlencode($url).'%0a&via=okanechips';
		} elseif( $type == 'hatena' ) {
			$output = 'https://b.hatena.ne.jp/entry/s/'.urlencode($url);
		}
		return $output;
	}

	public function entry($entry_id=null, $label_flg=true, $ranking=false){
		if( !$entry_id ) return;
		$title = get_the_title($entry_id);
		$entry = '';
		$entry .= '<li class="item">'."\n";
		$entry .= '<a href="'.get_permalink($entry_id).'" class="item__link">'."\n";
		if( $ranking ) {
			$entry .= '<span class="item__num">'.$ranking.'</span>'."\n";
		}
		$entry .= '<p class="item__ttl">'.$title.'</p>'."\n";
		$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
		if( has_post_thumbnail($entry_id) ) {
			$src = wp_get_attachment_image_src(get_post_thumbnail_id($entry_id), 'large')[0];
		}
		$entry .= '<div class="item__img"><img src="'.$src.'" alt="'.wp_strip_all_tags($title, true).'"></div>'."\n";
		$entry .= '</a>'."\n";
		$entry .= '</li>'."\n";
		return $entry;
	}

	function newIcon(){
		$ids = array();
		$query = new WP_Query(array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 5,
			'ignore_sticky_posts' => true
		));
		if( $query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();
				array_push($ids, get_the_ID());
			}
		}
		wp_reset_postdata();
		return $ids;
	}

	public function pageInfo(){
		return new PageInfo();
	}

	public function ver(){
		$theme = wp_get_theme();
		return $theme->Version;
	}
}

/* PageInfo */
class PageInfo {
	public function __construct(){
		$this->data = array(
			'page_id' => '',
			'title' => 'おかねチップス｜お金と仕事のTIPSをサクサク検索',
			'sitename' => 'おかねチップス｜お金と仕事のTIPSをサクサク検索',
			'description' => 'おかねチップスはフリーランスや副業で働く方々に向けて、お金や仕事、働き方に関する役立つ情報を発信しております。お金や仕事のことならおかねチップスを見れば全て解決！',
			'image' => array(
				'src' => get_stylesheet_directory_uri().'/assets/imgs/common/ogp.jpg',
				'width' => 1200,
				'height' => 630
			),
			'url' => '',
			'body_class' => array()
		);
		if( get_query_var('pageinfo') ) {
			foreach( get_query_var('pageinfo') as $key=>$val ) {
				if( $val ) {
					$this->data[$key] = $val;
				}
			}
		}
	}

	public function page_id(){
		return $this->data['page_id'];
	}

	public function title(){
		return $this->data['title'];
	}

	public function description(){
		return $this->data['description'];
	}

	public function type(){
		return ( is_front_page() )? 'website' : 'article';
	}

	public function sitename(){
		return $this->data['sitename'];
	}

	public function url(){
		if( $this->data['url'] ) {
			$output = $this->data['url'];
		} else {
			$protocol = ( is_ssl() )? 'https' : 'http';
			$output = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		}
		return $output;
	}

	public function image(){
		return $this->data['image'];
	}

	public function bodyClass(){
		$classes = array();
		if( $this->data['page_id'] ) {
			array_push($classes, 'page-'.$this->data['page_id']);
		}
		if( $this->data['body_class'] ) {
			$classes = array_merge($classes, $this->data['body_class']);
		}
		if( $classes ) {
			return implode(' ', $classes);
		} else {
			return '';
		}
	}
}

$util = new Util();
