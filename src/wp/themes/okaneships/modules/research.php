	<section class="m-research">
		<div class="m-research__container">
			<div class="m-research-icon">
				<div class="img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/search_icon.png" alt="見たい記事が見つからないですか？それなら「キーワード」または「カテゴリー」から探しましょう！" loading="lazy"></div>
			</div>
			<h2 class="m-research__ttl">
				<span class="ja">記事検索</span>
				<span class="en">RESEARCH</span>
			</h2>
			<div class="m-research__list">
				<div class="m-research-keyword">
					<div class="ttl">
						<span class="ja">キーワード</span>
						<span class="en">KEYWORD</span>
					</div>
					<form action="<?php echo get_permalink(get_page_by_path('list')->ID); ?>" method="get" class="m-research__search">
						<input type="text" name="s" placeholder="キーワードで検索する" class="m-research__input">
						<button type="submit" class="m-research__btn"></button>
					</form>
<?php if( have_rows('keywords','option') ) : ?>
					<ul class="m-research-keyword__list">
<?php while( have_rows('keywords','option') ): the_row(); ?>
						<li><a href="<?php echo get_permalink(get_page_by_path('list')->ID).'?s='.urlencode(get_sub_field('keyword')); ?>"><?php echo esc_html(get_sub_field('keyword')); ?></a></li>
<?php endwhile; ?>
					</ul>
<?php endif; ?>
				</div>
				<div class="m-research-category">
					<div class="ttl">
						<span class="ja">カテゴリー</span>
						<span class="en">CATEGORY</span>
					</div>
					<ul class="m-research-category__list">
<?php
$categories = get_categories();
if( $categories ) :
foreach( $categories as $category ) :
?>
						<li><a href="<?php echo get_term_link($category); ?>"><?php echo esc_html($category->name); ?></a></li>
<?php
endforeach;
endif;
?>
					</ul>
				</div>
				<div class="m-research__chara js-scrollEffect">
					<p class="bubble">積み上げろ！<br>知識と財産</p>
					<div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_3.svg" alt="積み上げろ！知識と財産" loading="lazy"></div>
				</div>
			</div>
		</div>
	</section>
