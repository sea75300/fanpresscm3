jQuery(document).ready(function() {
    jQuery('.fpcm-tabs-accordion-integration').accordion({
        header: 'h2',
        heightStyle: 'content'
    });
    
    jQuery('#btnSpacerArticleTitle').click(function() {
        fpcmJs.showLoader(true);

        fpcmAjax.action   = 'nkorg/integration/articletitle';
        fpcmAjax.data     = { spacertext: jQuery('#spacertextArticle').val() };
        fpcmAjax.execDone = "fpcmJs.showLoader(false);fpcmJs.assignText('#codearticletitle', fpcmAjax.result);";
        fpcmAjax.post();
        
        return false;
    });
    
    jQuery('#btnSpacerPageTitle').click(function() {
        fpcmJs.showLoader(true);

        fpcmAjax.action   = 'nkorg/integration/pagetitle';
        fpcmAjax.data     = { spacertext: jQuery('#spacertextPage').val() };
        fpcmAjax.execDone = "fpcmJs.showLoader(false);fpcmJs.assignText('#codepagetitle', fpcmAjax.result);";
        fpcmAjax.post();
        
        return false;
    });
});