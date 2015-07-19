<?php if (is_array($FPCM_MESSAGES) && count($FPCM_MESSAGES)) : ?>
<div id="fpcm-messages" class="fpcm-messages <?php if (!isset($nofade)) : ?>fpcm-messages-fadeout<?php endif; ?>">    
    <?php foreach ($FPCM_MESSAGES as $messageList) : ?>

        <?php foreach ($messageList as $msgtext => $msgtype) : ?>

        <div class="fpcm-message-box fpcm-message-<?php print $msgtype; ?>">
            <div class="fpcm-msg-icon">
                <span class="fa-stack fa-lg">
                    <span class="fa fa-square fa-stack-2x fa-inverse"></span>
                    <?php if ($msgtype == 'error') : ?>
                        <span class="fa fa-exclamation-triangle fa-stack-1x"></span>
                    <?php elseif ($msgtype == 'notice') : ?>
                        <span class="fa fa-info-circle fa-stack-1x"></span>
                    <?php elseif ($msgtype == 'neutral') : ?>
                        <span class="fa fa-comment-o fa-stack-1x"></span>
                    <?php endif; ?>
                </span>
            </div>

            <div class="fpcm-msg-text"><?php print $msgtext; ?></div>
            <div class="fpcm-clear"></div>
        </div>            

        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>