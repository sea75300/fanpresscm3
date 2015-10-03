<!DOCTYPE HTML>
<HTML lang="<?php print $FPCM_LANG->getLangCode(); ?>">
    <head>
        <title><?php $FPCM_LANG->write('HEADLINE'); ?></title>
        <meta http-equiv="content-type" content= "text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">  
        <link rel="shortcut icon" href="<?php print $FPCM_THEMEPATH; ?>favicon.png" type="image/png" /> 
        <?php include_once 'includefiles.php'; ?>
    </head>    

    <body class="fpcm-body" id="fpcm-body"> 
        
        <?php include_once 'vars.php'; ?>
        
        <?php include_once 'profiledialog.php'; ?>

        <div id="fpcm-header-fixed-spacer"></div>
        
        <div id="fpcm-header" class="fpcm-header">
            <div class="fpcm-header-inner">
                <div class="fpcm-header-td1">
                    <div class="fpcm-logo-img"><img class="fpcm-logo" src="<?php print $FPCM_THEMEPATH; ?>logo.svg" alt="FanPress CM"></div>
                    <div class="fpcm-logo-text"><span>FanPress CM</span> <span>News System</span></div>
                    <div class="fpcm-clear"></div>
                </div>
                <?php if ($FPCM_LOGGEDIN) : ?>
                <div class="fpcm-header-td3">
                    <?php if ($FPCM_MAINTENANCE_MODE) : ?>
                    <span class="fa-stack fa-lg fpcm-ui-important-text" title="<?php $FPCM_LANG->write('SYSTEM_OPTIONS_MAINTENANCE'); ?>..."</span>
                        <span class="fa fa-square fa-stack-2x"></span>
                        <span class="fa fa-lightbulb-o fa-stack-1x fa-inverse"></span>
                    </span>
                    <?php endif; ?>
                    <?php \fpcm\model\view\helper::linkButton($FPCM_FRONTEND_LINK, 'GLOBAL_FRONTEND_OPEN', 'fpcm-open-news', '', '_blank') ?>
                    <button id="fpcm-clear-cache"><?php $FPCM_LANG->write('GLOBAL_CACHE_CLEAR'); ?></button>
                    <button id="fpcm-profile-menu-open" class="fpcm-ui-button"><?php print $FPCM_USER; ?></button>
                </div>
                 <?php endif; ?>                    
                <div class="fpcm-clear"></div>
            </div>                           
        </div>
        
        <?php include_once 'navigation.php'; ?>
        
        <?php if (isset($includeManualCheck) && $includeManualCheck) : ?>
        <?php include_once __DIR__.'/updatemancheck.php'; ?>
        <?php endif; ?>
        
        <div class="fpcm-wrapper <?php if (in_array($FPCM_CURRENT_MODULE, array('system/login', 'installer'))) : ?>fpcm-wrapper-full<?php endif; ?> <?php if (defined('FPCM_DEBUG') && FPCM_DEBUG) : ?>fpcm-wrapper-debug<?php endif; ?>">
