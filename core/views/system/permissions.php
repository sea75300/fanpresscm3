<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-key"></span> <?php $FPCM_LANG->write('HL_OPTIONS_PERMISSIONS'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_options'); ?>
    </h1>

    <form method="post" action="<?php print $FPCM_SELF; ?>?module=system/permissions">
        <div class="fpcm-tabs-general" id="fpcm-tabs-permissions">
            <ul>
                <?php foreach ($permissions as $group => $permissionData) : ?>
                <li><a href="#tabs-permissions-group<?php print $group; ?>"><?php print \fpcm\model\view\helper::escapeVal($userRolls[$group]); ?></a></li>
                
                <?php endforeach; ?>
                
            </ul>

        <?php foreach ($permissions as $group => $permissionData) : ?>
            <?php if (!isset($userRolls[$group])) continue; ?>
            <div id="tabs-permissions-group<?php print $group; ?>">
                
                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $FPCM_LANG->write('PERMISSION_SYSTEM'); ?></h2>
                        <?php foreach ($permissionData['system'] as $key => $value) : ?>
                            <?php $readOnly = ($key == 'permissions' && $group == 1) ? true : false; ?>
                            <?php fpcm\model\view\helper::checkbox("permissions[$group][system][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_SYSTEM_'.strtoupper($key)), "{$group}_system_{$key}", $value, $readOnly); ?>
                            <?php if ($readOnly) : ?><input type="hidden" name="<?php print "permissions[$group][system][$key]"; ?>" value="1"><?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $FPCM_LANG->write('PERMISSION_ARTICLES'); ?></h2>
                        <?php foreach ($permissionData['article'] as $key => $value) : ?>
                            <?php fpcm\model\view\helper::checkbox("permissions[$group][article][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_ARTICLE_'.strtoupper($key)), "{$group}_article_{$key}", $value, false); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $FPCM_LANG->write('PERMISSION_COMMENTS'); ?></h2>
                        <?php foreach ($permissionData['comment'] as $key => $value) : ?>
                            <?php fpcm\model\view\helper::checkbox("permissions[$group][comment][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_COMMENT_'.strtoupper($key)), "{$group}_comment_{$key}", $value, false); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $FPCM_LANG->write('PERMISSION_MODULES'); ?></h2>
                        <?php foreach ($permissionData['modules'] as $key => $value) : ?>
                            <?php fpcm\model\view\helper::checkbox("permissions[$group][modules][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_MODULES_'.strtoupper($key)), "{$group}_modules_{$key}", $value, false); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $FPCM_LANG->write('PERMISSION_UPLOADS'); ?></h2>
                        <?php foreach ($permissionData['uploads'] as $key => $value) : ?>
                            <?php fpcm\model\view\helper::checkbox("permissions[$group][uploads][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_UPLOADS_'.strtoupper($key)), "{$group}_uploads_{$key}", $value, false); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="fpcm-clear"></div>

            </div>
        <?php endforeach; ?>
        </div>

        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
            <?php fpcm\model\view\helper::saveButton('permissionsSave', 'fpcm-loader'); ?>
        </div>

        <?php \fpcm\model\view\helper::pageTokenField(); ?>
        
    </form> 
</div>