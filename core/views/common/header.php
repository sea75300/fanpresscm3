<!DOCTYPE HTML>
<HTML lang="<?php print $FPCM_LANG->getLangCode(); ?>">
    <head>
        <title><?php $FPCM_LANG->write('HEADLINE'); ?></title>
        <meta http-equiv="content-type" content= "text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php print $FPCM_THEMEPATH; ?>favicon.png" type="image/png" /> 
        <?php include_once 'includefiles.php'; ?>
    </head>    

    <body class="fpcm-body" id="fpcm-body"> 
        
        <?php include_once 'vars.php'; ?>
        
        <?php include_once 'profiledialog.php'; ?>

        <div class="fpcm-wrapper-left <?php if (in_array($FPCM_CURRENT_MODULE, array('system/login', 'installer'))) : ?>fpcm-wrapper-fixed<?php endif; ?>" id="fpcm-wrapper-left">
            
            <div class="fpcm-logo fpcm-ui-center">
                <div><img class="fpcm-logo" src="<?php print $FPCM_THEMEPATH; ?>logo.svg" alt="FanPress CM News System"></div>
                <div><span>FanPress CM</span> <span>News System</span></div>
            </div>

            <?php if ($FPCM_LOGGEDIN) : ?>
            
            <div class="fpcm-status-info fpcm-ui-important-text">

            <?php if (!$FPCM_CRONJOBS_DISABLED) : ?>
                <div class="fpcm-status-info-box fpcm-ui-center">
                    <span class="fa-stack fa-lg" title="<?php $FPCM_LANG->write('SYSTEM_OPTIONS_CRONJOBS'); ?>...">
                        <span class="fa fa-square fa-stack-2x"></span>
                        <span class="fa fa-terminal fa-stack-1x fa-inverse"></span>
                    </span>                    
                </div>
            <?php endif; ?>
            <?php if ($FPCM_MAINTENANCE_MODE) : ?>
                <div class="fpcm-status-info-box fpcm-ui-center">
                    <span class="fa-stack fa-lg" title="<?php $FPCM_LANG->write('SYSTEM_OPTIONS_MAINTENANCE'); ?>...">
                        <span class="fa fa-square fa-stack-2x"></span>
                        <span class="fa fa-lightbulb-o fa-stack-1x fa-inverse"></span>
                    </span>                    
                </div>
            <?php endif; ?>
                <div class="fpcm-clear"></div>
            </div>
            <?php endif; ?>

            <?php include_once 'navigation.php'; ?>
            

            <div class="fpcm-footer fpcm-footer-left">
                <div class="fpcm-footer-text">
                    <b>Version</b> <?php print $FPCM_VERSION; ?><br>
                    &copy; 2011-<?php print date('Y'); ?> <a href="https://nobody-knows.org/download/fanpress-cm/" target="_blank">nobody-knows.org</a>                    
                </div>
            </div>

        </div>
        
        <?php if (isset($includeManualCheck) && $includeManualCheck) : ?>
        <?php include_once __DIR__.'/updatemancheck.php'; ?>
        <?php endif; ?>
        
        <div class="fpcm-wrapper <?php if (in_array($FPCM_CURRENT_MODULE, array('system/login', 'installer'))) : ?>fpcm-wrapper-fixed<?php endif; ?>" id="fpcm-wrapper-right">
