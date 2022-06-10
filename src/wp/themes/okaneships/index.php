<?php
$pageinfo = array(
	'page_id' => 'article',
	'title' => '記事一覧｜おかねチップス｜お金と仕事のTIPSをサクサク検索',
	'description' => 'おかねチップスはフリーランスや副業で働く方々に向けて、お金や仕事、働き方に関する役立つ情報を発信しております。請求業務や案件管理、税金や確定申告のことなど様々な情報を配信しております。',
	'navigation' => 'article'
);
if (get_search_query()) {
	$pageinfo = array(
		'title' => '「'.get_search_query().'」の記事一覧｜おかねチップス｜お金と仕事のTIPSをサクサク検索',
		'description' => '「'.get_search_query().'」に関する記事の一覧ページです。おかねチップスはフリーランスや副業で働く方々に向けて、お金や仕事、働き方に関する役立つ情報を発信しております。請求業務や案件管理、税金や確定申告のことなど様々な情報を配信しております。',
	);
}
if( is_category() ){
	$pageinfo = array(
		'title' => '「'.esc_html(single_cat_title('', false)).'」の記事一覧｜おかねチップス｜お金と仕事のTIPSをサクサク検索',
		'description' => wp_strip_all_tags(category_description(), true),
	);
}
if( is_author() ){
	$author_name = get_field('user_name', 'user_'.$author);
	$pageinfo = array(
		'title' => '「'.esc_html($author_name).'」の記事一覧｜おかねチップス｜お金と仕事のTIPSをサクサク検索',
	);
}
if( is_tag() ){
	$pageinfo = array(
		'title' => '「'.esc_html(single_tag_title('', false)).'」の記事一覧｜おかねチップス｜お金と仕事のTIPSをサクサク検索',
		'description' => wp_strip_all_tags(tag_description(), true),
	);
}

set_query_var('pageinfo', $pageinfo);
get_header();
?>

<main class="main">
	<div class="m-container">
		<div class="m-main">
			<section class="m-article">
				<div class="m-article__container">
					<div class="m-article__body">
<?php
$article_title = '記事一覧';
if( get_search_query() ) {
	$article_title = '&#12300;'.get_search_query().'&#12301;'.'<br class="pc-hidden">'.'の検索結果';
} elseif( is_category() ) {
	$article_title = esc_html(single_cat_title('', false)).'の記事一覧';
} elseif( is_author() ) {
	$author_name = get_field('user_name', 'user_'.$author);
	$article_title = esc_html($author_name).'の記事一覧';
} elseif( is_tag() ) {
	$article_title = esc_html(single_tag_title('', false)).'の記事一覧';
}
?>
						<h1 class="m-article__ttl"><?php echo $article_title; ?></h1>
						<div class="m-article__inner">
							<div class="m-article__chara--1 js-scrollEffect">
								<p class="bubble">片手で<br>サクサク</p>
								<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_4.svg" alt="片手でサクサク"></div>
							</div>
<?php if( have_posts() ) : ?>
							<div class="m-article__list">
<?php
$count = 0;
while( have_posts() ) : the_post();
$is_new = array_search(get_the_ID(), $util->newIcon());
$count++;
?>
								<div class="item<?php if( $is_new !== false ) echo ' new'; ?>">
<?php if( $count == 7 ) : ?>
									<div class="m-article__chara--2 js-scrollEffect">
										<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_1.svg" loading="lazy" alt="サクサク節税！"></div>
										<p class="bubble">サクサク節税！</p>
									</div>
<?php endif; ?>
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
$article_tags = get_the_tags(get_the_ID());
if( $article_tags ) :
?>
										<p class="item__corner">
<?php foreach( $article_tags as $tag ) : ?>
											<span><?php echo esc_html($tag->name); ?></span>
<?php endforeach; ?>
										</p>
<?php endif; ?>
										<div class="item__meta">
<?php
$article_categories = get_the_category(get_the_ID());
if( $article_categories ) :
?>
											<ul class="item__cat">
<?php foreach( $article_categories as $category ) : ?>
												<li><?php echo esc_html($category->name); ?></li>
<?php endforeach; ?>
											</ul>
<?php endif; ?>
											<p class="item__date"><?php the_time('Y.m.d'); ?></p>
										</div>
									</a>
								</div>
