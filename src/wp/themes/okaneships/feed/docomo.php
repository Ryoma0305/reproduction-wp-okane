<?php
// smartnews
if ( !defined( 'ABSPATH' ) ) exit;

$logo_url = get_stylesheet_directory_uri().'/assets/imgs/common/logo.png';
$dark_logo_url = get_stylesheet_directory_uri().'/assets/imgs/common/logo-dark.png';
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
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:media="http://search.yahoo.com/mrss/"
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:snf="http://www.smartnews.be/snf"
  xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
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
  <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
  <link><?php bloginfo_rss( 'url' ); ?></link>
  <description><?php bloginfo_rss( 'description' ); ?></description>
  <lastBuildDate>
  <?php
    $date = get_lastpostmodified( 'blog' );
    echo $date ? mysql2date( 'r', $date, false ) : date( 'r' );
  ?>
  </lastBuildDate>
  <copyright>© TIME MACHINE Inc. All Rights Reserved</copyright>
  <snf:logo>
      <url><?php echo $logo_url; ?></url>
  </snf:logo>
  <snf:darkModeLogo>
      <url><?php echo $dark_logo_url; ?></url>
  </snf:darkModeLogo>
  <language><?php bloginfo_rss( 'language' ); ?></language>
  <sy:updatePeriod>
  <?php
    $duration = 'hourly';
    /**
     * Filters how often to update the RSS feed.
     *
     * @since 2.1.0
     *
     * @param string $duration The update period. Accepts 'hourly', 'daily', 'weekly', 'monthly',
     * 'yearly'. Default 'hourly'.
     */
    echo apply_filters( 'rss_update_period', $duration );
  ?>
  </sy:updatePeriod>
  <sy:updateFrequency>
  <?php
    $frequency = '1';
    /**
     * Filters the RSS update frequency.
     *
     * @since 2.1.0
     *
     * @param string $frequency An integer passed as a string representing the frequency
     * of RSS updates within the update period. Default '1'.
     */
    echo apply_filters( 'rss_update_frequency', $frequency );
  ?>
  </sy:updateFrequency>
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
    <link><?php the_permalink_rss(); ?></link>
    <pubDate><?php echo mysql2date( 'D, d M Y H:i:s +0900', get_post_time( 'Y-m-d H:i:s', false ), false ); ?></pubDate>
    <?php the_category_rss( 'rss2' ); ?>

    <guid isPermaLink="false"><?php the_guid(); ?></guid>

    <?php if (get_option('rss_use_excerpt')) : ?>
    <description><![CDATA[<?php echo the_excerpt_rss(); ?>]]></description>
    <?php endif; ?>
    <?php
    // 本文取得
    $content = get_the_content_feed('rss2');
    $content = preg_replace('/<a href="#(.*?)">(.*?)<\/a>/', "<span>$2</span>", $content);
    $content = preg_replace('/<div class="img">.*?<\/div>/', '', $content);
    $content = preg_replace('/<div class="wp-block-talk-unit__img">.*?<\/div>/', '', $content);
    $content = preg_replace('/<div class="name">(.*?)<\/div>/', '$1', $content);
    $content = preg_replace('/<div class="cap">(.*?)<\/div>/', '$1', $content);
    $content = preg_replace('/<div class="wp-block-talk-unit__name">(.*?)<\/div>/', '$1', $content);
    $content = preg_replace('/<div class="wp-block-talk-unit__info">(.*?)<\/div>/', "$1<br><br>", $content);
    $content = preg_replace('/<div class="wp-block-talk-unit__txt">([\s\S]*?)<\/div>/', '$1', $content);
    $content = preg_replace('/<div class="wp-block-talk-unit(.*?)">([\s\S].*?)<\/div>/', "<p>$2</p>", $content);
    $content = preg_replace('/<div class="wp-block-profile__img">.*?<\/div>/', '', $content);
    $content = preg_replace('/<div class="wp-block-profile__txt">(.*?)<\/div>/', "<p class='wp-block-profile__txt'>$1</p>", $content);
    $content = preg_replace('/<div class="wp-block-profile">(.*?)<\/div>/', '$1', $content);

     //アイキャッチの取得
    $image_id = get_post_thumbnail_id();
    $image_url = wp_get_attachment_image_src($image_id, true);
    if (isset($image_url[0])) {
      $thumbnail = $image_url[0];
    } else {
      $thumbnail = $no_image_url;
    }
    ?>
    <encoded><![CDATA[
    <img src="<?php echo $thumbnail; ?>" alt="<?php the_title_rss(); ?>">
    <?php echo $content; ?>
    ]]></encoded>
    <?php rss_enclosure(); ?>
    <?php
    /**
     * Fires at the end of each RSS2 feed item.
     *
     * @since 2.0.0
     */
    // do_action( 'rss2_item' );
    ?>
    <enclosure img="<?php echo $thumbnail; ?>" />
<?php
$related_categories = array();
$entry_categories = get_the_terms(get_the_ID(), 'category');
$entry_date = get_the_time('Y-m-d H:i:s');
foreach( $entry_categories as $category ) {
  array_push($related_categories, $category->term_id);
}
$related_args = array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'posts_per_page' => 3,
  'post__not_in' => array(get_the_ID()),
  'date_query' => array(
    array(
      'before' => $entry_date,
      'inclusive' => true
    )
  )
);
if( $related_categories ) {
  $related_args['tax_query'] = array(
    array(
      'taxonomy' => 'category',
      'field' => 'term_id',
      'terms' => $related_categories
    )
  );
}
$related_query = new WP_Query($related_args);
if( $related_query->have_posts() ) :
while( $related_query->have_posts() ) :
$related_query->the_post();
$related_image_id = get_post_thumbnail_id(get_the_ID());
$related_image_url = wp_get_attachment_image_src($related_image_id, true);
if (isset($related_image_url[0])) {
  $related_thumbnail = $related_image_url[0];
} else {
  $related_thumbnail = $no_image_url;
}
?>
  <relatedLink title="<?php the_title_rss(); ?>" link="<?php the_permalink_rss(); ?>" thumbnail="<?php echo $related_thumbnail; ?>" />
<?php
endwhile;
endif;
wp_reset_postdata();
?>
  </item>
  <?php endwhile; ?>
</channel>
</rss>
