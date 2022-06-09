<div class="m-side-popular">
	<div class="m-side-popular__ttl">
		<p class="ja">人気記事</p>
		<span class="en">POPULAR</span>
	</div>
	<div class="m-side-popular__list">
		<div class="m-side-popular__chara js-scrollEffect">
			<p class="bubble">積み上げろ！<br>知識と財産</p>
			<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_3.svg" loading="lazy" alt="積み上げろ！知識と財産"></div>
		</div>
		<ul class="list">
<?php
global $util;
$ranking_query = new WPP_Query(array(
'post_type' => 'post',
'post_status' => 'publish',
'range' => 'weekly',
'order_by' => 'views',
'limit' => 10
));
$ranking_posts = $ranking_query->get_posts();
if( $ranking_posts ) :
?>
<?php
$count = 0;
foreach( $ranking_posts as $post ) {
$count++;
echo $util->entry($post->id, false, $count);
}
?>
<?php
endif;
wp_reset_postdata();
?>
		</ul>
	</div>
</div>