<?php endwhile; ?>
<?php
$list_banner = get_field('list_banner_one', 'option');
if( $list_banner['pc_type'] == 'ad' && $list_banner['pc_ad'] ) :
?>
								<div class="m-banner size-l tbsp-hidden">
									<div class="m-banner__inner">
<?php echo $list_banner['pc_ad']; ?>
									</div>
								</div>
<?php elseif( $list_banner['pc_type'] == 'banner' && $list_banner['pc_img'] && $list_banner['pc_link'] ) : ?>
								<div class="m-banner size-l tbsp-hidden">
									<div class="m-banner__inner">
										<a href="<?php echo $list_banner['pc_link']; ?>" target="_blank">
											<img src="<?php echo $list_banner['pc_img']['sizes']['banner-l']; ?>" loading="lazy">
										</a>
									</div>
								</div>
<?php endif; ?>
<?php
$list_banner_list = get_field('list_banner_list', 'option');
if( $list_banner_list['pc_item'] ) :
?>
								<div class="m-banner size-l tbsp-hidden">
									<div class="m-banner__inner">
										<ul class="m-banner__list">
<?php foreach( $list_banner_list['pc_item'] as $list_banner_pc_item ) : ?>
<?php if( $list_banner_pc_item['item_ad'] ) : ?>
											<li class="m-banner__item">
<?php echo $list_banner_pc_item['item_ad']; ?>
											</li>
<?php elseif( $list_banner_pc_item['item_img'] && $list_banner_pc_item['item_link'] ) : ?>
											<li class="m-banner__item">
												<a href="<?php echo $list_banner_pc_item['item_link']; ?>" target="_blank">
													<img src="<?php echo $list_banner_pc_item['item_img']['sizes']['banner-s']; ?>" loading="lazy">
												</a>
											</li>
<?php endif; ?>
<?php endforeach; ?>
										</ul>
									</div>
								</div>
<?php endif; ?>
<?php if( $list_banner['sp_type'] == 'ad' && $list_banner['sp_ad'] ) : ?>
								<div class="m-banner size-l m-banner-one pc-hidden">
									<div class="m-banner__inner">
<?php echo $list_banner['sp_ad']; ?>
									</div>
								</div>
<?php elseif( $list_banner['sp_type'] == 'banner' && $list_banner['sp_img'] && $list_banner['sp_link'] ) : ?>
								<div class="m-banner size-l m-banner-one pc-hidden">
									<div class="m-banner__inner">
										<a href="<?php echo $list_banner['sp_link']; ?>" target="_blank">
											<img src="<?php echo $list_banner['sp_img']['sizes']['banner-l']; ?>" loading="lazy">
										</a>
									</div>
								</div>
<?php endif; ?>
<?php if( $list_banner_list['sp_item'] ) : ?>
								<div class="m-banner size-l pc-hidden">
									<div class="m-banner__inner">
										<ul class="m-banner__list">
<?php foreach( $list_banner_list['sp_item'] as $list_banner_sp_item ) : ?>
<?php if( $list_banner_sp_item['item_ad'] ) : ?>
											<li class="m-banner__item">
<?php echo $list_banner_sp_item['item_ad']; ?>
											</li>
<?php elseif( $list_banner_sp_item['item_img'] && $list_banner_sp_item['item_link'] ) : ?>
											<li class="m-banner__item">
												<a href="<?php echo $list_banner_sp_item['item_link']; ?>" target="_blank">
													<img src="<?php echo $list_banner_sp_item['item_img']['sizes']['banner-s']; ?>" loading="lazy">
												</a>
											</li>
<?php endif; ?>
<?php endforeach; ?>
										</ul>
									</div>
								</div>
<?php endif; ?>
							</div>
<?php else : ?>
							<p>お探しの記事はありません。</p>
<?php endif; ?>
<?php on_pagination(); ?>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="m-side">
<?php
$list_side_top_flag = false;
$list_side_top = get_field('list_side_top', 'option');
if( $list_side_top['pc_type'] == 'ad' && $list_side_top['pc_ad'] ) :
?>
			<div class="m-side-banner tbsp-hidden">
<?php echo $list_side_top['pc_ad']; ?>
			</div>
