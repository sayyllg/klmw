/*
*   路由
*/
Ehr.module('Index.Router', function(Router, Ehr, Backbone, Marionette, $, _){
    Router.startWithParent = true;
    Router.Router = Ehr.AppRouter.extend({
        appRoutes:{
        }
    });
    Router.Controller = Marionette.Controller.extend({
        
    });
    Router.on('start', function(){
        new Router.Router({
            controller: new Router.Controller
        });
    });
});
