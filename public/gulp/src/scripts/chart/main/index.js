
/*
* 主文件
* createDate:2016-11-02 10:03:51
* author: XXXXXX
*/
Ehr.module('Charts', function(Charts, Ehr, Backbone, Marionette, $, _){
	Charts.Controller = Marionette.Controller.extend({
		initialize: function(options){
			this.options = options;
			console.log('Charts');
		},
	});

	Charts.StartApp =  function(options){
		Charts.Controllers = new Charts.Controller(options);
	};

	Charts.StopApp = function(options){
		console.log('stop');
	};

})
