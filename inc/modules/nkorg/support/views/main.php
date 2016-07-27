<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-ambulance fa-fw"></span> FanPress CM Support Module</h1>

    <div class="fpcm-tabs-general">
        
        <ul>
            <li><a href="#dbconfig">DB-Verbindung</a></li>
            <li><a href="#tools">Tools</a></li>
        </ul>
        
        <div id="dbconfig">
            <ul>
            <?php foreach ($dbconfig as $key => $value) : ?>
                <li><strong><?php print $key; ?>:</strong> <?php print $value; ?></li>
            <?php endforeach; ?>
            </ul>            
        </div>
        
        <div id="tools">
            <ul>
                <li><a href="index.php?module=package/sysupdate&step=4" target="_blank">Updater</a></li>
                <li><a href="http://www.adminer.org/de/" target="_blank">Adminer</a></li>
                <li><a href="http://phpfm.sourceforge.net/" target="_blank">phpFileManager</a></li>
            </ul>            
        </div>
    </div>

</div>