<table class="fpcm-ui-table">
    <?php include __DIR__.'/replacementhead.php'; ?>
    <tr>
        <td class="fpcm-ui-template-replacements ui-widget-content ui-corner-all ui-state-normal">
            <dl>
            <?php foreach ($replacementsArticle as $tag => $descr) : ?>
                <dt><?php print $tag; ?></dt>        
                <dd><?php print $descr; ?></dd>
            <?php endforeach; ?>
            </dl>
        </td>
    </tr>
    <?php include __DIR__.'/editorhead.php'; ?>
    <tr>
        <td>
            <?php fpcm\model\view\helper::textArea('template[article]', 'fpcm-full-width', $contentArticle); ?>
        </td>
    </tr>                    
</table>

<script type="text/javascript">initCodeMirrorTemplates('templatearticle');</script>