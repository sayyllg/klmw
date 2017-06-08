/*
 * 视图文件
 * createDate:2016-11-02 10:03:51
 * author: XXXXXX
 */

var color = {
    as: '#00a8f7',
    member: '#33cafc',
    group: '#67d94f',
    file: '#f5e806',
    mail: '#fbb51f',
    task: '#eb5f4a',
    canlender: '#f98eb1',
    project: '#9b98ff'
}
Ehr.module('Charts', function(Charts, Ehr, Backbone, Marionette, $, _) {
    var Views = {};
    var model = new Backbone.Model({});
    Views.LineViews = Marionette.LayoutView.extend({
        template: Charts.Templates.itemView,
        initialize: function(options) {
            _.extend(this, options);
            this.model = new Charts.Entities.Model();
            this.model.set(this.datas);
            var maxList = [];
            _.each(this.datas.datasets, function(item) {
                var list = [];
                _.each(item.data, function(i) {
                    list.push(parseInt(i));
                })
                var newMaxList = _.sortBy(list);
                maxList.push((newMaxList[newMaxList.length - 1]));
            });
            var MaxList = _.sortBy(maxList);
            this.number = (Math.max.apply(null, MaxList).toString().length);


            this.bindEvent();
        },
        bindEvent: function() {
            var self = this;
            this.model.bind('change', function() {
                self.resetView();
            })
        },
        _init_chart: function() {
            var self = this;
            this.chart = new Chart(this.container[0], {
                type: 'line',
                data: this.model.toJSON(),
                pointHoverRadius: 30,
                pointBorderWidth:30,
                options: {
                    responsive: true,
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: Math.pow(10, this.number - 1),
                            }
                        }]
                    },
                    hover: {
                        mode: 'single',
                    },
                    tooltips: {
                        backgroundColor: '#00a8f7',
                        position: 'nearest',
                        opacity: 0.5,
                        titleFontSize: 12,
                        titleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                        titleMarginBottom: -36,
                        bodyFontSize: 18,
                        bodySpacing: 4,
                        bodyFontStyle: 'bold',
                        xPadding: 20,
                        yPadding: 28,
                        caretSize: 8,
                        shadow: true,
                        callbacks: {
                            label: function(tooltipItems, data) {
                                if (tooltipItems.yLabel != 0) {
                                    return tooltipItems.yLabel;
                                } else {
                                    return '0';
                                }
                            }
                        }
                    },
                },
            })
        },
        onShow: function() {
            var self = this;
            this.resetView();
        },
        resetView: function() {
            var windowW = $(document).width();
            if (this.container) {
                $('.chartjs-hidden-iframe').remove();
                this.container.remove();
                this.chart = null;
            }
            this.container = $('<canvas class="charts-w chart-' + this["chartId"] + '" id="chart-' + this["chartId"] + '"></canvas>');
            this.$el.append(this.container);
            this._init_chart()
        }
    })
    Views.BarViews = Views.LineViews.extend({
        _init_chart: function() {
            
            var max = 0;
            _.each(this.model.get("datasets")[0]['data'],function(i){
                if(parseInt(i)>max){
                    max = parseInt(i)
                }
            })

            this.chart = new Chart(this.container[0], {
                type: 'horizontalBar',
                data: this.model.toJSON(),
                options: {
                    legend: {
                        display: false,
                    },
                    defaultFontSize: 12,
                    hover: {
                        mode: 'label',
                        animationDuration: 0,
                    },
                    tooltips: {
                        enabled: false,

                    },
                    scales: {
                        yAxes:[{
                            gridLines: {
                                display: false
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize:parseInt((max+parseInt(max/5))/5)
                            }
                        }]
                    },
                    animation: {
                        onComplete: function() {
                            var chartInstance = this.chart;
                            var ctx = chartInstance.ctx;
                            ctx.fillStyle = '#999';
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize + 2, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = "left";
                            Chart.helpers.each(this.data.datasets.forEach(function(dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                Chart.helpers.each(meta.data.forEach(function(bar, index) {
                                    // console.log(bar._chart.width,bar._model.x+20,bar)
                                    ctx.fillText(dataset.data[index], bar._model.x+10, bar._model.y + 4);
                                }), this)
                            }), this);
                        }
                    }
                }
            })
        }
    })
    Charts.Views = Views;
})
