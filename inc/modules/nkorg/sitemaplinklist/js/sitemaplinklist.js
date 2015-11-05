jQuery(document).ready(function() {
    fpcmJs.setFocus('xmlfilepath');
    
    jQuery('#btnSitemaplinklistCheckPath').click(function() {
        
        fpcmAjax.action = 'nkorg/sitemaplinklist/checkpath';
        fpcmAjax.data   = {path:jQuery('#xmlfilepath').val()};
        fpcmAjax.execDone = 'chechPathDone(fpcmAjax.result);';
        fpcmAjax.post();        
        
        return false;
    });
    
    jQuery('#btnSaveSelectedLinks').click(function () {
        var selectedLinks = [];
        jQuery('.fpcm-sitemaplinklist-activelinks:checked').map(function (idx, item) {
            selectedLinks.push(jQuery(item).val());
        });
        
        fpcmAjax.action = 'nkorg/sitemaplinklist/savelinks';
        fpcmAjax.data   = {selectedLinks:JSON.stringify(selectedLinks)};
        fpcmAjax.execDone = 'saveLinksDone(fpcmAjax.result);';
        fpcmAjax.post();   
         
        return false;
    });
});

function chechPathDone(ajaxResult) {
    fpcmJs.showLoader(false);

    if (ajaxResult == '0') {
        fpcmJs.addAjaxMassage('error', 'NKORG_SITEMAPLINKLIST_CHECKPATH_FAILED');
        return false;
    } else {
        fpcmJs.addAjaxMassage('notice', 'NKORG_SITEMAPLINKLIST_CHECKPATH_OK');
        setTimeout(function() {
            window.location.reload();
        }, 2500)
    }
}

function saveLinksDone(ajaxResult) {
    fpcmJs.showLoader(false);

    if (ajaxResult == '0') {
        fpcmJs.addAjaxMassage('error', 'NKORG_SITEMAPLINKLIST_SAVED_FAILED');
        return false;
    } else {
        fpcmJs.addAjaxMassage('notice', 'NKORG_SITEMAPLINKLIST_SAVED_OK');
        setTimeout(function() {
            window.location.reload();
        }, 2500)
    }    
}