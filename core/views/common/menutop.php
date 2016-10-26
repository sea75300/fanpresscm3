<?php if ($FPCM_LOGGEDIN) : ?>
 <div class="fpcm-status-info">
     <ul class="fpcm-menu-top">
         <li class="fpcm-menu-top-level1" id="fpcm-ui-showmenu-li">
             <a href="#" id="fpcm-ui-showmenu">
                 <span class="fpcm-navicon fa fa-bars fa-fw fa-lg"></span>
                 <span class="fpcm-navigation-descr"><?php $FPCM_LANG->write('NAVIGATION_SHOW'); ?></span>
             </a>
         </li>
         <li class="fpcm-menu-top-level1 fpcm-ui-center" id="fpcm-navigation-profile">
             <a href="#" target="_blank" class="fpcm-navigation-noclick">
                 <?php $FPCM_LANG->write('PROFILE_MENU_LOGGEDINAS',  array('{{username}}' => $FPCM_USER)); ?> <span class="fpcm-ui-center fpcm-navicon fa fa-user fa-lg fa-fw"></span>
             </a>
             <ul class="fpcm-submenu">
                 <li class="fpcm-menu-top-level2">
                     <a href="<?php print $FPCM_BASEMODULELINK; ?>system/profile" class="fpcm-loader">
                         <span class="fpcm-navicon fa fa-wrench fa-fw"></span>
                         <span class="fpcm-navigation-descr"><?php $FPCM_LANG->write('PROFILE_MENU_OPENPROFILE'); ?></span>
                     </a>
                 </li>
                 <li class="fpcm-menu-top-level2">
                     <a href="<?php print $FPCM_BASEMODULELINK; ?>system/logout" class="fpcm-loader">
                         <span class="fpcm-navicon fa fa-sign-out fa-fw"></span>
                         <span class="fpcm-navigation-descr"><?php $FPCM_LANG->write('LOGOUT_BTN'); ?></span>
                     </a>
                 </li>
                 <li class="fpcm-menu-top-level2 fpcm-menu-top-level2-status">
                     <span><b><?php $FPCM_LANG->write('PROFILE_MENU_LOGGEDINSINCE'); ?>:</b></span>
                     <span><?php \fpcm\model\view\helper::dateText($FPCM_SESSION_LOGIN); ?> (<?php print $FPCM_DATETIME_ZONE; ?>)</span>
                     <span><b><?php $FPCM_LANG->write('PROFILE_MENU_YOURIP'); ?></b></span>
                     <span><?php print fpcm\classes\http::getIp(); ?></span>
                 </li>
             </ul>
         </li>
         <li class="fpcm-menu-top-level1" id="fpcm-clear-cache" title="<?php $FPCM_LANG->write('GLOBAL_CACHE_CLEAR'); ?>">
             <a href="#" target="_blank">
                 <span class="fpcm-ui-center fpcm-navicon fa fa-recycle fa-lg fa-fw"></span>
             </a>
         </li>
         <li class="fpcm-menu-top-level1" title="<?php $FPCM_LANG->write('GLOBAL_FRONTEND_OPEN'); ?>">
             <a href="<?php print $FPCM_FRONTEND_LINK; ?>" target="_blank">
                 <span class="fpcm-ui-center fpcm-navicon fa fa-play fa-lg fa-fw"></span>
             </a>
         </li>
     <?php if ($FPCM_MAINTENANCE_MODE) : ?>
         <li class="fpcm-menu-top-level1"><span class="fa fa-lightbulb-o fa-lg fa-fw fpcm-ui-important-text" title="<?php $FPCM_LANG->write('SYSTEM_OPTIONS_MAINTENANCE'); ?>..."></span></li>
     <?php endif; ?>
     <?php if (!$FPCM_CRONJOBS_DISABLED) : ?>
         <li class="fpcm-menu-top-level1"><span class="fa fa-terminal fa-lg fa-fw fpcm-ui-important-text" title="<?php $FPCM_LANG->write('SYSTEM_OPTIONS_CRONJOBS'); ?>..."></span></li>
     <?php endif; ?>
     </ul>
     <div class="fpcm-clear"></div>
 </div>
 <?php endif; ?> 