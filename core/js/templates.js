/**
 * FanPress CM Templates Namespace
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.templates = {

    enabledEditors: {
        ed2: false,
        ed3: false,
        ed4: false,
        ed5: false,
        ed6: false,
    },

    getIdClass: function(id) {

        switch (id) {
            case 2:
                return 'templatearticleSingle';
                break;
            case 3:
                return 'templatecomment';
                break;
            case 4:
                return 'templatecommentForm';
                break;
            case 5:
                return 'templatelatestNews';
                break;
            case 6:
                return 'templatetweet';
                break;
        }
        
        return false;
    },

    initTemplatePreview: function() {
        
        jQuery('.fpcm-template-tab').click(function () {

            fpcmTemplateId = jQuery(this).data('tpl');

            var idClass = fpcm.templates.getIdClass(fpcmTemplateId);
            if (idClass !== false && !fpcm.templates.enabledEditors['ed' + fpcmTemplateId]) {
                fpcm.templates.initCodeMirror(idClass);
                fpcm.templates.enabledEditors['ed' + fpcmTemplateId] = true;
            }

            if (fpcmTemplateId == 7) {
                jQuery('#template_buttons').hide();
                jQuery('#article_template_buttons').show();
                return false;
            }
            
            jQuery('#template_buttons').show();            
            jQuery('#article_template_buttons').hide();
            
            if (fpcmTemplateId > 5) {
                jQuery('#showpreview').hide();
                fpcmJs.assignButtons();
                return false;
            }

            jQuery('#showpreview').show();
            fpcmJs.assignButtons();

            return false;
        });
        
        jQuery('#showpreview').click(function () {

            fpcmJs.appendHtml('#fpcm-dialog-templatepreview-layer', '<iframe id="fpcm-dialog-templatepreview-layer-frame" class="fpcm-full-width" src="' + fpcmActionPath + 'system/templatepreview&tid=' + fpcmTemplateId + '"></iframe>');
            fpcm.ui.dialog({
                id         : 'templatepreview-layer',
                dlWidth    : '75%',
                resizable  : true,
                title      : fpcm.ui.translate('previewHeadline'),
                dlButtons  : [
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                    
                        click: function() {
                            jQuery(this).dialog('close');
                            jQuery('.fpcm-dialog-templatepreview-layer-frame').remove();
                        }
                    }                            
                ],
                dlOnClose: function( event, ui ) {
                    jQuery(this).empty();
                }
            });
            
            return false;
        });
        
    },
    
    initCodeMirror: function(id) {

        var editorElement = document.getElementById(id);

        var editorParams = {
            lineNumbers: true,
            matchBrackets: true,
            lineWrapping: true,
            autoCloseTags: true,
            id: 'tpleditor-' + id,
            mode: "text/html",
            matchTags: {
                bothTags: true
            },
            extraKeys: {
                "Ctrl-Space": "autocomplete"
            },
            value: editorElement.innerHTML
        };

        var editor = CodeMirror.fromTextArea(editorElement, editorParams);
        editor.setOption('theme', 'mdn-like');

    }

};

jQuery(document).ready(function() {

    fpcm.templates.initCodeMirror('templatearticle');
    fpcm.templates.initTemplatePreview();

});