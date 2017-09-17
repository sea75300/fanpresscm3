if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_extendedstats = {

    init: function() {
        fpcm.nkorg_extendedstats.drawChart('bar');
    },
    
    drawChart: function (type) {
        var context = jQuery('#fpcm-nkorg-extendedstats-chart');
        var chart = new Chart(context, {
            type: type,
            data: charValues,
            options: {
                legend: {
                    display: false
                }
            }
        });
    }

};