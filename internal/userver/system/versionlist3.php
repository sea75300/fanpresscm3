<?php
    $newversion    = '3.1.7';
    $newversionDev = '3.2.0-b4';
    
    $installfile   = 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress3.1.7_full.zip';
    
    $signature = (file_exists(__DIR__.'/packages/fanpress_update_version3.1.7.zip')
               ? '$sig$'.md5_file(__DIR__.'/packages/fanpress_update_version3.1.7.zip').'_'
                        .sha1_file(__DIR__.'/packages/fanpress_update_version3.1.7.zip').'$sig$'
               : '');

    $versions = array(
        'default' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.1.7.zip',
            'force'     => 0,
            'message'   => 'Third bugfix release of FanPress CM 3.1.x!',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-5-veroeffentlicht/',
            'signature' => $signature
        ),

        '3.1.7dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.1.7dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-devdev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-a1' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-a1dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-b1' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-b1dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta1',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-1-4-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-b2' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta4',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-2-0-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-b2dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta4',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-2-0-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-b3' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta4',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-2-0-veroeffentlicht/',
            'signature' => ''
        ),

        '3.2.0-b3dev' => array(
            'file'      => 'http://nobody-knows.org/updatepools/fanpress/system/packages/fanpress_update_version3.2.0-b4.zip',
            'force'     => 0,
            'message'   => 'FanPress CM 3.2 beta4',
            'notice'    => 'http://nobody-knows.org/fanpress-cm-3-2-0-veroeffentlicht/',
            'signature' => ''
        )
    );
?>