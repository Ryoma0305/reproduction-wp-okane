<?php
global $util;
the_post();
$ogimage = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail() ) {
	$ogimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'ogimage')[0];
}

$description = "";
if ($post->post_excerpt) {
// 記事ページでは、記事本文から抜粋を取得
$description = $post->post_excerpt;
} else {
// post_excerpt で取れない時は、自力で記事の冒頭100文字を抜粋して取得
$description = strip_tags($post->post_content);
$description = str_replace("\n", "", $description);
$description = str_replace("\r", "", $description);
$description = mb_substr($description, 0, 120) . "...";
}

$pageinfo = array(
	'page_id' => 'article page-detail',
	'title' => esc_html(wp_strip_all_tags(get_the_title(), true)).'｜おかねチップス｜お金と仕事のTIPSをサクサク検索',
	'description' => $description,
	'navigation' => 'article',
	'image' => array(
		'src' => $ogimage,
		'width' => 1200,
		'height' => 630
	)
);
set_query_var('pageinfo', $pageinfo);
get_header();
if( !is_preview() ) {
	$util->set_total_post_views(get_the_ID());
}
?>
<main class="main">
	<div class="m-container">
		<div class="m-main">
			<section class="m-article-detail">
				<div class="m-article-detail__container">
					<div class="m-entry-sns js-scrollEffect">
						<div class="m-entry-sns__list">
							<a class="facebook" href="<?php echo $util->share('facebook', get_the_ID()); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/facebook.png" alt="facebook" loading="lazy"></a>
							<a class="twitter" href="<?php echo $util->share('twitter', get_the_ID()); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/twitter.png" alt="twitter" loading="lazy"></a>
							<a class="line" href="<?php echo $util->share('line', get_the_ID()); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/line.png" alt="line" loading="lazy"></a>
							<a class="hatena" href="<?php echo $util->share('hatena', get_the_ID()); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/hatena.png" alt="hatena" loading="lazy"></a>
						</div>
						<div class="m-entry-sns__chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_3.svg" loading="lazy"></div>
					</div>
					<article class="m-entry">
						<div class="m-entry__head">
							<div class="m-entry__meta">
<?php
$entry_categories = get_the_category(get_the_ID());
if( $entry_categories ) :
?>
								<ul class="m-entry__cat">
<?php foreach( $entry_categories as $category ) : ?>
									<li><?php echo esc_html($category->name); ?></li>
<?php endforeach; ?>
								</ul>
<?php endif; ?>
								<div class="m-entry__date">
									<p class="m-entry__update"><?php the_modified_time('Y.m.d'); ?></p>
									<p class="m-entry__release">公開日：<?php the_time('Y.m.d'); ?></p>
								</div>
							</div>
							<h1 class="m-entry__ttl"><?php the_title(); ?></h1>
<?php
$entry_tags = get_the_tags(get_the_ID());
if( $entry_tags ) :
?>
							<p class="m-entry__corner">
<?php foreach( $entry_tags as $tag ) : ?>
								<span><?php echo esc_html($tag->name); ?></span>
<?php endforeach; ?>
							</p>
<?php endif; ?>
						</div>
<?php
$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail() ) {
	$src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0];
}
?>
						<div class="m-entry__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title(), true); ?>" loading="lazy"></div>
						<div class="m-entry__body">
<?php the_content(); ?>
						</div>
						<div class="m-entry__foot">
							<div class="m-entry-share js-scrollEffect">
								<div class="m-entry-share__chara">
									<p class="bubble">知識を皆に<br>シェアしよう！</p>
									<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_3.svg" alt="知識を皆にシェアしよう！" loading="lazy"></div>
								</div>
								<div class="m-entry-share__inner">
									<div class="m-entry-share__head">
