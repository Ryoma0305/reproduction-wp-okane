<?php
// smartnews
if ( !defined( 'ABSPATH' ) ) exit;

$logo_url = get_stylesheet_directory_uri().'/assets/imgs/common/logo.png';
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
  xmlns:atom="http://www.w3.org/2005/Atom"
  xmlns:trill="https://trilltrill.jp/rss-module/"
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
  <description><?php bloginfo_rss( 'description' ); ?></description>
  <lastBuildDate>
<?php
$date = get_lastpostmodified( 'blog' );
echo $date ? mysql2date( 'r', $date, false ) : date( 'r' );
?>
  </lastBuildDate>
  <language><?php bloginfo_rss( 'language' ); ?></language>
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
    <guid isPermaLink="false"><?php the_guid(); ?></guid>
    <link><?php the_permalink_rss(); ?></link>
    <title><![CDATA[<?php echo html_entity_decode(get_the_title_rss(),ENT_QUOTES); ?>]]></title>
    <description><?php echo the_excerpt_rss(); ?></description>
    <pubDate><?php echo mysql2date( 'D, d M Y H:i:s +0900', get_post_time( 'Y-m-d H:i:s', false ), false ); ?></pubDate>
    <atom:updated><?php echo mysql2date( 'Y-m-d\TH:i:s\Z', get_post_modified_time( 'Y-m-d H:i:s', false ), false ); ?></atom:updated>
<?php the_category_rss( 'rss2' ); ?>
<?php
// 本文取得
$content = get_the_content_feed('rss2');
$content = preg_replace('/(\r\n|\r|\n|\t)+/us', "", $content);
$content = preg_replace('/<dl class="wp-block-anchorlink">.*?<\/dl>/', '', $content);
$content = preg_replace('/<div class="wp-block-image">(.*?)<\/div>/', '$1', $content);
$content = preg_replace('/<div class="wp-block-button">(.*?)<\/div>/', '<p>$1</p>', $content);
$content = preg_replace('/<div class="wp-block-buttons(.*?)">(.*?)<\/div>/', '$2', $content);
$content = preg_replace('/<div class="img">.*?<\/div>/', '', $content);
$content = preg_replace('/<div class="wp-block-talk-unit__img">.*?<\/div>/', '', $content);
$content = preg_replace('/<div class="name">(.*?)<\/div>/', '$1', $content);
$content = preg_replace('/<div class="cap">(.*?)<\/div>/', '$1', $content);
$content = preg_replace('/<div class="wp-block-talk-unit__name">(.*?)<\/div>/', '$1', $content);
$content = preg_replace('/<div class="wp-block-talk-unit__info">(.*?)<\/div>/', "<p>$1</p>", $content);
$content = preg_replace('/<div class="wp-block-talk-unit__txt">([\s\S].*?)<\/div>/', "<p>$1</p>", $content);
$content = preg_replace('/<div class="wp-block-talk-unit(.*?)">([\s\S].*?)<\/div>/', '$2', $content);
$content = preg_replace('/<div class="wp-block-talk">([\s\S]*?)<\/div>/', '$1', $content);
$content = preg_replace('/<div class="wp-block-table-wrap(.*?)">(.*?)<\/div>/', '', $content);
$content = preg_replace('/<div class="wp-block-profile__img">.*?<\/div>/', '', $content);
$content = preg_replace('/<div class="wp-block-profile__txt">(.*?)<\/div>/', "<p>$1</p>", $content);
$content = preg_replace('/<div class="wp-block-profile">(.*?)<\/div>/', '$1', $content);
$content = preg_replace('/<div class="wp-block-enclosure">([\s\S]*?)<\/div>/', '$1', $content);
$content = preg_replace('/<h3 class="wp-block-enclosure__ttl">([\s\S]*?)<\/h3>/', '<h3>$1</h3>', $content);
$content = preg_replace('/<blockquote class="tiktok-embed([\s\S].*?)<\/blockquote>/', '', $content);
$content = preg_replace('/<script async="" src="https:\/\/www.tiktok.com\/embed.js"><\/script>/', '', $content);
$content = preg_replace('/<figure class="(.*)wp-block-embed-amazon">(.*)<\/figure>/', '', $content);
$content = preg_replace('/<figure.*?class=".*?is-type-wp-embed.*?">.*?<blockquote.*?>(.*?)<\/blockquote>.*?<\/figure>/', '<p>$1</p>', $content);
$content = preg_replace('/<a.*?href="(.*?)".*?>/', '<a href="$1">', $content);
$content = preg_replace('/<sup>(.*?)<\/sup>/', '$1', $content);
$content = preg_replace('/<sub>(.*?)<\/sub>/', '$1', $content);
$content = preg_replace('/<span class="underline">(.*?)<\/span>/', '$1', $content);
preg_match_all('/<blockquote class="wp-block-quote">(.*?)<\/blockquote>/', $content, $matches, PREG_SET_ORDER);
if( $matches ) {
	foreach( $matches as $match ) {
		$blockquote_content = $match[1];
		$blockquote_content = preg_replace('/<p>(.*?)<\/p>/', '$1<br>', $blockquote_content);
		$blockquote_content = preg_replace('/<br>$/', '', $blockquote_content);
		$blockquote_content = preg_replace('/<br><cite/', '<cite', $blockquote_content);
		$blockquote = '<blockquote>'.$blockquote_content.'</blockquote>';
		$content = str_replace($match[0], $blockquote, $content);
	}
}
preg_match_all('/<figure class="wp-block-embed.*?">(.*?)<\/figure>/', $content, $embed_matches, PREG_SET_ORDER);
if( $embed_matches ) {
	foreach( $embed_matches as $match ) {
		$embed_matches_content = $match[1];
		$embed_matches_content = preg_replace('/<div class="wp-block-embed__wrapper">(.*?)<\/div>/', '$1', $embed_matches_content);
		$embed_matches_content = preg_replace('/<iframe(.*?)<\/iframe>/', '<iframe$1</iframe>', $embed_matches_content);
    $embed_matches_content = preg_replace('/<figcaption>.*?<\/figcaption>/', '', $embed_matches_content);
		$embed_matches = $embed_matches_content;
		$content = str_replace($match[0], $embed_matches, $content);
	}
}

