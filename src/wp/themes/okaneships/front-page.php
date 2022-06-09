<?php
global $util;
$pageinfo = array(
	'page_id' => 'top',
	'navigation' => 'top'
);
set_query_var('pageinfo', $pageinfo);
get_header();
?>

<main class="main">
	<div class="fv">
		<div class="fv__inner">
			<div class="fv__lead"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/top/fv-lead.svg" alt="お金と仕事のTIPSをサクサク検索"></div>
			<div class="fv-article">
				<div class="fv-article__ttl"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/top/fv-ttl.png" alt="PICK UP"></div>
				<div class="fv-article__slider">
<?php
$pickup = get_field('top_pickup', 'option');
if( $pickup ) :
foreach( $pickup as $pickup_id ) :
?>
					<div class="item">
						<a href="<?php echo get_permalink($pickup_id); ?>" class="item__link">
<?php
$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail($pickup_id) ) {
	$src = wp_get_attachment_image_src(get_post_thumbnail_id($pickup_id), 'large')[0];
}
?>
							<div class="item__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title($pickup_id), true) ?>"></div>
							<p class="item__ttl"><?php echo get_the_title($pickup_id); ?></p>
<?php
$pickup_tags = get_the_tags($pickup_id);
if( $pickup_tags ) :
?>
							<p class="item__corner">
<?php foreach( $pickup_tags as $tag ) : ?>
								<span><?php echo esc_html($tag->name); ?></span>
<?php endforeach; ?>
							</p>
<?php endif; ?>
<?php
$pickup_categories = get_the_category($pickup_id);
if( $pickup_categories ) :
?>
							<ul class="item__cat">
<?php foreach( $pickup_categories as $category ) : ?>
								<li><?php echo esc_html($category->name); ?></li>
<?php endforeach; ?>
							</ul>
<?php endif; ?>
						</a>
					</div>
<?php
endforeach;
endif;
?>
				</div>
				<div class="fv-article__slider__left fv-article__clickarea"></div>
				<div class="fv-article__slider__right fv-article__clickarea"></div>
				<div class="fv-article__nav"></div>
			</div>
		</div>
		<div class="fv-article__slider__prev is-hidden"></div>
		<div class="fv-article__slider__next is-hidden"></div>
		<a href="#container" class="fv__scroll ss"><span>SCROLL</span></a>
	</div>
<?php
$fv_banner = get_field('fv_banner', 'option');
if( $fv_banner['pc_type'] == 'ad' && $fv_banner['pc_ad'] ) :
?>
	<div class="m-banner size-m m-banner--1 tbsp-hidden">
		<div class="m-banner__inner">
<?php echo $fv_banner['pc_ad'];  ?>
		</div>
	</div>
<?php elseif( $fv_banner['pc_type'] == 'banner' && $fv_banner['pc_img'] && $fv_banner['pc_link'] ) : ?>
	<div class="m-banner size-m m-banner--1 tbsp-hidden">
		<div class="m-banner__inner">
			<a href="<?php echo $fv_banner['pc_link']; ?>" target="_blank">
				<img src="<?php echo $fv_banner['pc_img']['sizes']['banner-m']; ?>" loading="lazy">
			</a>
		</div>
	</div>
<?php endif; ?>
<?php if( $fv_banner['sp_type'] == 'ad' && $fv_banner['sp_ad'] ) : ?>
	<div class="m-banner size-m m-banner--1 pc-hidden">
		<div class="m-banner__inner">
<?php echo $fv_banner['sp_ad']; ?>
		</div>
	</div>
<?php elseif( $fv_banner['sp_type'] == 'banner' && $fv_banner['sp_img'] && $fv_banner['sp_link'] ) : ?>
	<div class="m-banner size-m m-banner--1 pc-hidden">
		<div class="m-banner__inner">
			<a href="<?php echo $fv_banner['sp_link']; ?>" target="_blank">
				<img src="<?php echo $fv_banner['sp_img']['sizes']['banner-m']; ?>" loading="lazy">
			</a>
		</div>
	</div>