<?php
$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail() ) {
	$src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'ogimage')[0];
}
?>
										<div class="m-entry-share__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title(), true) ?>" loading="lazy"></div>
										<div class="m-entry-share__text">
											<p class="m-entry-share__ttl"><?php the_title(); ?></p>
	<?php if( $entry_tags ) : ?>
											<p class="m-entry-share__corner">
	<?php foreach( $entry_tags as $tag ) : ?>
												<span><?php echo esc_html($tag->name); ?></span>
	<?php endforeach; ?>
											</p>
	<?php endif; ?>
										</div>
									</div>
									<div class="m-entry-share__link">
										<p class="ttl">この記事のシェアをする</p>
										<ul class="list">
											<li class="facebook"><a href="<?php echo $util->share('facebook', get_the_ID()); ?>" target="_blank"></a></li>
											<li class="twitter"><a href="<?php echo $util->share('twitter', get_the_ID()); ?>" target="_blank"></a></li>
											<li class="line"><a href="<?php echo $util->share('line', get_the_ID()); ?>" target="_blank"></a></li>
											<li class="hatena"><a href="<?php echo $util->share('hatena', get_the_ID()); ?>" target="_blank"></a></li>
											<li class="copy"><a class="clipboard" href="<?php the_permalink(); ?>"><span class="inner"><span class="before">リンクをコピーする</span><span class="after">コピーしました</span></span></a></li>
										</ul>
									</div>
								</div>
							</div>
							<ol class="m-entry-breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
								<li itemprop="itemListElement" itemscope
										itemtype="https://schema.org/ListItem">
									<a itemscope itemtype="https://schema.org/WebPage"
										itemid="<?php echo home_url('/'); ?>"
										itemprop="item" href="<?php echo home_url('/'); ?>">
											<span itemprop="name">Top</span></a>
									<meta itemprop="position" content="1" />
								</li>
<?php
if( $entry_categories ) :
$breadcrumb = $entry_categories[0];
?>
								<li itemprop="itemListElement" itemscope
										itemtype="https://schema.org/ListItem">
									<a itemscope itemtype="https://schema.org/WebPage"
										 itemprop="item" itemid="<?php echo get_term_link($breadcrumb); ?>"
										 href="<?php echo get_term_link($breadcrumb); ?>">
										<span itemprop="name"><?php echo esc_html($breadcrumb->name); ?></span></a>
									<meta itemprop="position" content="2" />
								</li>
<?php endif; ?>
								<li itemprop="itemListElement" itemscope
										itemtype="https://schema.org/ListItem">
									<span itemscope itemtype="https://schema.org/WebPage"
												itemprop="item" itemid="<?php the_permalink(); ?>">
										<span itemprop="name"><?php echo wp_strip_all_tags(get_the_title(), true); ?></span>
									</span>
									<meta itemprop="position" content="<?php echo $entry_categories ? '3':'2'; ?>" />
								</li>
							</ol>
							<div class="m-entry-index">
								<div class="m-entry-index__inner">
<?php
$next_post = get_next_post();
if( $next_post ) :
$next_post_id = $next_post->ID;
?>
									<a href="<?php echo get_permalink($next_post_id); ?>" class="item prev">
										<p class="cap">前の記事</p>
<?php
$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail($next_post_id) ) {
	$src = wp_get_attachment_image_src(get_post_thumbnail_id($next_post_id), 'large')[0];
}
?>
										<div class="item__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title($next_post_id), true); ?>" loading="lazy"></div>
										<p class="item__ttl"><?php echo get_the_title($next_post_id); ?></p>
<?php
$next_tags = get_the_tags($next_post_id);
if( $next_tags ) :
?>
										<p class="item__corner">
<?php foreach( $next_tags as $tag ) : ?>
								<span><?php echo esc_html($tag->name); ?></span>
<?php endforeach; ?>
										</p>
<?php endif; ?>
									</a>
<?php endif; ?>
<?php
$prev_post = get_previous_post();
if( $prev_post ) :
$prev_post_id = $prev_post->ID;
?>
									<a href="<?php echo get_permalink($prev_post_id); ?>" class="item next">
										<p class="cap">次の記事</p>