<?php elseif( $list_side_top['pc_type'] == 'banner' && $list_side_top['pc_img'] && $list_side_top['pc_link'] ) : ?>
			<div class="m-side-banner tbsp-hidden">
				<a href="<?php echo $list_side_top['pc_link']; ?>" target="_blank"><img src="<?php echo $list_side_top['pc_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php
if( $list_side_top['sp_type'] == 'ad' && $list_side_top['sp_ad'] ) :
$list_side_top_flag = true;
?>
			<div class="m-side-banner pc-hidden">
<?php echo $list_side_top['sp_ad']; ?>
			</div>
<?php
elseif( $list_side_top['sp_type'] == 'banner' && $list_side_top['sp_img'] && $list_side_top['sp_link'] ) :
$list_side_top_flag = true;
?>
			<div class="m-side-banner pc-hidden">
				<a href="<?php echo $list_side_top['sp_link']; ?>" target="_blank"><img src="<?php echo $list_side_top['sp_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php get_template_part('modules/side', 'search'); ?>
<?php get_template_part('modules/side', 'category'); ?>
<?php
$list_side_middle = get_field('list_side_middle', 'option');
if( $list_side_middle['pc_type'] == 'ad' && $list_side_middle['pc_ad'] ) :
?>
			<div class="m-side-banner tbsp-hidden">
<?php echo $list_side_middle['pc_ad']; ?>
			</div>
<?php elseif( $list_side_middle['pc_type'] == 'banner' && $list_side_middle['pc_img'] && $list_side_middle['pc_link'] ) : ?>
			<div class="m-side-banner tbsp-hidden">
				<a href="<?php echo $list_side_middle['pc_link']; ?>" target="_blank"><img src="<?php echo $list_side_middle['pc_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php if( $list_side_middle['sp_type'] == 'ad' && $list_side_middle['sp_ad'] ) : ?>
			<div class="m-side-banner pc-hidden<?php if( $list_side_top_flag ) echo ' m-side-middle'; ?>">
<?php echo $list_side_middle['sp_ad']; ?>
			</div>
<?php elseif( $list_side_middle['sp_type'] == 'banner' && $list_side_middle['sp_img'] && $list_side_middle['sp_link'] ) : ?>
			<div class="m-side-banner pc-hidden<?php if( $list_side_top_flag ) echo ' m-side-middle'; ?>">
				<a href="<?php echo $list_side_middle['sp_link']; ?>" target="_blank"><img src="<?php echo $list_side_middle['sp_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php get_template_part('modules/side', 'ranking'); ?>
<?php
$list_side_bottom = get_field('list_side_bottom', 'option');
if( $list_side_bottom['pc_item'] ) :
foreach( $list_side_bottom['pc_item'] as $list_side_bottom_pc_item ) :
?>
<?php if( $list_side_bottom_pc_item['item_ad'] ) : ?>
			<div class="m-side-banner tbsp-hidden">
<?php echo $list_side_bottom_pc_item['item_ad']; ?>
			</div>
<?php elseif( $list_side_bottom_pc_item['item_img'] && $list_side_bottom_pc_item['item_link'] ) : ?>
			<div class="m-side-banner tbsp-hidden">
				<a href="<?php echo $list_side_bottom_pc_item['item_link']; ?>" target="_blank"><img src="<?php echo $list_side_bottom_pc_item['item_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
			</div>
<?php endif; ?>
<?php
endforeach;
endif;
?>
<?php
if( $list_side_bottom['sp_item'] ) :
foreach( $list_side_bottom['sp_item'] as $list_side_bottom_sp_item ) :
?>
<?php if( $list_side_bottom_sp_item['item_ad'] ) : ?>
			<div class="m-side-banner pc-hidden">
<?php echo $list_side_bottom_sp_item['item_ad']; ?>
			</div>
<?php elseif( $list_side_bottom_sp_item['item_img'] && $list_side_bottom_sp_item['item_link'] ) : ?>
			<div class="m-side-banner pc-hidden">
				<a href="<?php echo $list_side_bottom_sp_item['item_link']; ?>" target="_blank"><img src="<?php echo $list_side_bottom_sp_item['item_img']['sizes']['banner-s']; ?>" loading="lazy"></a>
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
