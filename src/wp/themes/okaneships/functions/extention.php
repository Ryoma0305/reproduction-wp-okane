<?php
/**************************************************
Extention
**************************************************/

/* on_pagenation */
function on_pagination($pages = ''){
	global $wp_query;
	global $paged;
	$output = '';
	if( empty($paged) ) {
		$paged = 1;
	}
	$pages = $wp_query->max_num_pages;
	if( !$pages ) {
		$pages = 1;
	}
	if( $pages > 1 ) {
		$output.= "\t\t\t".'<div class="m-pagination">'."\n";
		if( $paged > 1 ) {
			$output.= "\t\t\t\t\t".'<a href="'.get_pagenum_link($paged-1).'" class="m-pagination__prev"></a>'."\n";
		}
    $output.= "\t\t\t\t\t".'<ul class="m-pagination__list">'."\n";
		if( $pages > 7 && $paged > 4 ) {
			$output.= "\t\t\t\t\t\t".'<li class="more">...</li>'."\n";
		}
		if( $pages > 5 && $paged > 3 ) {
			$output.= "\t\t\t\t\t\t".'<li class="more sp">...</li>'."\n";
		}
		for( $i=1;$i<=$pages;$i++ ) {
			if(
				($paged <= 3 && $i > 7)
				|| ($pages-$paged <= 3 && $i <= $pages-7)
				|| ($paged > 3 && $pages-$paged > 3 && ($i < $paged-3 || $i > $paged+3))
			) {
				continue;
			}
			if( $paged == $i ) {
				$output.= "\t\t\t\t\t\t".'<li class="is-current"><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>'."\n";
			} elseif(
				($paged < 3 && $i <= 3)
				|| ($i >= $paged-1 && $i <= $paged+1)
				|| ($pages-$paged < 2 && $i >= $pages-2)
			) {
				$output.= "\t\t\t\t\t\t".'<li class="sp-show"><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>'."\n";
			} else {
				$output.= "\t\t\t\t\t\t".'<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>'."\n";
			}
		}
		if( $pages > 7 && $pages-$paged > 3 ) {
			$output.= "\t\t\t\t\t\t".'<li class="more">...</li>'."\n";
		}
		if( $pages > 5 && $pages-$paged > 2 ) {
			$output.= "\t\t\t\t\t\t".'<li class="more sp">...</li>'."\n";
		}
		$output.= "\t\t\t\t\t".'</ul>'."\n";
		if( $paged < $pages ) {
			$output.= "\t\t\t\t\t".'<a href="'.get_pagenum_link($paged+1).'" class="m-pagination__next"></a>'."\n";
		}
		$output.= "\t\t\t".'</div>'."\n";
	}
	echo $output;
}

//Twitterアドレスを置換する
function change_twitter_url( $content ){
	//jsonデータが読み取れなかった時に表示するhtml
	$tweet = '<blockquote class="twitter-tweet" data-width="550" data-dnt="true"><a href="[url]">Tweetを表示</a></blockquote><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';

	//ツイートURLの行を取得
	$res = preg_match_all( '/^(<p>)?(https?:\/\/twitter\.com\/\w{1,15}\/status(es)?\/\d+)(<br *\/?>|<\/p>)?$/im', $content,$m);

	//オプション設定
	$options = array(
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 5 //タイムアウト(秒)
	);

	//マッチしたURLをループして置換
	foreach ($m[0] as $match) {
		//ツイートURL
		$url = strip_tags($match);

		//json取得
		$json_url = 'https://publish.twitter.com/oembed?maxwidth=550&dnt=true&url='. urlencode($url);
		$ch = curl_init($json_url);
		curl_setopt_array($ch, $options);
		$json = curl_exec($ch);
		$arr = json_decode($json, true);
		curl_close($ch);

		if ($arr === NULL) {
			//json取得失敗
			$html = preg_replace('/\[url\]/', $url, $tweet);
		} else {
			//json取得成功
			$html = html_entity_decode($arr['html']);
		}
		//本文中のURLを置換
		$content = preg_replace('{^'.preg_quote($match, '{}').'}im', $html , $content, 1);
	}
	return $content;
}
add_filter('the_content','change_twitter_url',10);