<?php
$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail($prev_post_id) ) {
	$src = wp_get_attachment_image_src(get_post_thumbnail_id($prev_post_id), 'large')[0];
}
?>
										<div class="item__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title($prev_post_id), true); ?>" loading="lazy"></div>
										<p class="item__ttl"><?php echo get_the_title($prev_post_id); ?></p>
<?php
$prev_tags = get_the_tags($prev_post_id);
if( $prev_tags ) :
?>
										<p class="item__corner">
<?php foreach( $prev_tags as $tag ) : ?>
								<span><?php echo esc_html($tag->name); ?></span>
<?php endforeach; ?>
										</p>
<?php endif; ?>
									</a>
<?php endif; ?>
									<a href="<?php echo get_permalink(get_page_by_path('list')->ID); ?>" class="item back">記事一覧に戻る</a>
								</div>
							</div>
<?php if( have_rows('entry_member') ) : ?>
							<div class="m-entry-author js-scrollEffect">
								<p class="m-entry-author__ttl">この記事を書いたメンバー</p>
								<div class="m-entry-author__chara">
									<p class="bubble">役に立つ記事<br>ありがとう！！</p>
									<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_4.svg" alt="役に立つ記事ありがとう！！" loading="lazy"></div>
								</div>
								<ul class="m-entry-author__list">
<?php
while( have_rows('entry_member') ) :
the_row();
$user_thumb = get_stylesheet_directory_uri().'/assets/imgs/common/author.jpg';
$user_name = '';
$user_name_en = '';
$user_company = '';
$user_profile = '';
$user_link = '';
if( get_sub_field('is_wp') && get_sub_field('user') ) {
	$user_id = get_sub_field('user');
	if( get_field('user_image', 'user_'.$user_id) ) {
		$user_thumb_obj = get_field('user_image', 'user_'.$user_id);
		$user_thumb = $user_thumb_obj['sizes']['user_image'];
	}
	if( get_field('user_name', 'user_'.$user_id) ) {
		$user_name = get_field('user_name', 'user_'.$user_id);
	}
	if( get_field('user_name_en', 'user_'.$user_id) ) {
		$user_name_en = get_field('user_name_en', 'user_'.$user_id);
	}
	if( get_field('user_company', 'user_'.$user_id) ) {
		$user_company = get_field('user_company', 'user_'.$user_id);
	}
	if( get_field('user_profile', 'user_'.$user_id) ) {
		$user_profile = get_field('user_profile', 'user_'.$user_id);
	}
	$user_link = get_author_posts_url($user_id);
} else {
	$guest = get_sub_field('guest');
	if( $guest['image'] ) {
		$user_thumb = $guest['image']['sizes']['user_image'];
	}
	if( $guest['text']['name'] ) {
		$user_name = $guest['text']['name'];
	}
	if( $guest['text']['name_en'] ) {
		$user_name_en = $guest['text']['name_en'];
	}
	if( $guest['text']['company'] ) {
		$user_company = $guest['text']['company'];
	}
	if( $guest['text']['profile'] ) {
		$user_profile = $guest['text']['profile'];
	}
}
?>
<?php if( $user_name ) : ?>
									<li class="item">
										<div class="item__img"><img src="<?php echo $user_thumb; ?>" alt="<?php echo wp_strip_all_tags($user_name, true); ?>" loading="lazy"></div>
										<div class="item__info">
											<p class="item__name"><span class="ja"><?php echo esc_html($user_name); ?></span><?php if( $user_name_en ) : ?><span class="en"><?php echo esc_html($user_name_en); ?></span><?php endif; ?></p>
<?php if( $user_company ) : ?>
											<p class="item__post"><?php echo esc_html($user_company); ?></p>
<?php endif; ?>
<?php if( $user_profile ) : ?>
											<p class="item__txt"><?php echo $user_profile; ?></p>
<?php endif; ?>
<?php if( $user_link ) : ?>
											<a href="<?php echo $user_link; ?>" class="item__btn">このライターの記事を読む</a>
<?php endif; ?>
										</div>
									</li>
<?php endif; ?>
<?php endwhile; ?>
								</ul>
							</div>
