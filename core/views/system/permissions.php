<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-key"></span> <?php $FPCM_LANG->write('HL_OPTIONS_PERMISSIONS'); ?></h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=system/permissions">
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-permissions-articles"><?php $FPCM_LANG->write('PERMISSION_ARTICLES'); ?> / <?php $FPCM_LANG->write('PERMISSION_COMMENTS'); ?> / <?php $FPCM_LANG->write('PERMISSION_UPLOADS'); ?></a></li>
                <li><a href="#tabs-permissions-system"><?php $FPCM_LANG->write('PERMISSION_SYSTEM'); ?> / <?php $FPCM_LANG->write('PERMISSION_MODULES'); ?></a></li>
            </ul>

            <div id="tabs-permissions-articles">
                <table class="fpcm-ui-table fpcm-ui-permissions fpcm-ui-permissions-article">
                    <tr>
                        <th></td>
                        <th><?php $FPCM_LANG->write('PERMISSION_ARTICLES'); ?></th>
                        <th><?php $FPCM_LANG->write('PERMISSION_COMMENTS'); ?></th>
                        <th><?php $FPCM_LANG->write('PERMISSION_UPLOADS'); ?></th>
                    </tr>
                    <tr class="fpcm-td-spacer"><td></td></tr>                    
                    <?php foreach ($permissions as $group => $permissionData) : ?>
                    <?php if (!isset($userRolls[$group])) continue; ?>
                    <tr>
                        <td><?php print \fpcm\model\view\helper::escapeVal($userRolls[$group]); ?></td>
                        <td>
                            <div class="fpcm-ui-buttonset fpcm-ui-buttonset-permissions">
                                <?php foreach ($permissionData['article'] as $key => $value) : ?>
                                    <?php fpcm\model\view\helper::checkbox("permissions[$group][article][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_ARTICLE_'.strtoupper($key)), "{$group}_article_{$key}", $value, false); ?>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td>
                            <div class="fpcm-ui-buttonset fpcm-ui-buttonset-permissions">
                            <?php foreach ($permissionData['comment'] as $key => $value) : ?>
                            <?php fpcm\model\view\helper::checkbox("permissions[$group][comment][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_COMMENT_'.strtoupper($key)), "{$group}_comment_{$key}", $value, false); ?>
                            <?php endforeach; ?>
                            </div>
                        </td> 
                        <td>
                            <div class="fpcm-ui-buttonset fpcm-ui-buttonset-permissions">
                            <?php foreach ($permissionData['uploads'] as $key => $value) : ?>
                                <?php fpcm\model\view\helper::checkbox("permissions[$group][uploads][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_UPLOADS_'.strtoupper($key)), "{$group}_uploads_{$key}", $value, false); ?>
                            <?php endforeach; ?>
                            </div>
                        </td>                        
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <div id="tabs-permissions-system">
                <table class="fpcm-ui-table fpcm-ui-permissions fpcm-ui-permissions-system">
                    <tr>
                        <th></td>
                        <th><?php $FPCM_LANG->write('PERMISSION_SYSTEM'); ?></th>
                        <th><?php $FPCM_LANG->write('PERMISSION_MODULES'); ?></th>
                        <th></td>
                    </tr>
                    <tr class="fpcm-td-spacer"><td></td></tr>
                    <?php foreach ($permissions as $group => $permissionData) : ?>
                    <?php if (!isset($userRolls[$group])) continue; ?>
                    <tr>
                        <td><strong><?php print \fpcm\model\view\helper::escapeVal($userRolls[$group]); ?></strong></td>
                        <td>
                            <div class="fpcm-ui-buttonset fpcm-ui-buttonset-permissions">
                            <?php foreach ($permissionData['system'] as $key => $value) : ?>
                            <?php $readOnly = ($key == 'permissions' && $group == 1) ? true : false; ?>
                            <?php fpcm\model\view\helper::checkbox("permissions[$group][system][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_SYSTEM_'.strtoupper($key)), "{$group}_system_{$key}", $value, $readOnly); ?>
                            <?php if ($readOnly) : ?><input type="hidden" name="<?php print "permissions[$group][system][$key]"; ?>" value="1"><?php endif; ?>
                            <?php endforeach; ?>
                            </div>
                        </td>
                        <td>
                            <div class="fpcm-ui-buttonset fpcm-ui-buttonset-permissions">
                            <?php foreach ($permissionData['modules'] as $key => $value) : ?>
                                <?php fpcm\model\view\helper::checkbox("permissions[$group][modules][$key]", '', 1, $FPCM_LANG->translate('PERMISSION_MODULES_'.strtoupper($key)), "{$group}_modules_{$key}", $value, false); ?>
                            <?php endforeach; ?>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <?php endforeach; ?>
               </table>                    
            </div>
        </div>

        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
            <table>
                <tr>
                    <td><?php fpcm\model\view\helper::saveButton('permissionsSave', 'fpcm-loader'); ?></td>
                </tr>
            </table>
        </div>

        <?php \fpcm\model\view\helper::pageTokenField(); ?>
        
    </form> 
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmJs.permissionButtonIcons();
    });
</script>