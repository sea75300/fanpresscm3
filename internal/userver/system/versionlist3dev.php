<?php

    $installfile   = 'https://github.com/sea75300/fanpresscm3/releases/download/v3.7.1/fanpress3.7.1_full.zip';

    $versions = array(
        'default' => array(
            'newversion'    => '3.7.1',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.7.1.zip',
            'force'     => 0,
            'message'   => 'Preparing release for auto upgrade to FanPress CM 4!!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-7-0-veroeffentlicht/',
            'signature' => $signature,
            'phpversion' => '5.5.3',
            'release'   => '10.08.2018',
            'v4Available'   => true,
            'v4version'     => '4.0.0-rc17',
        ),
        '3.7.0' => array(
            'newversion'    => '3.7.1',
            'file'      => 'https://updates.nobody-knows.org/fanpress/system/packages/fanpress_update_version3.7.1.zip',
            'force'     => 0,
            'message'   => 'Preparing release for auto upgrade to FanPress CM 4!!',
            'notice'    => 'https://nobody-knows.org/fanpress-cm-3-7-0-veroeffentlicht/',
            'signature' => $signature,
            'phpversion' => '5.5.3',
            'release'   => '10.08.2018',
            'v4Available'   => false,
            'v4version'     => '',
        ),
    );
?>