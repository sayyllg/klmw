/*
*   项目
*/

Ehr.module('Index', function(Index, Ehr, Backbone, Marionette, $, _){

    Index.Controller = Marionette.Controller.extend({

        initialize: function(options){
            var self = this;
            this.options = options;
            Ehr.module('Header').StartApp({app: 'index'});
            this.LayoutView = new Ehr.Index.Views.layoutView();
            this.collection = new Ehr.Index.Entities.collection();
            Ehr.mainRegion.show(this.LayoutView);
            this.collection.fetch({
                reset: true,
                success:function(){
                    self.hearts();        
                }
            });
            
        },

        paresDate: function(time){
            return moment(time).format('h:mm:ss');
        },
        hearts: function(){
            var self = this;
            self.labels = [];
            self.datasets = [];
            self.data = [];
            modeldata = self.collection.toJSON();
            _.each(_.sortBy(modeldata, 'created_at'), function(item) {
                var date = new Date((item.created_at - 0) * 1000);
                self.labels.push(self.paresDate(date));
                self.data.push(item.hearts);
            });
            var obj = {
                        fill: false,
                        data: self.data,
                        borderColor: '#eb5f4a',
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        pointBackgroundColor: 'rgba(255,255,255,1)',
                        pointHoverBackgroundColor: 'rgba(255,255,255,1)',
                        pointHoverBorderColor: '#eb5f4a',
                        pointHoverBorderWidth: 5,
            };
            self.datasets.push(obj);
            var view = new Ehr.Charts.Views.LineViews({
                chartId: 'heart',
                datas: {
                    labels: self.labels,
                    datasets: self.datasets,
                },
            });
            self.LayoutView.HeartsRegion.show(view);
        }
    });

    Index.StartApp =  function(options){
        Index.Controllers = new Index.Controller(options);
    };

    Index.StopApp = function(options){
        console.log('stop');
    };
    
})