<?php endif; ?>
<?php if( get_field('app_download') ) : ?>
							<div class="m-entry-download js-scrollEffect">
								<div class="m-entry-download__chara">
									<p class="bubble">アプリを<br>ダウンロードしてね！</p>
									<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_4.svg" alt="アプリをダウンロードしてね！" loading="lazy"></div>
								</div>
								<div class="m-entry-download__head">
									<div class="m-entry-download__logo"></div>
									<div class="m-entry-download__download">
										<div class="m-entry-download__qr"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/article/entry-qr.jpg" alt="QR" loading="lazy"></div>
										<div class="m-entry-download__store"><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/article/entry-store.png" alt="App Store" loading="lazy"></a></div>
									</div>
								</div>
								<div class="m-entry-download__info">
									<p class="m-entry-download__lead">「名刺 DE 請求」についてもっと<br>知りたい方はこちら</p>
									<a href="#" class="m-entry-download__btn yellow">名刺 DE 請求の機能一覧</a>
									<a href="#" target="_blank" class="m-entry-download__btn blank"><span>名刺 DE 請求とは</span></a>
								</div>
							</div>
<?php endif; ?>
<?php
$article_banner = get_field('article_banner_one', 'option');
if( $article_banner['pc_type'] == 'ad' && $article_banner['pc_ad'] ) :
?>
							<div class="m-banner size-l m-entry-banner tbsp-hidden">
								<div class="m-banner__inner">
<?php echo $article_banner['pc_ad']; ?>
								</div>
							</div>
<?php elseif( $article_banner['pc_type'] == 'banner' && $article_banner['pc_img'] && $article_banner['pc_link'] ) : ?>
							<div class="m-banner size-l m-entry-banner tbsp-hidden">
								<div class="m-banner__inner">
									<a href="<?php echo $article_banner['pc_link']; ?>" target="_blank">
										<img src="<?php echo $article_banner['pc_img']['sizes']['banner-l']; ?>" loading="lazy">
									</a>
								</div>
							</div>
<?php endif; ?>
<?php
$article_banner_list = get_field('article_banner_list', 'option');
if( $article_banner_list['pc_item'] ) :
?>
							<div class="m-banner size-l m-entry-banner tbsp-hidden">
								<div class="m-banner__inner">
									<ul class="m-banner__list">
<?php foreach( $article_banner_list['pc_item'] as $article_banner_pc_item ) : ?>
<?php if( $article_banner_pc_item['item_ad'] ) : ?>
										<li class="m-banner__item">
<?php echo $article_banner_pc_item['item_ad']; ?>
										</li>
<?php elseif( $article_banner_pc_item['item_img'] && $article_banner_pc_item['item_link'] ) : ?>
										<li class="m-banner__item">
											<a href="<?php echo $article_banner_pc_item['item_link']; ?>" target="_blank">
												<img src="<?php echo $article_banner_pc_item['item_img']['sizes']['banner-s']; ?>" loading="lazy">
											</a>
										</li>
<?php endif; ?>
<?php endforeach; ?>
									</ul>
								</div>
							</div>
<?php endif; ?>
<?php if( $article_banner['sp_type'] == 'ad' && $article_banner['sp_ad'] ) : ?>
							<div class="m-banner size-l m-entry-banner pc-hidden">
								<div class="m-banner__inner">
<?php echo $article_banner['sp_ad']; ?>
								</div>
							</div>
<?php elseif( $article_banner['sp_type'] == 'banner' && $article_banner['sp_img'] && $article_banner['sp_link'] ) : ?>
							<div class="m-banner size-l m-entry-banner pc-hidden">
								<div class="m-banner__inner">
									<a href="<?php echo $article_banner['sp_link']; ?>" target="_blank">
										<img src="<?php echo $article_banner['sp_img']['sizes']['banner-l']; ?>" loading="lazy">
									</a>
								</div>
							</div>
<?php endif; ?>
<?php if( $article_banner_list['sp_item'] ) : ?>
							<div class="m-banner size-l m-entry-banner pc-hidden">
								<div class="m-banner__inner">
									<ul class="m-banner__list">
