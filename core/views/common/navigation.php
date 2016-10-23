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
    <?php foreach ($FPCM_NAVIGATION as $navigationGroup) : ?>            
        <?php foreach ($navigationGroup as $groupName => $navigationItem) : ?>     
            <li <?php if ($navigationItem['id']) : ?>id="item<?php print $navigationItem['id']; ?>"<?php endif; ?> class="fpcm-menu-level1 fpcm-menu-level1-show fpcm-ui-center <?php if (substr($navigationItem['url'], 0, strlen($FPCM_NAVIGATION_ACTIVE)) === $FPCM_NAVIGATION_ACTIVE) : ?>fpcm-menu-active<?php endif; ?>">
                <a href="<?php print $FPCM_BASEMODULELINK.$navigationItem['url']; ?>" title="<?php $navigationItem['description']; ?>" class="<?php print $navigationItem['class']; ?> fpcm-loader" <?php if ($navigationItem['id']) : ?>id="<?php print $navigationItem['id']; ?>"<?php endif; ?>>
                    <span class="fpcm-ui-center fpcm-navicon <?php print $navigationItem['icon']; ?>"></span>
                    <span class="fpcm-ui-center fpcm-navigation-descr"><?php print $navigationItem['description']; ?></span>
                </a>
                <?php if (isset($navigationItem['submenu']) && count($navigationItem['submenu'])) : ?>
                    <ul class="fpcm-submenu">
                        <?php foreach ($navigationItem['submenu'] as $submenuItem) : ?>
                            <li <?php if ($submenuItem['id']) : ?>id="submenu-item<?php print $submenuItem['id']; ?>"<?php endif; ?> class="fpcm-menu-level2 <?php if (substr($submenuItem['url'], 0, strlen($FPCM_NAVIGATION_ACTIVE)) === $FPCM_NAVIGATION_ACTIVE) : ?>fpcm-menu-active<?php endif; ?>">
                                <a href="<?php print $FPCM_BASEMODULELINK.$submenuItem['url']; ?>" title="<?php $submenuItem['description']; ?>" class="<?php print $submenuItem['class']; ?> fpcm-loader" <?php if ($submenuItem['id']) : ?>id="<?php print $submenuItem['id']; ?>"<?php endif; ?>>
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

    </div>
    
    <?php fpcmDebugOutput(); ?>
</div>
<?php endif; ?>