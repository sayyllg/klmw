
/*
* 主文件
* createDate:2016-05-20 14:39:47
* author: XXXXXX
*/
Ehr.module('Footer', function(Footer, Ehr, Backbone, Marionette, $, _){

	Footer.Controller = Marionette.Controller.extend({
		initialize: function(options){
			this.options = options;
		},
	});

	Footer.StartApp =  function(options){
		Footer.Controllers = new Footer.Controller(options);
	};

	Footer.StopApp = function(options){
		console.log('stop');
	};

})
