if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_extendedstats = {

    init: function() {
        fpcm.nkorg_extendedstats.drawChart(nkorgExtStatsChartType);
        
        fpcm.ui.datepicker('#dateFrom', {
            changeMonth: true,
            changeYear: true,
            minDate: nkorgExtStatsMinDate
        });
        fpcm.ui.datepicker('#dateTo', {
            changeMonth: true,
            changeYear: true
        });
        
        fpcm.ui.selectmenu('#chartType', {
            change: function () {
                jQuery('#fpcm-nkorg-extendedstats-chart').empty();
                fpcm.nkorg_extendedstats.drawChart(jQuery(this).val());
            }
            
        });

    },
    
    drawChart: function (type) {
        
        if (window.chart) {
            window.chart.destroy();
        }

        window.chart = new Chart(jQuery('#fpcm-nkorg-extendedstats-chart'), {
            type: type,
            data: nkorgExtStatsCharValues,
            options: {
                legend: {
                    display: false
                }
            }
        });
    }

};