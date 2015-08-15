<table class="fpcm-ui-table fpcm-ui-options">
    <tr>
        <td><?php $FPCM_LANG->write('GLOBAL_USERNAME'); ?>:</td>
        <td>
            <?php if (isset($inProfile) && $inProfile) : ?>
                <?php \fpcm\model\view\helper::textInput('username','',$author->getUserName(), true); ?>
            <?php else : ?>                
                <?php \fpcm\model\view\helper::textInput('username','',$author->getUserName()); ?>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td><?php $FPCM_LANG->write('GLOBAL_PASSWORD'); ?>:</td>
        <td>
            <?php \fpcm\model\view\helper::passwordInput('password', 'fpcm-usereditor-password') ?>
            <span class="fa fa-question-circle fa-fw fpcm-ui-shorthelp" title="<?php $FPCM_LANG->write('USERS_REQUIREMENTS'); ?>"></span>
        </td>
    </tr>
    <tr>
        <td><?php $FPCM_LANG->write('USERS_PASSWORD_CONFIRM'); ?>:</td>
        <td><?php \fpcm\model\view\helper::passwordInput('password_confirm'); ?></td>
    </tr>                
    <tr>
        <td><?php $FPCM_LANG->write('USERS_DISPLAYNAME'); ?>:</td>
        <td><?php \fpcm\model\view\helper::textInput('displayname','',$author->getDisplayName()); ?></td>
    </tr>
    <tr>
        <td><?php $FPCM_LANG->write('GLOBAL_EMAIL'); ?>:</td>
        <td><?php \fpcm\model\view\helper::textInput('email','',$author->getEmail()); ?></td>
    </tr>
    <tr>
        <td><?php $FPCM_LANG->write('USERS_ROLL'); ?>:</td>
        <td>
            <?php if (isset($inProfile) && $inProfile) : ?>
                <?php \fpcm\model\view\helper::select('roll', $userRolls, $author->getRoll(), false, false, true); ?>
            <?php else : ?>                
                <?php \fpcm\model\view\helper::select('roll', $userRolls, $author->getRoll(), false, false); ?>
            <?php endif; ?>                
        </td>
    </tr>        
</table>            

<?php if (!isset($externalSave)) : ?>
<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
    <table>
        <tr>
            <td><?php \fpcm\model\view\helper::saveButton('userSave'); ?></td>
        </tr>
    </table>
</div>
<?php endif; ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmJs.setFocus('username');
    });
</script>

<?php \fpcm\model\view\helper::pageTokenField(); ?>