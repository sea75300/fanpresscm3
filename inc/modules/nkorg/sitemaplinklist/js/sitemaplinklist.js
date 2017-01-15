jQuery(document).ready(function() {
    fpcmJs.setFocus('xmlfilepath');
    
    jQuery('#btnSitemaplinklistCheckPath').click(function() {

        fpcm.ajax.post('nkorg/sitemaplinklist/checkpath', {
            data: {
                path: jQuery('#xmlfilepath').val()
            },
            execDone: function () {
                chechPathDone(fpcm.ajax.getResult('nkorg/sitemaplinklist/checkpath'));
            }
        });
        
        return false;
    });
    
    jQuery('#btnSaveSelectedLinks').click(function () {
        var selectedLinks = [];
        jQuery('.fpcm-sitemaplinklist-activelinks:checked').map(function (idx, item) {
            selectedLinks.push(jQuery(item).val());
        });

        fpcm.ajax.post('nkorg/sitemaplinklist/savelinks', {
            data: {
                selectedLinks: fpcm.ajax.toJSON(selectedLinks)
            },
            execDone: function () {
                saveLinksDone(fpcm.ajax.getResult('nkorg/sitemaplinklist/savelinks'));
            }
        });
         
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