//アイキャッチの取得
$image_id = get_post_thumbnail_id();
$image_url = wp_get_attachment_image_src($image_id, true);
if (isset($image_url[0])) {
  $thumbnail = $image_url[0];
} else {
  $thumbnail = $no_image_url;
}
?>
    <trill:image url="<?php echo $thumbnail; ?>">
      <trill:copyright url="<?php the_permalink_rss(); ?>"><![CDATA[<?php wp_title_rss(); ?>]]></trill:copyright>
    </trill:image>
    <content:encoded><![CDATA[
    <figure>
      <img src="<?php echo $thumbnail; ?>" alt="<?php the_title_rss(); ?>">
      <figcaption><?php the_title_rss(); ?></figcaption>
    </figure>
    <?php echo $content; ?>
    ]]></content:encoded>
<?php
/**
 * Fires at the end of each RSS2 feed item.
 *
 * @since 2.0.0
 */
// do_action( 'rss2_item' );
?>
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
if( !$related_query->have_posts() ){
  unset($related_args['tax_query']);
  $related_query = new WP_Query($related_args);
}
if( !$related_query->have_posts() ) {
 unset($related_args['date_query']);
 $related_query = new WP_Query($related_args);
}
if( $related_query->have_posts() ) :
while( $related_query->have_posts() ) :
$related_query->the_post();
?>
    <trill:relatedItem>
      <trill:title><?php the_title_rss(); ?></trill:title>
      <trill:link><?php the_permalink_rss(); ?></trill:link>
    </trill:relatedItem>
<?php
endwhile;
endif;
wp_reset_postdata();
?>
  </item>
  <?php endwhile; ?>
</channel>
</rss>
