if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.notifications.nkorg_example_callback = function() {
    
    fpcm.ui.addMessage({
        type : 'notice',
        id   : 'nkorg_example_callback',
        icon : 'bell',
        txt  : fpcm.ui.translate('This is a notification callback function')
    }, true);

};