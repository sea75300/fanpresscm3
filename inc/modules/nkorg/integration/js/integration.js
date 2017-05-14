if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_integration = {

    init: function() {

        fpcm.ui.accordion('.fpcm-tabs-accordion-integration');

        jQuery('#btnSpacerArticleTitle').click(function() {
            fpcm.ui.showLoader(true);
            fpcm.ajax.post('nkorg/integration/articletitle', {
                data: {
                    spacertext: jQuery('#spacertextArticle').val()
                },
                execDone: function () {
                    fpcm.ui.showLoader(false);
                    fpcm.ui.assignText('#codearticletitle', fpcm.ajax.getResult('nkorg/integration/articletitle'));
                }
            });

            return false;
        });

        jQuery('#btnSpacerPageTitle').click(function() {
            fpcm.ui.showLoader(true);
            fpcm.ajax.post('nkorg/integration/pagetitle', {
                data: {
                    spacertext: jQuery('#spacertextPage').val()
                },
                execDone: function () {
                    fpcm.ui.showLoader(false);
                    fpcm.ui.assignText('#codepagetitle', fpcm.ajax.getResult('nkorg/integration/pagetitle'));
                }
            });

            return false;
        });

        jQuery('#btnLimitListSetShowArticles').click(function() {
            fpcm.ui.showLoader(true);
            fpcm.ui.assignText('#limitListSpanShowArticles', jQuery('#limitListShowArticles').val());
            fpcm.ui.showLoader(false);

            return false;
        });

        jQuery('#btnLimitListSetShowArchive').click(function() {
            fpcm.ui.showLoader(true);
            fpcm.ui.assignText('#limitListSpanShowArchive', jQuery('#limitListShowArchive').val());
            fpcm.ui.showLoader(false);

            return false;
        });

        jQuery('#btnShowLatestLimitSet').click(function() {
            fpcm.ui.showLoader(true);
            fpcm.ui.assignText('#showLatestLimitSpan', jQuery('#showLatestLimit').val());
            fpcm.ui.showLoader(false);

            return false;
        });
        
    }

};