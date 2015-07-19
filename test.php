<?php
//    const FPCM_PUB_CATEGORY_LISTALL = 2;
//    const FPCM_PUB_LIMIT_LISTALL = 2;
//    const FPCM_PUB_OUTPUT_UTF8 = false;

    include_once __DIR__.'/fpcmapi.php';
    $fpcmApi = new fpcmAPI();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php $fpcmApi->showPageNumber(); ?> <?php $fpcmApi->showTitle(); ?></title>
    </head>
    <body>
        <?php
            if (isset($_GET['module']) && $_GET['module'] == 'fpcm/latest') {
                $fpcmApi->showLatestNews();
            } else {
                $fpcmApi->showArticles();
            }
        ?>
    </body>
</html>
