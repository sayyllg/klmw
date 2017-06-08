
/*
* 路由文件
* createDate:2016-05-20 14:39:47
* author: XXXXXX
*/
Ehr.module('Footer.Router', function(Router, Ehr, Backbone, Marionette, $, _){

	Router.startWithParent = true;

	Router.Router = Ehr.AppRouter.extend({
		appRoutes:{
			'footer':'footer',
		}
	});

	Router.Controller = Marionette.Controller.extend({
		footer: function(){
			console.log('footer')
		}
	});

	Router.on('start', function(){
		new Router.Router({
			controller: new Router.Controller
		});
	});

});
