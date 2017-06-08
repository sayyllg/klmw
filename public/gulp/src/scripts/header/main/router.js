
/*
* 路由文件
* createDate:2016-05-20 14:39:43
* author: XXXXXX
*/
Ehr.module('Header.Router', function(Router, Ehr, Backbone, Marionette, $, _){

	Router.startWithParent = true;

	Router.Router = Ehr.AppRouter.extend({
		appRoutes:{
			'header':'header',
		}
	});

	Router.Controller = Marionette.Controller.extend({
		header: function(){
			console.log('header')
		}
	});

	Router.on('start', function(){
		new Router.Router({
			controller: new Router.Controller
		});
	});

});
