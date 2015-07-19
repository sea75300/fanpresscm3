<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-truck fa-fw"></span> <?php $FPCM_LANG->write('NKORG_MODULECREATOR_HEADLINE'); ?></h1>
    
    <div class="fpcm-tabs-general">
        <ul>
            <li><a href="#fpcm-nkorgmodulecreator-general"><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL'); ?></a></li>
            <li><a href="#fpcm-nkorgmodulecreator-events"><?php $FPCM_LANG->write('NKORG_MODULECREATOR_EVENTLIST'); ?></a></li>
            <li><a href="#fpcm-nkorgmodulecreator-depenencies"><?php $FPCM_LANG->write('NKORG_MODULECREATOR_DEPENDENCIES'); ?></a></li>
            <li><a href="#fpcm-nkorgmodulecreator-create"><?php $FPCM_LANG->write('NKORG_MODULECREATOR_CREATESTRUCTURE'); ?></a></li>
        </ul>
        
        <form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $FPCM_CURRENT_MODULE; ?>&key=nkorg/modulecreator">
            <div id="fpcm-nkorgmodulecreator-general">
                <?php include __DIR__.'/general.php'; ?>
            </div>

            <div id="fpcm-nkorgmodulecreator-events">
                <?php include __DIR__.'/events.php'; ?>
            </div>

            <div id="fpcm-nkorgmodulecreator-depenencies">
                <?php include __DIR__.'/dependencies.php'; ?>
            </div>

            <div id="fpcm-nkorgmodulecreator-create">
                <?php include __DIR__.'/create.php'; ?>
            </div>            
        </form>
    </div>
</div>