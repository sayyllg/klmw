/******************************************************************
 *
 * 全局路由
 * creator： yjl
 * date: 2016-03-31
 *
 *******************************************************************/
Ehr.module('Router', function(Router, Ehr, Backbone, Marionette, $, _){
    Router.startWithParent = true;
    Router.Router = Ehr.AppRouter.extend({
        appRoutes:{
            '':'index',
            'index':'index',
            'test':'test',
            '*error':'fourOfour',
        }
    });
    Router.Controller = Marionette.Controller.extend({
        index: function(){
            Backbone.history.navigate('#index')
            Ehr.Index.StartApp();
        },
        test: function(){
            console.log('test');
        },
        fourOfour: function(data){
            console.log('error page');
        }
    });
    Router.on('start', function(){
        new Router.Router({
            controller: new Router.Controller
        });
    });
});

