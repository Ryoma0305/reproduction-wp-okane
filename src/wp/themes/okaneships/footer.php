<?php
global $util;
$pageinfo = $util->pageInfo();
?>
<footer class="footer">
  <a href="#wrapper" class="footer__pagetop ss"><span class="txt">TOP</span></a>
<?php if( ( $pageinfo->page_id() == 'top' ) && get_field('top_download', 'option') ) : ?>
  <div class="footer-banner">
    <div class="footer-banner__wrapper">
      <div class="footer-banner__inner">
        <div class="footer-banner__info">
          <p class="footer-banner__ttl">名刺 DE 請求</p>
          <p class="footer-banner__lead">フリーランスや副業で働く方々を中心に、名刺を管理し、面倒な請求業務を効率化APPです的な簡単紹介文が入ります。</p>
          <ul class="footer-banner__intro">
            <li>名刺を管理し、面倒な請求業務を効率化</li>
            <li>案件を登録し、取引を見える化</li>
            <li>アクションを管理して業務を漏れなく管理</li>
          </ul>
          <a href="#" class="footer-banner__btn"><span>名刺 DE 請求とは</span></a>
        </div>
        <div class="footer-banner__download">
          <div class="footer-banner__chara js-scrollEffect">
            <p class="bubble"><span><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/foot-icon.png" loading="lazy" alt="icon"></span>IOS アプリだよ！</p>
            <div class="chara js-chara"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/chara_1.svg" loading="lazy" alt="IOSアプリだよ！"></div>
          </div>
          <div class="logo"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/foot-download.png" loading="lazy" alt="名刺 DE 請求"></div>
          <p class="ttl"><span class="sp">名刺 DE 請求</span>アプリ<span class="emp">ダウンロード</span></p>
          <div class="qr"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/foot-qr.png" loading="lazy" alt="QRコード"></div>
          <a href="#" target="_blank" class="store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/foot-store.png" loading="lazy" alt="App Store"></a>
          <div class="phone"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/imgs/common/foot-phone.png" loading="lazy" alt="phone"></div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
  <div class="footer__wrapper">
    <div class="footer__container">
      <div class="footer__logo"><a href="<?php echo home_url('/'); ?>">おかねチップス</a></div>
      <ul class="footer__link">
        <li><a href="<?php echo home_url('/'); ?>">トップページ</a></li>
        <li><a href="<?php echo get_permalink(get_page_by_path('list')->ID); ?>">記事一覧</a></li>
<?php if( !( $pageinfo->page_id() == 'top' && get_field('top_download', 'option')) ) : ?>
        <li><a href="/contact/">お問い合わせ</a></li>
<?php endif; ?>
      </ul>
      <div class="footer__category">
        <p class="ttl">カテゴリー</p>
        <ul class="list">
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
    </div>
  </div>
  <div class="footer__foot">
    <div class="footer__foot__inner">
      <div class="footer-sns">
        <p class="footer-sns__ttl">公式SNS</p>
        <ul class="footer-sns__list">
          <li><a href="https://twitter.com/okanechips" class="twitter" target="_blank"></a></li>
          <li><a href="https://www.facebook.com/%E3%81%8A%E3%81%8B%E3%81%AD%E3%83%81%E3%83%83%E3%83%97%E3%82%B9%E5%90%8D%E5%88%BAde%E8%AB%8B%E6%B1%82-100174805643516/" class="facebook" target="_blank"></a></li>
        </ul>
      </div>
      <ul class="footer__sitemap">
        <li><a href="https://time-machine.co.jp/" target="_blank">運営会社</a></li>
        <li><a href="https://okanechips.mei-kyu.com/terms/">利用規約</a></li>
        <li><a href="https://okanechips.mei-kyu.com/privacy/">プライバシーポリシー</a></li>
  		  <li><a href="https://okanechips.mei-kyu.com/informative/">インフォマティブデータポリシー</a></li>
  		  <li><a href="https://okanechips.mei-kyu.com/contact/">お問い合わせ</a></li>
  		  <li><a href="https://okanechips.mei-kyu.com/ads/">広告出稿について</a></li>
      </ul>
      <p class="footer__copyright">&copy; TIME MACHINE Inc. All Rights Reserved</p>
    </div>
  </div>
</footer>

</div><!-- /#wrapper -->
<!-- js -->
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/clipboard.min.js?v=<?php echo $util->ver(); ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/main.js?v=<?php echo $util->ver(); ?>"></script>
<?php wp_footer(); ?>
</body>
</html>