<?php foreach( $article_banner_list['sp_item'] as $article_banner_sp_item ) : ?>
<?php if( $article_banner_sp_item['item_ad'] ) : ?>
										<li class="m-banner__item">
<?php echo $article_banner_sp_item['item_ad']; ?>
										</li>
<?php elseif( $article_banner_sp_item['item_img'] && $article_banner_sp_item['item_link'] ) : ?>
										<li class="m-banner__item">
											<a href="<?php echo $article_banner_sp_item['item_link']; ?>" target="_blank">
												<img src="<?php echo $article_banner_sp_item['item_img']['sizes']['banner-s']; ?>" loading="lazy">
											</a>
										</li>
<?php endif; ?>
<?php endforeach; ?>
									</ul>
								</div>
							</div>
<?php endif; ?>
							<div class="m-entry__foot__inner">
								<div class="m-entry-recommend js-scrollEffect">
									<div class="m-entry-recommend__chara">
										<p class="bubble">こちらの記事は<br>役に立つはずだよ！</p>
										<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_3.svg" alt="こちらの記事は役に立つはずだよ！" loading="lazy"></div>
									</div>
									<p class="m-entry-recommend__ttl">編集部のおすすめ記事</p>
									<ul class="m-entry-recommend__list">
<?php
$recommend = get_field('recommend', 'option');
if( $recommend ) :
foreach( $recommend as $entry_id ) :
?>
										<li class="item">
											<a href="<?php echo get_permalink($entry_id); ?>" class="item__link">
<?php
$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail($entry_id) ) {
	$src = wp_get_attachment_image_src(get_post_thumbnail_id($entry_id), 'large')[0];
}
?>
												<div class="item__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title($entry_id), true) ?>" loading="lazy"></div>
												<p class="item__ttl"><?php echo get_the_title($entry_id); ?></p>
<?php
$entry_tags = get_the_tags($entry_id);
if( $entry_tags ) :
?>
												<p class="item__corner">
<?php foreach( $entry_tags as $tag ) : ?>
													<span><?php echo esc_html($tag->name); ?></span>
<?php endforeach; ?>
												</p>
<?php endif; ?>
												<div class="item__meta">
<?php
$entry_categories = get_the_category($entry_id);
if( $entry_categories ) :
?>
													<ul class="item__cat">
<?php foreach( $entry_categories as $category ) : ?>
														<li><?php echo esc_html($category->name); ?></li>
<?php endforeach; ?>
													</ul>
<?php endif; ?>
													<p class="item__date"><?php echo get_the_time('Y.m.d', $entry_id); ?></p>
												</div>
											</a>
										</li>
<?php
endforeach;
endif;
?>
									</ul>
								</div>
								<div class="m-entry-article">
									<p class="m-entry-article__ttl">新着記事</p>
									<ul class="m-entry-article__list">
<?php
$recent_query = new WP_Query(array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 4,
	'post__not_in' => array(get_the_ID()),
	'ignore_sticky_posts' => true
));
if( $recent_query->have_posts() ) :
while( $recent_query->have_posts() ) :
$recent_query->the_post();
?>
										<li class="item">
											<a href="<?php the_permalink(); ?>" class="item__link">
<?php
$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail() ) {
	$src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0];
}
?>
												<div class="item__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title(), true) ?>" loading="lazy"></div>
												<p class="item__date"><?php the_time('Y.m.d'); ?></p>
												<p class="item__ttl"><?php the_title(); ?></p>
<?php
$entry_tags = get_the_tags(get_the_ID());
if( $entry_tags ) :
?>
												<p class="item__corner">
<?php foreach( $entry_tags as $tag ) : ?>
													<span><?php echo esc_html($tag->name); ?></span>
<?php endforeach; ?>
												</p>
<?php endif; ?>
												<div class="item__meta">
<?php
$entry_categories = get_the_category(get_the_ID());
if( $entry_categories ) :
?>
													<ul class="item__cat">