<?php endif; ?>
	<div class="top-container" id="container">
		<div class="m-main">
			<section class="top-section top-recommend js-scrollEffect">
				<div class="top-section__container js-scrollEffect__group">
					<h2 class="top-section__ttl">
						<span class="ja">編集部の<br>おすすめ記事</span>
						<span class="en">RECOMMEND</span>
					</h2>
					<div class="top-section__body">
						<div class="top-recommend__text">
							<p class="top-recommend__lead">個人事業主、フリーランス、経営者、起業家、会社員……。いろいろな働き方があるけれど、ポジティブに仕事に取り組む人の不安や悩みはつきないもの。そんなみなさんが抱えるお悩みにきっと役立つ、おすすめの記事をまとめました。</p>
							<div class="top-recommend__inner">
								<div class="top-recommend__chara--1">
									<p class="bubble">皆さんは<br>こんなお悩み<br>ありますか？</p>
									<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_2.svg" alt="皆さんはこんなお悩みありますか？"></div>
								</div>
								<ul class="top-recommend__intro">
									<li>仕事と上手に向き合う方法がわからない……</li>
									<li>自分の制作物や稼働に対する価格設定が悩ましい</li>
									<li>仕事やお金まわりで生じたトラブルの乗り越え方や、<br>各業界における課題の解決方法を知りたい</li>
								</ul>
							</div>
						</div>
						<div class="top-recommend__list">
							<div class="top-recommend__chara--2">
								<p class="bubble">こちらの記事は<br>役に立つはずだよ！</p>
								<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_3.svg" alt="こちらの記事は役に立つはずだよ！"></div>
							</div>
							<ul class="list">
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
					</div>
				</div>
			</section>
<?php
$recommend_banner = get_field('top_recommend_banner', 'option');
if( $recommend_banner['pc_type'] == 'ad' && $recommend_banner['pc_ad'] ) :
?>
	<div class="m-banner size-l right m-banner--2 tbsp-hidden">
		<div class="m-banner__inner">
<?php echo $recommend_banner['pc_ad']; ?>
		</div>
	</div>
<?php elseif( $recommend_banner['pc_type'] == 'banner' && $recommend_banner['pc_img'] && $recommend_banner['pc_link'] ) : ?>
	<div class="m-banner size-l right m-banner--2 tbsp-hidden">
		<div class="m-banner__inner">
			<a href="<?php echo $recommend_banner['pc_link']; ?>" target="_blank">
				<img src="<?php echo $recommend_banner['pc_img']['sizes']['banner-l']; ?>" loading="lazy">
			</a>
		</div>
	</div>
<?php endif; ?>
<?php if( $recommend_banner['sp_type'] == 'ad' && $recommend_banner['sp_ad'] ) : ?>
	<div class="m-banner size-l right m-banner--2 pc-hidden">
		<div class="m-banner__inner">
<?php echo $recommend_banner['sp_ad']; ?>
		</div>
	</div>
<?php elseif( $recommend_banner['sp_type'] == 'banner' && $recommend_banner['sp_img'] && $recommend_banner['sp_link'] ) : ?>
	<div class="m-banner size-l right m-banner--2 pc-hidden">
		<div class="m-banner__inner">
			<a href="<?php echo $recommend_banner['sp_link']; ?>" target="_blank">
				<img src="<?php echo $recommend_banner['sp_img']['sizes']['banner-l']; ?>" loading="lazy">
			</a>
		</div>
	</div>
<?php endif; ?>
<?php
$new_query = new WP_Query(array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 9,
	'meta_key' => 'top_view',
	'meta_value' => '1',
	'ignore_sticky_posts' => true
));
if( $new_query->have_posts() ) :
?>
			<section class="top-section top-article js-scrollEffect">
				<div class="top-section__container">
					<div class="top-article__head">
						<h2 class="top-section__ttl">
							<span class="ja">新着記事</span>
							<span class="en">NEW ARTICLE</span>
						</h2>
						<div class="top-article__chara">
							<p class="bubble">片手で<br>サクサク</p>
							<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_4.svg" alt="片手でサクサク"></div>
						</div>
					</div>
					<div class="top-section__body">
						<ul class="top-article__list">
<?php
$count = 0;
while( $new_query->have_posts() ) : $new_query->the_post();
$count++;
?>
							<li class="item<?php if( $count < 6 ) echo ' new'; ?>">
								<a href="<?php the_permalink(); ?>" class="item__link">
<?php
$src = get_stylesheet_directory_uri().'/assets/imgs/common/thumbnail.jpg';
if( has_post_thumbnail() ) {
	$src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large')[0];
}
?>
									<div class="item__img"><img src="<?php echo $src; ?>" alt="<?php echo wp_strip_all_tags(get_the_title(), true); ?>" loading="lazy"></div>
									<p class="item__date"><?php the_time('Y.m.d'); ?></p>
									<p class="item__ttl"><?php the_title(); ?></p>
<?php
$new_tags = get_the_tags(get_the_ID());
if( $new_tags ) :
?>
									<p class="item__corner">
<?php foreach( $new_tags as $tag ) : ?>
										<span><?php echo esc_html($tag->name); ?></span>
<?php endforeach; ?>
									</p>
<?php endif; ?>
									<div class="item__meta">
