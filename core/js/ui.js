/**
 * FanPress CM UI Namespace
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.ui = {
    
    dialog: function(params) {

        if (params.title === undefined) {
            params.title = '';
        }

        if (params.id === undefined) {
            params.id = (new Date()).getTime();
        }

        if (params.dlWidth === undefined) {
            params.dlWidth = 500;
        }

        if (params.modal === undefined) {
            params.modal = true;
        }

        if (params.resizable === undefined) {
            params.resizable = false;
        }
        
        var dialogId = 'fpcm-dialog-'+  params.id;
        if (params.content !== undefined) {
            fpcmJs.appendHtml('#fpcm-body', '<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="' + dialogId + '">' +  params.content + '</div>');
        }
        
        var dlParams = {};
        dlParams.width    = params.dlWidth;        
        dlParams.modal    = params.modal;
        dlParams.resizable= params.resizable;
        dlParams.title    = params.title;
        dlParams.buttons  = params.dlButtons;
        dlParams.open     = params.dlOnOpen;
        dlParams.close    = params.dlOnClose;
        
        if (params.dlHeight !== undefined) {
            dlParams.height   = params.dlHeight;            
        }
        
        if (params.dlMinHeight !== undefined) {
            dlParams.minWidth   = params.dlMinHeight;            
        }
        
        if (params.dlMinHeight !== undefined) {
            dlParams.minHeight   = params.dlMinHeight;            
        }
        
        jQuery('#' + dialogId).dialog(dlParams);

        return true;
    }
    
}