<?php foreach( $entry_categories as $category ) : ?>
														<li><?php echo esc_html($category->name); ?></li>
<?php endforeach; ?>
													</ul>
<?php endif; ?>
													<p class="item__date"><?php the_time('Y.m.d'); ?></p>
												</div>
											</a>
										</li>
<?php
endwhile;
endif;
wp_reset_postdata();
?>
									</ul>
								</div>
							</div>
						</div>
					</article>
				</div>
			</section>
		</div>
		<div class="m-side">
			<div class="m-side__wrapper">
				<div class="m-side__inner">
<?php
$article_side_top = get_field('article_side_top', 'option');
if( $article_side_top['pc_type'] == 'ad' && $article_side_top['pc_ad'] ) :
?>
					<div class="m-side-banner tbsp-hidden">
<?php echo $article_side_top['pc_ad']; ?>
					</div>
<?php elseif( $article_side_top['pc_type'] == 'banner' && $article_side_top['pc_img'] && $article_side_top['pc_link'] ) : ?>
					<div class="m-side-banner tbsp-hidden">
						<a href="<?php echo $article_side_top['pc_link']; ?>" target="_blank"><img src="<?php echo $article_side_top['pc_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
					</div>
<?php endif; ?>
<?php if( $article_side_top['sp_type'] == 'ad' && $article_side_top['sp_ad'] ) : ?>
					<div class="m-side-banner pc-hidden">
<?php echo $article_side_top['sp_ad']; ?>
					</div>
<?php elseif( $article_side_top['sp_type'] == 'banner' && $article_side_top['sp_img'] && $article_side_top['sp_link'] ) : ?>
					<div class="m-side-banner pc-hidden">
						<a href="<?php echo $article_side_top['sp_link']; ?>" target="_blank"><img src="<?php echo $article_side_top['sp_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
					</div>
<?php endif; ?>
<?php get_template_part('modules/side', 'search'); ?>
<?php get_template_part('modules/side', 'category'); ?>
<?php get_template_part('modules/side', 'ranking'); ?>
<?php
$article_side_bottom = get_field('article_side_bottom', 'option');
if( $article_side_bottom['pc_item'] ) :
?>
					<div class="m-side--fixed">
						<div class="m-side--fixed__inner">
<?php foreach( $article_side_bottom['pc_item'] as $article_side_bottom_pc_item ) : ?>
<?php if( $article_side_bottom_pc_item['item_ad'] ) : ?>
							<div class="m-side-banner tbsp-hidden">
<?php echo $article_side_bottom_pc_item['item_ad']; ?>
							</div>
<?php elseif( $article_side_bottom_pc_item['item_img'] && $article_side_bottom_pc_item['item_link'] ) : ?>
							<div class="m-side-banner tbsp-hidden">
								<a href="<?php echo $article_side_bottom_pc_item['item_link']; ?>" target="_blank"><img src="<?php echo $article_side_bottom_pc_item['item_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
							</div>
<?php endif; ?>
<?php endforeach; ?>
						</div>
					</div>
<?php endif; ?>
<?php
if( $article_side_bottom['sp_item'] ) :
foreach( $article_side_bottom['sp_item'] as $article_side_bottom_sp_item ) :
?>
<?php if( $article_side_bottom_sp_item['item_ad'] ) : ?>
					<div class="m-side-banner pc-hidden">
<?php echo $article_side_bottom_sp_item['item_ad']; ?>
					</div>
<?php elseif( $article_side_bottom_sp_item['item_img'] && $article_side_bottom_sp_item['item_link'] ) : ?>
					<div class="m-side-banner pc-hidden">
						<a href="<?php echo $article_side_bottom_sp_item['item_link']; ?>" target="_blank"><img src="<?php echo $article_side_bottom_sp_item['item_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
					</div>
<?php endif; ?>
<?php
endforeach;
endif;
?>
				</div>
			</div>
		</div>
	</div>
<?php get_template_part('modules/research'); ?>
</main>
<?php get_footer(); ?>