<?php
$new_categories = get_the_category(get_the_ID());
if( $new_categories ) :
?>
										<ul class="item__cat">
<?php foreach( $new_categories as $category ) : ?>
											<li><?php echo esc_html($category->name); ?></li>
<?php endforeach; ?>
										</ul>
<?php endif; ?>
										<p class="item__date"><?php the_time('Y.m.d'); ?></p>
									</div>
								</a>
							</li>
<?php endwhile; ?>
						</ul>
						<div class="top-article__btn"><a href="<?php echo get_permalink(get_page_by_path('list')->ID); ?>" class="m-btn">記事一覧はこちら</a></div>
					</div>
				</div>
			</section>
<?php
endif;
wp_reset_postdata();
?>
<?php
$top_new_banner = get_field('top_new_banner', 'option');
if( $top_new_banner['pc_type'] == 'ad' && $top_new_banner['pc_ad'] ) :
?>
			<div class="m-banner size-l right m-banner--3 tbsp-hidden">
				<div class="m-banner__inner">
<?php echo $top_new_banner['pc_ad']; ?>
				</div>
			</div>
<?php elseif( $top_new_banner['pc_type'] == 'banner' && $top_new_banner['pc_img'] && $top_new_banner['pc_link'] ) : ?>
			<div class="m-banner size-l right m-banner--3 tbsp-hidden">
				<div class="m-banner__inner">
					<a href="<?php echo $top_new_banner['pc_link']; ?>" target="_blank">
						<img src="<?php echo $top_new_banner['pc_img']['sizes']['banner-l']; ?>" loading="lazy">
					</a>
				</div>
			</div>
<?php endif; ?>
<?php
$top_new_banner_list = get_field('top_new_banner_list', 'option');
if( $top_new_banner_list['pc_item'] ) :
?>
			<div class="m-banner size-l right m-banner--4 tbsp-hidden">
				<div class="m-banner__inner">
					<ul class="m-banner__list">
<?php foreach( $top_new_banner_list['pc_item'] as $top_new_banner_pc_item ) : ?>
<?php if( $top_new_banner_pc_item['item_ad'] ) : ?>
						<li class="m-banner__item">
<?php echo $top_new_banner_pc_item['item_ad']; ?>
						</li>
<?php elseif( $top_new_banner_pc_item['item_img'] && $top_new_banner_pc_item['item_link'] ) : ?>
						<li class="m-banner__item">
							<a href="<?php echo $top_new_banner_pc_item['item_link']; ?>" target="_blank">
								<img src="<?php echo $top_new_banner_pc_item['item_img']['sizes']['banner-s']; ?>" loading="lazy">
							</a>
						</li>
<?php endif; ?>
<?php endforeach; ?>
					</ul>
				</div>
			</div>
<?php endif; ?>
<?php
if( $top_new_banner['sp_type'] == 'ad' && $top_new_banner['sp_ad'] ) :
?>
			<div class="m-banner size-l right m-banner--3 pc-hidden">
				<div class="m-banner__inner">
<?php echo $top_new_banner['sp_ad']; ?>
				</div>
			</div>
<?php elseif( $top_new_banner['sp_type'] == 'banner' && $top_new_banner['sp_img'] && $top_new_banner['sp_link'] ) : ?>
			<div class="m-banner size-l right m-banner--3 pc-hidden">
				<div class="m-banner__inner">
					<a href="<?php echo $top_new_banner['sp_link']; ?>" target="_blank">
						<img src="<?php echo $top_new_banner['sp_img']['sizes']['banner-l']; ?>" loading="lazy">
					</a>
				</div>
			</div>
<?php endif; ?>
<?php if( $top_new_banner_list['sp_item'] ) : ?>
			<div class="m-banner size-l right m-banner--4 pc-hidden">
				<div class="m-banner__inner">
					<ul class="m-banner__list">
<?php foreach( $top_new_banner_list['sp_item'] as $top_new_banner_sp_item ) : ?>
<?php if( $top_new_banner_sp_item['item_ad'] ) : ?>
						<li class="m-banner__item">
<?php echo $top_new_banner_sp_item['item_ad']; ?>
						</li>
<?php elseif( $top_new_banner_sp_item['item_img'] && $top_new_banner_sp_item['item_link'] ) : ?>
						<li class="m-banner__item">
							<a href="<?php echo $top_new_banner_sp_item['item_link']; ?>" target="_blank">
								<img src="<?php echo $top_new_banner_sp_item['item_img']['sizes']['banner-s']; ?>" loading="lazy">
							</a>
						</li>
<?php endif; ?>
<?php endforeach; ?>
					</ul>
				</div>
			</div>
