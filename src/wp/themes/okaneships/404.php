<?php
$pageinfo = array(
	'page_id' => 'notfound',
	'navigation' => 'notfound'
);
set_query_var('pageinfo', $pageinfo);
get_header();
?>

<main class="main">
	<section class="m-notfound">
		<div class="m-notfound__container">
			<div class="m-notfound__head">
				<div class="m-notfound__chara js-scrollEffect">
					<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_2.svg" alt="Oops..."></div>
					<p class="bubble">Oops...</p>
				</div>
				<h1 class="m-notfound__ttl">
					<span class="ja">404</span>
					<span class="en">Page Not Found</span>
				</h1>
			</div>
			<p class="m-notfound__lead">指定された URL のページが見つかりません</p>
			<p class="m-notfound__text">誠に申し訳ございませんが、お探しのページが見つかりませんでした。<br>一時的にアクセスができない状況にあるか、移動もしくは削除された可能性があります。<br>トップページにアクセスするか、ブラウザの戻るボタンをご利用ください</p>
			<div class="m-notfound__btn">
				<a href="<?php echo home_url('/'); ?>" class="m-btn">トップページへ戻る</a>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
