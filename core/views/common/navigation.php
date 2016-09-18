<?php if (isset($FPCM_NAVIGATION) && $FPCM_LOGGEDIN) : ?>
<div class="fpcm-navigation-wrapper">
    <div class="fpcm-navigation">
        <ul id="fpcm-navigation-ul" class="fpcm-menu">
            <li class="fpcm-menu-level1 fpcm-ui-center" id="fpcm-ui-showmenu-li">
                <a href="#" id="fpcm-ui-showmenu">
                    <span class="fpcm-navicon fa fa-bars"></span>
                    <span class="fpcm-navigation-descr"><?php $FPCM_LANG->write('NAVIGATION_SHOW'); ?></span>
                </a>
            </li>

            <li class="fpcm-menu-level1 fpcm-menu-level1-show trio-nav" title="<?php $FPCM_LANG->write('GLOBAL_FRONTEND_OPEN'); ?>">
                <a href="<?php print $FPCM_FRONTEND_LINK; ?>" target="_blank">
                    <span class="fpcm-ui-center fpcm-navicon fa fa-play"></span>
                </a>
            </li>
            
            <li class="fpcm-menu-level1 fpcm-menu-level1-show trio-nav" id="fpcm-clear-cache" title="<?php $FPCM_LANG->write('GLOBAL_CACHE_CLEAR'); ?>">
                <a href="#" target="_blank">
                    <span class="fpcm-ui-center fpcm-navicon fa fa-recycle"></span>
                </a>
            </li>
            
            <li class="fpcm-menu-level1 fpcm-menu-level1-show trio-nav" id="fpcm-navigation-profile">
                <a href="#" target="_blank" class="fpcm-navigation-noclick">
                    <span class="fpcm-ui-center fpcm-navicon fa fa-user"></span>
                </a>
                <ul class="fpcm-submenu" id="fpcm-navigation-submenu-profile">
                    <li class="fpcm-menu-level2">
                        <a href="<?php print $FPCM_BASEMODULELINK; ?>system/profile" class="fpcm-loader" id="fpcm-open-profile">
                            <span class="fpcm-navicon fa fa-wrench"></span>
                            <span class="fpcm-navigation-descr"><?php $FPCM_LANG->write('PROFILE_MENU_OPENPROFILE'); ?></span>
                        </a>
                    </li>
                    <li class="fpcm-menu-level2">
                        <a href="<?php print $FPCM_BASEMODULELINK; ?>system/logout" class="fpcm-loader" id="fpcm-open-profile">
                            <span class="fpcm-navicon fa fa-sign-out"></span>
                            <span class="fpcm-navigation-descr"><?php $FPCM_LANG->write('LOGOUT_BTN'); ?></span>
                        </a>
                    </li>
                    <li class="fpcm-menu-level2 fpcm-navigation-submenu-profile-meta">
                        <span><b><?php $FPCM_LANG->write('PROFILE_MENU_LOGGEDINSINCE'); ?>:</b></span>
                        <span><?php \fpcm\model\view\helper::dateText($FPCM_SESSION_LOGIN); ?> (<?php print $FPCM_DATETIME_ZONE; ?>)</span>
                        <span><b><?php $FPCM_LANG->write('PROFILE_MENU_YOURIP'); ?>:</b></span>
                        <span><?php print fpcm\classes\http::getIp(); ?></span>
                    </li>
                </ul>
            </li>

    <?php foreach ($FPCM_NAVIGATION as $navigationGroup) : ?>            
        <?php foreach ($navigationGroup as $groupName => $navigationItem) : ?>     
            <li class="fpcm-menu-level1 fpcm-menu-level1-show fpcm-ui-center">
                <a href="<?php print $FPCM_BASEMODULELINK.$navigationItem['url']; ?>" title="<?php $navigationItem['description']; ?>" class="<?php print $navigationItem['class']; ?> fpcm-loader" id="<?php print $navigationItem['id']; ?>">
                    <span class="fpcm-ui-center fpcm-navicon <?php print $navigationItem['icon']; ?>"></span>
                    <span class="fpcm-ui-center fpcm-navigation-descr"><?php print $navigationItem['description']; ?></span>
                </a>
                <?php if (isset($navigationItem['submenu']) && count($navigationItem['submenu'])) : ?>
                    <ul class="fpcm-submenu">
                        <?php foreach ($navigationItem['submenu'] as $submenuItem) : ?>                            
                            <li class="fpcm-menu-level2">
                                <a href="<?php print $FPCM_BASEMODULELINK.$submenuItem['url']; ?>" title="<?php $submenuItem['description']; ?>" class="<?php print $submenuItem['class']; ?> fpcm-loader" id="<?php print $submenuItem['id']; ?>">
                                    <?php if (isset($submenuItem['icon'])) : ?><span class="fpcm-navicon <?php print $submenuItem['icon']; ?>"></span><?php endif; ?>
                                    <span class="fpcm-navigation-descr"><?php print $submenuItem['description']; ?></span>
                                </a>
                            </li>
                            <?php if (isset($submenuItem['spacer']) && $submenuItem['spacer']) :?>
                                <div class="fpcm-admin-nav-modmgr-link"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>            
        <?php endforeach; ?>                  
    <?php endforeach; ?>
        </ul>

        <div class="fpcm-clear"></div>

        <?php fpcmDebugOutput(); ?>
    </div>
</div>
<?php endif; ?>