<?php endif; ?>
		</div>
		<div class="m-side">
<?php
$top_side_top_flag = false;
$top_side_top = get_field('top_side_top', 'option');
if( $top_side_top['pc_type'] == 'ad' && $top_side_top['pc_ad'] ) :
?>
			<div class="m-side-banner tbsp-hidden">
<?php echo $top_side_top['pc_ad'];  ?>
			</div>
<?php elseif( $top_side_top['pc_type'] == 'banner' && $top_side_top['pc_img'] && $top_side_top['pc_link'] ) : ?>
			<div class="m-side-banner tbsp-hidden">
				<a href="<?php echo $top_side_top['pc_link']; ?>" target="_blank"><img src="<?php echo $top_side_top['pc_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php
if( $top_side_top['sp_type'] == 'ad' && $top_side_top['sp_ad'] ) :
$top_side_top_flag = true;
?>
			<div class="m-side-banner pc-hidden">
<?php echo $top_side_top['sp_ad']; ?>
			</div>
<?php
elseif( $top_side_top['sp_type'] == 'banner' && $top_side_top['sp_img'] && $top_side_top['sp_link'] ) :
$top_side_top_flag = true;
?>
			<div class="m-side-banner pc-hidden">
				<a href="<?php echo $top_side_top['sp_link']; ?>" target="_blank"><img src="<?php echo $top_side_top['sp_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php get_template_part('modules/side', 'search'); ?>
<?php get_template_part('modules/side', 'category'); ?>
<?php
$top_side_middle = get_field('top_side_middle', 'option');
if( $top_side_middle['pc_type'] == 'ad' && $top_side_middle['pc_ad'] ) :
?>
			<div class="m-side-banner tbsp-hidden">
<?php echo $top_side_middle['pc_ad']; ?>
			</div>
<?php elseif( $top_side_middle['pc_type'] == 'banner' && $top_side_middle['pc_img'] && $top_side_middle['pc_link'] ) : ?>
			<div class="m-side-banner tbsp-hidden">
				<a href="<?php echo $top_side_middle['pc_link']; ?>" target="_blank"><img src="<?php echo $top_side_middle['pc_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php if( $top_side_middle['sp_type'] == 'ad' && $top_side_middle['sp_ad'] ) : ?>
			<div class="m-side-banner pc-hidden<?php if( $top_side_top_flag ) echo ' m-side-middle'; ?>">
<?php echo $top_side_middle['sp_ad']; ?>
			</div>
<?php elseif( $top_side_middle['sp_type'] == 'banner' && $top_side_middle['sp_img'] && $top_side_middle['sp_link'] ) : ?>
			<div class="m-side-banner pc-hidden<?php if( $top_side_top_flag ) echo ' m-side-middle'; ?>">
				<a href="<?php echo $top_side_middle['sp_link']; ?>" target="_blank"><img src="<?php echo $top_side_middle['sp_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php get_template_part('modules/side', 'ranking'); ?>
<?php
$top_side_bottom = get_field('top_side_bottom', 'option');
if( $top_side_bottom['pc_item'] ) :
foreach( $top_side_bottom['pc_item'] as $top_side_bottom_pc_item ) :
?>
<?php if( $top_side_bottom_pc_item['item_ad'] ) : ?>
			<div class="m-side-banner tbsp-hidden">
<?php echo $top_side_bottom_pc_item['item_ad']; ?>
			</div>
<?php elseif( $top_side_bottom_pc_item['item_img'] && $top_side_bottom_pc_item['item_link'] ) : ?>
			<div class="m-side-banner tbsp-hidden">
				<a href="<?php echo $top_side_bottom_pc_item['item_link']; ?>" target="_blank"><img src="<?php echo $top_side_bottom_pc_item['item_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php
endforeach;
endif;
?>
<?php
if( $top_side_bottom['sp_item'] ) :
foreach( $top_side_bottom['sp_item'] as $top_side_bottom_sp_item ) :
?>
<?php if( $top_side_bottom_sp_item['item_ad'] ) : ?>
			<div class="m-side-banner pc-hidden">
<?php echo $top_side_bottom_sp_item['item_ad']; ?>
			</div>
<?php elseif( $top_side_bottom_sp_item['item_img'] && $top_side_bottom_sp_item['item_link'] ) : ?>
			<div class="m-side-banner pc-hidden">
				<a href="<?php echo $top_side_bottom_sp_item['item_link']; ?>" target="_blank"><img src="<?php echo $top_side_bottom_sp_item['item_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php
endforeach;
endif;
?>
		</div>
	</div>
<?php get_template_part('modules/research'); ?>
</main>

<?php get_footer(); ?>
