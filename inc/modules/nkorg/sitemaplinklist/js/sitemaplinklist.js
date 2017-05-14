if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_stitemaplinklist = {
    
    init: function() {

        fpcm.ui.setFocus('xmlfilepath');

        jQuery('#btnSitemaplinklistCheckPath').click(function() {

            fpcm.ajax.post('nkorg/sitemaplinklist/checkpath', {
                data: {
                    path: jQuery('#xmlfilepath').val()
                },
                execDone: function () {
                    
                    ajaxResult = fpcm.ajax.getResult('nkorg/sitemaplinklist/checkpath');
                    ajaxResult = fpcm.ajax.fromJSON(ajaxResult);
                    
                    fpcm.ui.showLoader(false);
                    
                    fpcm.ui.addMessage(ajaxResult.data, true);

                    if (ajaxResult.code) {
                        setTimeout(window.location.reload, 2500);
                    }
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

                    ajaxResult = fpcm.ajax.getResult('nkorg/sitemaplinklist/savelinks');
                    fpcm.ui.showLoader(false);

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
            });

            return false;
        });

    }
};