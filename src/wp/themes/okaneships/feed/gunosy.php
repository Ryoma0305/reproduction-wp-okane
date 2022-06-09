<?php
// smartnews
if ( !defined( 'ABSPATH' ) ) exit;

$logo_url = get_stylesheet_directory_uri().'/assets/imgs/common/logo-gunosy.png';
$logo_wide_url = get_stylesheet_directory_uri().'/assets/imgs/common/logo-gunosy_wide.png';
$no_image_url = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
$site_domain = home_url().'/';
header( 'Content-Type: ' . feed_content_type( 'rss2' ) . '; charset=' . get_option( 'blog_charset' ), true );
$more = 1;

echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';
/**
* Fires between the xml and rss tags in a feed.
*
* @since 4.0.0
*
* @param string $context Type of feed. Possible values include 'rss2', 'rss2-comments',
* 'rdf', 'atom', and 'atom-comments'.
*/
do_action( 'rss_tag_pre', 'rss2' );
?>
<rss version="2.0"
  xmlns:media="http://search.yahoo.com/mrss/"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:gnf="http://assets.gunosy.com/media/gnf"
  <?php
  /**
   * Fires at the end of the RSS root to add namespaces.
   *
   * @since 2.0.0
   */
  do_action( 'rss2_ns' );
  ?>
>

<channel>
  <title><![CDATA[<?php wp_title_rss(); ?>]]></title>
  <link><?php bloginfo_rss( 'url' ); ?></link>
  <language><?php bloginfo_rss( 'language' ); ?></language>
  <description><?php bloginfo_rss( 'description' ); ?></description>
  <copyright><?php bloginfo_rss('name'); ?> All rights reserved.</copyright>
  <lastBuildDate><?php
    $date = get_lastpostmodified( 'blog' );
    echo $date ? mysql2date( 'r', $date, false ) : date( 'r' );
  ?></lastBuildDate>
  <image>
    <url><?php echo $logo_url; ?></url>
    <title><![CDATA[<?php wp_title_rss(); ?>]]></title>
    <link><?php bloginfo_rss( 'url' ); ?></link>
  </image>
  <gnf:wide_image_link><?php echo $logo_wide_url; ?></gnf:wide_image_link>
  <?php
  /**
   * Fires at the end of the RSS2 Feed Header.
   *
   * @since 2.0.0
   */
  do_action( 'rss2_head' );

  while ( have_posts() ) :
    the_post();
  ?>
  <item>
    <title><![CDATA[<?php the_title_rss(); ?>]]></title>
    <gnf:category>column</gnf:category>
    <?php
    $categories = get_the_category(get_the_ID());
    if( $categories ) :
    $cats = [];
    foreach ($categories as $category) {
      if ( !in_array($category->name, $cats) ) $cats[] = $category->name;
      if ( count($cats) >= 10 ) break;
    }
    ?>
    <gnf:keyword><?php echo implode(',', $cats);?></gnf:keyword>
    <?php endif; ?>
    <description><![CDATA[<?php echo the_excerpt_rss(); ?>]]></description>
    <?php
    // 本文取得
    $content = get_the_content_feed('rss2');
    $content = preg_replace('/<a href="#(.*?)">(.*?)<\/a>/', "<span>$2</span>", $content);
    $content = preg_replace('/<div class="img">.*?<\/div>/', '', $content);
    $content = preg_replace('/<div class="wp-block-talk-unit__img">.*?<\/div>/', '', $content);
    $content = preg_replace('/<div class="name">(.*?)<\/div>/', '$1', $content);
    $content = preg_replace('/<div class="cap">(.*?)<\/div>/', '$1', $content);
    $content = preg_replace('/<div class="wp-block-talk-unit__name">(.*?)<\/div>/', '$1', $content);
    $content = preg_replace('/<div class="wp-block-talk-unit__info">(.*?)<\/div>/', "$1<br>", $content);
    $content = preg_replace('/<div class="wp-block-talk-unit__txt">([\s\S]*?)<\/div>/', '$1', $content);
    $content = preg_replace('/<div class="wp-block-talk-unit(.*?)">([\s\S].*?)<\/div>/', "<p>$2</p>", $content);
    $content = preg_replace('/<iframe class="wp-embedded-content".*?<\/iframe>/', '', $content);
    $content = preg_replace('/<div class="wp-block-profile__img">.*?<\/div>/', '', $content);
    $content = preg_replace('/<div class="wp-block-profile__txt">(.*?)<\/div>/', "<p class='wp-block-profile__txt'>$1</p>", $content);
    $content = preg_replace('/<script.*?<\/script>/', '', $content);

     //アイキャッチの取得
    $image_id = get_post_thumbnail_id();
    $image_url = wp_get_attachment_image_src($image_id, true);
    if (isset($image_url[0])) {
      $thumbnail = $image_url[0];
    } else {
      $thumbnail = $no_image_url;
    }
    ?>
    <content:encoded><![CDATA[
    <img src="<?php echo $thumbnail; ?>" alt="<?php the_title_rss(); ?>">
    <?php echo $content; ?>
    ]]></content:encoded>
    <media:status state="<?php echo get_post_status() == 'publish' ? 'active' : 'deleted'; ?>" />
    <enclosure url="<?php echo $thumbnail; ?>" caption="<?php esc_html(the_title_rss()); ?>" type="image/jpeg" length="0" />
    <link><?php the_permalink_rss(); ?></link>
    <guid><?php the_guid(); ?></guid>
    <pubDate><?php echo mysql2date( 'D, d M Y H:i:s +0900', get_post_time( 'Y-m-d H:i:s', false ), false ); ?></pubDate>
    <gnf:modified><?php echo get_post_modified_time( 'D, d M Y H:i:s +0900', false); ?></gnf:modified>
    <gnf:analytics_gn><![CDATA[<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/ga.js"></script>]]></gnf:analytics_gn>
    <?php
    /**
     * Fires at the end of each RSS2 feed item.
     *
     * @since 2.0.0
     */
    // do_action( 'rss2_item' );
    ?>
  </item>
  <?php endwhile; ?>
</channel>
</rss>
