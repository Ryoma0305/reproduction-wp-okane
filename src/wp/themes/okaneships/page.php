<?php
global $util;
the_post();
$pageinfo = array(
	'page_id' => 'article page-detail',
	'title' => esc_html(wp_strip_all_tags(get_the_title(), true)).'｜おかねチップス｜お金と仕事のTIPSをサクサク検索',
	'description' => ( has_excerpt() )? get_the_excerpt() : '',
	'navigation' => 'article'
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
					<article class="m-entry">
						<div class="m-entry__head">
							<h1 class="m-entry__ttl"><?php the_title(); ?></h1>
						</div>
						<div class="m-entry__body">
<?php the_content(); ?>
						</div>
						<div class="m-entry__foot">
<?php if( get_field('app_download') ) : ?>
							<div class="m-entry-download js-scrollEffect">
								<div class="m-entry-download__chara">
									<p class="bubble">アプリを<br>ダウンロードしてね！</p>
									<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_4.svg" alt="アプリをダウンロードしてね！"></div>
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
										<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_3.svg" alt="こちらの記事は役に立つはずだよ！"></div>
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
												<div class="item__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title($entry_id), true) ?> loading="lazy""></div>
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
