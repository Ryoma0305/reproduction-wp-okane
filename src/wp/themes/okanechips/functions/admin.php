<?php
/**************************************************
管理画面
**************************************************/
/* css, js追加 */
function on_add_js_css(){
	wp_enqueue_style('admin', get_template_directory_uri().'/admin/css/admin.css');
	// wp_enqueue_script('admin', get_template_directory_uri().'/admin/js/admin.js');
}
add_action('admin_enqueue_scripts', 'on_add_js_css');

/* メニュー並び替え */
function edit_admin_menu() {
    global $menu;
    foreach( $menu as $key=>$val ) {
        //　投稿、コメント、リンク、固定ページ
        if(
            $val[2] == 'edit-comments.php'
            || $val[2] == 'edit-tags.php?taxonomy=link_category'
        ) {
            unset($menu[$key]);
        }
    }
}
add_action('admin_menu', 'edit_admin_menu');

// on_change_query
function on_change_query($query){
    if( is_admin() || !$query->is_main_query()) return;
    if( get_search_query() || is_author() || is_archive() || is_home() ){
        $query->set('ignore_sticky_posts', true);
    }
}
add_filter('pre_get_posts', 'on_change_query');

//　メニュー非表示
add_action( 'admin_menu', 'remove_menus');
function remove_menus(){
	remove_menu_page('edit-comments.php');
	remove_menu_page( 'tools.php' );
}

//【プラグインカスタマイズ】Public Post Preview 有効期限変更
function my_nonce_life() {
    return 60 * 60 * 24 * 14; // 14 days（秒 x 分 x 時 x 日）
}
add_filter( 'ppp_nonce_life', 'my_nonce_life' );

// タグ項目名変更
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $submenu['edit.php'][16][0] = 'コーナー';
}
add_action( 'admin_menu', 'change_post_menu_label' );

// タグチェックボックス化
function _re_register_post_tag_taxonomy() {
	$tag_slug_args = get_taxonomy('post_tag');
	$tag_slug_args -> hierarchical = true;
	$tag_slug_args -> meta_box_cb = 'post_categories_meta_box';
	register_taxonomy( 'post_tag', 'post',(array) $tag_slug_args);
}
add_action( 'init', '_re_register_post_tag_taxonomy', 1 );

// タグ編集画面変更
function change_taxonomies_label() {
    global $wp_taxonomies;
    $labels = $wp_taxonomies['post_tag']->labels;
    $labels->name = 'コーナー';
    $labels->singular_name = 'コーナー';
        $labels->menu_name = 'コーナー';
    $labels->search_items = 'コーナーを検索';
    $labels->popular_items = '人気のコーナー';
    $labels->all_items = 'すべてのコーナー';
    $labels->edit_item = 'コーナーの編集';
    $labels->view_item = 'コーナーを表示';
    $labels->update_item = 'コーナーを更新';
    $labels->add_new_item = '新規コーナーを追加';
    $labels->new_item_name = '新規コーナー名';
    $labels->separate_items_with_commas = 'コーナーが複数ある場合はコンマで区切ってください';
    $labels->add_or_remove_items = 'コーナーの追加もしくは削除';
    $labels->choose_from_most_used = 'よく使われているコーナーから選択';
    $labels->not_found = 'コーナーが見つかりませんでした。';
    $labels->no_terms = 'コーナーなし';
}
add_action( 'init', 'change_taxonomies_label' );

// タグ絞り込み追加
function add_post_tag_filter() {
    global $post_type;
    if ( $post_type == 'post' ) {
        wp_dropdown_categories( array(
        'show_option_all' => 'コーナー一覧',
        'orderby' => 'name',
        'hide_empty' => 0,
        'selected' => get_query_var( 'tag' ),
        'name' => 'tag',
        'taxonomy' => 'post_tag',
        'value_field' => 'slug',
        ) );
    }
}
add_action( 'restrict_manage_posts', 'add_post_tag_filter' );

/* エディタスタイル */
function on_setup_theme(){
	add_theme_support('editor-styles');
	add_editor_style('assets/css/editor.css');
}
add_action('after_setup_theme', 'on_setup_theme');

/* オプションページ */
if( function_exists('acf_add_options_page') ) {
	// TOP
	acf_add_options_page(array(
		'page_title' => 'TOP',
		'menu_title' => 'TOP',
		'menu_slug' => 'top',
		'capability' => 'edit_posts',
		'redirect' => true,
		'icon_url' => 'dashicons-admin-home',
		'position' => 4
	));
	// おすすめ記事
	acf_add_options_page(array(
		'page_title' => 'おすすめ記事',
		'menu_title' => 'おすすめ記事',
		'menu_slug' => 'recommend',
		'capability' => 'edit_posts',
		'redirect' => true,
		'icon_url' => 'dashicons-edit-page',
		'position' => 4
	));
	// キーワード
	acf_add_options_page(array(
		'page_title' => 'キーワード',
		'menu_title' => 'キーワード',
		'menu_slug' => 'keywords',
		'capability' => 'edit_posts',
		'redirect' => true,
		'icon_url' => 'dashicons-search',
		'position' => 7
	));
	// バナーエリア
	acf_add_options_page(array(
		'page_title' => 'バナーエリア',
		'menu_title' => 'バナーエリア',
		'menu_slug' => 'banner',
		'capability' => 'edit_posts',
		'redirect' => true,
		'icon_url' => 'dashicons-align-left',
		'position' => 8
	));
	// 広告バナー ( TOP )
	acf_add_options_sub_page(array(
	 'page_title' 	=> 'バナー ( TOP )',
	 'menu_slug'	=> 'banner-top',
	 'capability' => 'edit_posts',
	 'parent_slug'	=> 'banner'
 ));
 // 広告バナー ( 記事一覧 )
 acf_add_options_sub_page(array(
	 'page_title' 	=> 'バナー ( 記事一覧 )',
	 'menu_slug'	=> 'banner-list',
	 'capability' => 'edit_posts',
	 'parent_slug'	=> 'banner'
 ));
 // 広告バナー ( 記事詳細 )
 acf_add_options_sub_page(array(
	'page_title' 	=> 'バナー ( 記事詳細 )',
	'menu_slug'	=> 'banner-article',
	'capability' => 'edit_posts',
	'parent_slug'	=> 'banner'
 ));
}
