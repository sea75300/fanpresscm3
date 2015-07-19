<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-university"></span> <?php $FPCM_LANG->write('NKORG_INTEGRATION_HEADLINE'); ?></h1>
    
    <div class="fpcm-tabs-accordion-integration">
        <h2><?php $FPCM_LANG->write('NKORG_INTEGRATION_STARTNOTE'); ?></h2>
        <div><p><?php $FPCM_LANG->write('NKORG_INTEGRATION_WELCOME'); ?></p></div>     
        
        <?php foreach ($chapters as $headline => $viewFile) : ?>
            <h2><?php $FPCM_LANG->write($headline); ?></h2>
            <div><?php include __DIR__.'/'.$viewFile.'.php'; ?></div>
        <?php endforeach; ?>
    </div>
</div>