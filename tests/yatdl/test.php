<?php
    include __DIR__.'/inc/common.php';

    $yatdl = new \fpcm\model\system\yatdl(__DIR__.'/test.yml');
    $res = $yatdl->parse();

    $yatdl->dumpYamlArray();
?>