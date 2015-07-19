<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-clipboard fa-border"></span> <?php $FPCM_LANG->write('FPCM_CLASSICIMPORTER_HEADLINE'); ?></h1>
    
    <div class="fpcm-tabs-accordion-importer">
        <h2><?php $FPCM_LANG->write('FPCM_CLASSICIMPORTER_IMPORT_FPCM2'); ?></h2>
        <div><?php include __DIR__.'/fpcm2path.php'; ?></div>        
        
        <?php foreach ($importActions as $headline => $viewFile) : ?>
            <h2><?php $FPCM_LANG->write($headline); ?></h2>
            <div><?php include __DIR__.'/'.$viewFile; ?></div>
        <?php endforeach; ?>
    </div>
</div>