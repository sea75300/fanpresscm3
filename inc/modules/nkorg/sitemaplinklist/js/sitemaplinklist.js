jQuery(document).ready(function() {
    fpcmJs.setFocus('xmlfilepath');
    
    jQuery('#btnSitemaplinklistCheckPath').click(function() {
        
        jQuery.ajax({
            url: fpcmAjaxActionPath + 'nkorg/sitemaplinklist/checkpath',
            type: 'POST',
            data: {
                'path' : jQuery('#xmlfilepath').val()
            }
        })
        .done(function(result) {
            fpcmJs.showLoader(false);

            if (result == '0') {
                fpcmJs.addAjaxMassage('error', 'NKORG_SITEMAPLINKLIST_CHECKPATH_FAILED');
                return false;
            } else {
                fpcmJs.addAjaxMassage('notice', 'NKORG_SITEMAPLINKLIST_CHECKPATH_OK');
                setTimeout(function() {
                    window.location.reload();
                }, 2500)
            }
        })
        .fail(function() {
            alert(fpcmAjaxErrorMessage);
        });
        
        return false;
    });
    
    jQuery('#btnSaveSelectedLinks').click(function () {
        var selectedLinks = [];
        jQuery('.fpcm-sitemaplinklist-activelinks:checked').map(function (idx, item) {
            selectedLinks.push(jQuery(item).val());
        });
        
        jQuery.ajax({
            url: fpcmAjaxActionPath + 'nkorg/sitemaplinklist/savelinks',
            type: 'POST',
            data: {
                'selectedLinks' : JSON.stringify(selectedLinks)
            }
        })
        .done(function(result) {
            fpcmJs.showLoader(false);

            if (result == '0') {
                fpcmJs.addAjaxMassage('error', 'NKORG_SITEMAPLINKLIST_SAVED_FAILED');
                return false;
            } else {
                fpcmJs.addAjaxMassage('notice', 'NKORG_SITEMAPLINKLIST_SAVED_OK');
                setTimeout(function() {
                    window.location.reload();
                }, 2500)
            }
        })
        .fail(function() {
            alert(fpcmAjaxErrorMessage);
        });
        
        return false;
    });
});
