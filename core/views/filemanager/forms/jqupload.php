<link rel="stylesheet" type="text/css" href="<?php print $jquploadPath ?>css/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php print $jquploadPath ?>css/jquery.fileupload-ui.css">
<noscript><link rel="stylesheet" type="text/css" href="<?php print $jquploadPath ?>css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" type="text/css" href="<?php print $jquploadPath ?>css/jquery.fileupload-ui-noscript.css"></noscript>

<form id="fileupload" action="<?php print $actionPath; ?>" method="POST" enctype="multipart/form-data">
    <div class="fileupload-buttonbar">
        <div class="fileupload-progress fade" style="display:none;margin:10px 0;">
            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>    
    
    <table role="presentation" class="fpcm-ui-table fpcm-ui-uploadlist">
        <tbody class="files"></tbody>
    </table>
    
    <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fileupload-buttonbar">
        <div class="fileupload-buttons">
            <span class="fileinput-button">
                <span><?php $FPCM_LANG->write('FILE_FORM_FILEADD'); ?></span>
                <input type="file" name="files[]" multiple>
            </span>
            <button type="submit" class="start"><?php $FPCM_LANG->write('FILE_FORM_UPLOADSTART'); ?></button>
            <button type="reset" class="cancel"><?php $FPCM_LANG->write('FILE_FORM_UPLOADCANCEL'); ?></button>
            <span class="fileupload-process"></span>
        </div>
    </div>
</form>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="name">{%=file.name%}</span>
            <strong class="error"></strong>
        </td>

        <td class="jqupload-row-buttons">
            {% if (!i && !o.options.autoUpload) { %}
                <button class="start jqupload-btn"><?php $FPCM_LANG->write('FILE_FORM_UPLOADSTART'); ?></button>
            {% } %}
            {% if (!i) { %}
                <button class="cancel jqupload-btn"><?php $FPCM_LANG->write('FILE_FORM_UPLOADCANCEL'); ?></button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">

</script>

<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php print $jquploadPath ?>js/template.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php print $jquploadPath ?>js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php print $jquploadPath ?>js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php print $jquploadPath ?>js/jquery.fileupload-process.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php print $jquploadPath ?>js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php print $jquploadPath ?>js/jquery.fileupload-ui.js"></script>
<!-- The File Upload jQuery UI plugin -->
<script src="<?php print $jquploadPath ?>js/jquery.fileupload-jquery-ui.js"></script>
<!-- The main application script -->
<script src="<?php print $jquploadPath ?>js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?php print $jquploadPath ?>js/cors/jquery.xdr-transport.js"></script>
<![endif]-->