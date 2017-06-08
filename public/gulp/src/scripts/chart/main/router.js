
/*
* 路由文件
* createDate:2016-11-02 10:03:51
* author: XXXXXX
*/
Ehr.module('Charts', function(Charts, Ehr, Backbone, Marionette, $, _){
	var Router = {};
	Router.Router = Ehr.AppRouter.extend({
		appRoutes:{
		}
	});

	Router.Controller = Marionette.Controller.extend({
		Charts: function(){
			Ehr.Charts.StartApp();
		}
	});

	Charts.on('start', function(){
		new Router.Router({
			controller: new Router.Controller
		});
	});

	Charts.Router = Router

});
