<?php if (isset($FPCM_NAVIGATION) && $FPCM_LOGGEDIN) : ?>
<div class="fpcm-admin-navi">
    <ul class="fpcm-menu">
        <?php foreach ($FPCM_NAVIGATION as $navigationGroup) : ?>            
            <?php foreach ($navigationGroup as $groupName => $navigationItem) : ?>     
                <li>
                    <a href="<?php print $FPCM_BASEMODULELINK.$navigationItem['url']; ?>" title="<?php $navigationItem['description']; ?>" class="<?php print $navigationItem['class']; ?> fpcm-loader" id="<?php print $navigationItem['id']; ?>">
                        <span class="<?php print $navigationItem['icon']; ?>"></span>
                        <span class="fpcm-nav-link-descr fpcm-nav-link-descr-main"><?php print $navigationItem['description']; ?></span>
                    </a>
                    <?php if (isset($navigationItem['submenu']) && count($navigationItem['submenu'])) : ?>
                        <ul class="fpcm-submenu">
                            <?php foreach ($navigationItem['submenu'] as $submenuItem) : ?>                            
                                <li>
                                    <a href="<?php print $FPCM_BASEMODULELINK.$submenuItem['url']; ?>" title="<?php $submenuItem['description']; ?>" class="<?php print $submenuItem['class']; ?> fpcm-loader" id="<?php print $submenuItem['id']; ?>">
                                        <?php if (isset($submenuItem['icon'])) : ?><span class="<?php print $submenuItem['icon']; ?>"></span><?php endif; ?>
                                        <span class="fpcm-nav-link-descr"><?php print $submenuItem['description']; ?></span>
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
    
    <div class="fpcm-navigation-hide">
        <a href="" onclick="return false;">
            <span class="fa fa-arrow-circle-left" title="<?php $FPCM_LANG->write('NAVIGATION_HIDE'); ?>"></span>
        </a>
    </div>    
</div>
<?php endif; ?>