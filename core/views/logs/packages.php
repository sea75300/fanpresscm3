<div class="fpcm-accordion-pkgmanager">
    <?php foreach ($packagesLogs as $value) : ?>
        <?php if (!is_object($value) || !is_array($value->text)) continue; ?>
        <h2><?php print $value->time?>: <?php print $value->pkgname; ?></h2>
        <div>
            <ul>
                <?php foreach ($value->text as $line) : ?>
                <li><?php print $line; ?></li>
                <?php endforeach; ?>                
            </ul>
        </div>
    <?php endforeach; ?>       
</div>