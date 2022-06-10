<?php
/**************************************************
feed
**************************************************/
// feed追加
add_action('init', function() {
    add_feed('smartnews', function() { get_template_part('/feed/smartnews'); });
    add_feed('gunosy', function() { get_template_part('/feed/gunosy'); });
    add_feed('sony', function() { get_template_part('/feed/sony'); });
    add_feed('docomo', function() { get_template_part('/feed/docomo'); });
    add_feed('trill', function() { get_template_part('/feed/trill'); });
});

// rssにサムネイル追加
function insert_thumbnail_element_to_feed(){
    global $post;
    if ( !has_post_thumbnail($post->ID) ) return;
    $thumbnail_ID = get_post_thumbnail_id($post->ID);
    $thumbnail = wp_get_attachment_image_src($thumbnail_ID, 'large');
    $output = '<imageLink>'.$thumbnail[0].'</imageLink>';
    echo $output;
}
add_action('rss2_item', 'insert_thumbnail_element_to_feed');

// pre_get_posts
add_action('pre_get_posts', function($query) {
    if ( is_admin() ) return $query;
    if ( $query->is_main_query() && $query->is_feed('smartnews') ) {
        //投稿タイプ変更or追加
        $query->set('post_type', ['post', 'any']);
        //削除に対応する場合
        $query->set('post_status', ['publish', 'trash']);
        add_filter( 'wp_img_tag_add_width_and_height_attr', '__return_false' );
    } elseif ( $query->is_main_query() && $query->is_feed('gunosy') ) {
      //投稿タイプ変更or追加
      $query->set('post_type', ['post', 'any']);
      //削除に対応する場合
      $query->set('post_status', ['publish', 'trash']);
      add_filter( 'wp_img_tag_add_width_and_height_attr', '__return_false' );
    } elseif ( $query->is_main_query() && $query->is_feed('docomo') ) {
        //投稿タイプ変更or追加
        $query->set('post_type', ['post', 'any']);
        //削除に対応する場合
        $query->set('post_status', ['publish', 'trash']);
        add_filter( 'wp_img_tag_add_width_and_height_attr', '__return_false' );
      } elseif ( $query->is_main_query() && $query->is_feed('trill') ) {
        //投稿タイプ変更or追加
        $query->set('post_type', ['post', 'any']);
        //削除に対応する場合
        $query->set('post_status', ['publish', 'trash']);
        add_filter( 'wp_img_tag_add_width_and_height_attr', '__return_false' );
      } elseif ( $query->is_main_query() && $query->is_feed('sony') ) {
        //投稿タイプ変更or追加
        $query->set('post_type', ['post', 'any']);
        //削除に対応する場合
        $query->set('post_status', ['publish', 'trash']);
        add_filter( 'wp_img_tag_add_width_and_height_attr', '__return_false' );
      }
    return $query;
});
