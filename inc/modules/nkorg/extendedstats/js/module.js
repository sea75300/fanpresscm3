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

        nkorgExtStatsCharValues.datasets[0].borderWidth = (type === 'line' ? 5 : 0);
        
        var isBarOrLine = (type === 'line' || type === 'bar');
        
        var chartOptions = {
            legend: {
                display : (isBarOrLine ? false : true),
                position: 'bottom',
                labels  : {
                    boxWidth: 25,
                    fontSize: 10                    
                }
            },
            responsive: true
        }
        
        if (isBarOrLine) {

            chartOptions.scales = {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
            };

        }

        window.chart = new Chart(jQuery('#fpcm-nkorg-extendedstats-chart'), {
            type: type,
            data: nkorgExtStatsCharValues,
            options: chartOptions
        });
    }

};