			<div class="m-side-category">
				<div class="m-side-category__ttl">
					<p class="ja">カテゴリー</p>
					<span class="en">CATEGORY</span>
				</div>
				<ul class="m-side-category__list">
<?php
$all_post_count = wp_count_posts()->publish;
?>
					<li class="item<?php if( is_home() ) echo ' is-current'; ?>"><a href="<?php echo get_permalink(get_page_by_path('list')->ID); ?>" class="item__link"><span class="cat">すべて</span><span class="total"> (<?php echo $all_post_count; ?>)</span></a></li>
<?php
$categories = get_categories();
if( $categories ) :
foreach( $categories as $category ) :
?>
					<li class="item<?php if( $cat && $cat == $category->term_id ) echo ' is-current'; ?>"><a href="<?php echo get_term_link($category); ?>" class="item__link"><span class="cat"><?php echo esc_html($category->name); ?></span><span class="total"> (<?php echo $category->category_count; ?>)</span></a></li>
<?php
endforeach;
endif;
?>
				</ul>
			</div>
