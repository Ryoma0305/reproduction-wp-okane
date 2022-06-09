<?php
global $util;
$pageinfo = $util->pageInfo();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $pageinfo->description(); ?>">
    <meta property="og:title" content="<?php echo $pageinfo->title(); ?>">
    <meta property="og:type" content="<?php echo $pageinfo->type(); ?>">
    <meta property="og:site_name" content="<?php echo $pageinfo->sitename(); ?>">
    <meta property="og:description" content="<?php echo $pageinfo->description(); ?>">
    <meta property="og:url" content="<?php echo $pageinfo->url(); ?>">
    <meta property="og:image" content="<?php echo $pageinfo->image()['src']; ?>">
    <meta property="og:image:width" content="<?php echo $pageinfo->image()['width']; ?>">
    <meta property="og:image:height" content="<?php echo $pageinfo->image()['height']; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/favicon.ico">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/android-chrome-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/favicon-32x32.png">
    <link rel="mask-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/safari-pinned-tab.svg">
    <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/site.webmanifest" crossorigin="use-credentials">
    <link rel="canonical" href="<?php echo $pageinfo->url(); ?>" />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/mstile-150x150.png">
    <meta name="msapplication-config" content="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <title><?php echo $pageinfo->title(); ?></title>
    <link rel="stylesheet" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/main.css?v=<?php echo $util->ver(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tamma+2:wght@800&family=Noto+Sans+JP:wght@400;500;900&display=swap" rel="stylesheet">
    <?php if( is_single() ): ?>
    <script type="application/ld+json">
    [
        {
            "@context": "http://schema.org",
            "@type": "Article",
            "name": "<?php echo $pageinfo->title(); ?>",
            "headline": "<?php echo $pageinfo->title(); ?>",
            "author": {
                "@type": "Person",
                "name": "<?php echo the_author(); ?>"
                },
            "image": {
                "@type": "ImageObject",
                "url": "<?php echo $pageinfo->image()['src']; ?>"
            },
            "description": "<?php echo $pageinfo->description(); ?>",
            "articleSection": "<?php echo get_the_category();?>",
            "url": "<?php echo get_the_permalink();?>",
            "mainEntityOfPage": "<?php echo get_the_permalink();?>",
            "publisher": {
                "@type": "Organization",
                "name": "おかねチップス",
                "logo": {
                "@type": "ImageObject",
                "url": "https://okanechips.mei-kyu.com/wp-content/themes/okanechips/assets/imgs/common/logo.svg"
                }
            },
            "datePublished": "<?php the_time('Y-m-d'); ?>",
            "dateModified": "<?php the_modified_time('Y-m-d'); ?>"
        },
        {
      "@context": "https://schema.org",
      "@type": "SiteNavigationElement",
      "hasPart": [
            {
            "@type": "WebPage",
            "name": "トップ",
            "url": "https://okanechips.mei-kyu.com/"
            },
            {
            "@type": "CollectionPage",
            "name": "THE PIONEERの記事一覧",
            "url": "https://okanechips.mei-kyu.com/the-pioneer/"
            },
            {
            "@type": "CollectionPage",
            "name": "シゴトとワタシの記事一覧",
            "url": "https://okanechips.mei-kyu.com/work-and-me/"
            },
            {
            "@type": "CollectionPage",
            "name": "苦労は買わずに聞け！の記事一覧",
            "url": "https://okanechips.mei-kyu.com/kurokike/"
            },
            {
            "@type": "CollectionPage",
            "name": "フリーランス1年生の生きる術の記事一覧",
            "url": "https://okanechips.mei-kyu.com/freelance-frist-year/"
            },
            {
            "@type": "CollectionPage",
            "name": "新米経営者の初決算までの道の記事一覧",
            "url": "https://okanechips.mei-kyu.com/road-to-the-first-settlement/"
            }
        ]
    ]

    </script>
    <?php endif;?>
</head>
