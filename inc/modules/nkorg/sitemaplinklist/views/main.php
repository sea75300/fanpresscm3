<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-sitemap fa-fw"></span> <?php $FPCM_LANG->write('NKORG_SITEMAPLINKLIST_HEADLINE'); ?></h1>

    <div class="fpcm-tabs-general">
        
        <ul>
            <li><a href="#filepathform"><?php $FPCM_LANG->write('NKORG_SITEMAPLINKLIST_SITEMAPPATH'); ?></a></li>
            <li><a href="#linklist"><?php $FPCM_LANG->write('NKORG_SITEMAPLINKLIST_LINKSELECTTION'); ?></a></li>
        </ul>
        
        <div id="filepathform">
            <table class="fpcm-ui-table fpcm-ui-options">
                <tr>			
                    <td><?php fpcm\model\view\helper::textInput('xmlfilepath', '', $savedpath); ?></td>
                    <td><?php \fpcm\model\view\helper::button('submit', 'sitemaplinklistCheckPath', 'GLOBAL_OK') ?></td>
                </tr>
            </table>         
        </div>
        
        <div id="linklist">
        <?php if ($listcontent !== false) : ?>
            <ul>
            <?php foreach ($listcontent as $key => $value) : ?>            
                <li><?php fpcm\model\view\helper::checkbox('activelinks', 'fpcm-sitemaplinklist-activelinks', $key, $value, '', in_array($key, $activeLinks)); ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
            
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons fpcm-ui-articlelist-buttons">
            <table>
                <tr>
                    <td><?php fpcm\model\view\helper::saveButton('saveSelectedLinks'); ?></td>
                </tr>
            </table>
        </div>
        </div>
    </div>

</div>

