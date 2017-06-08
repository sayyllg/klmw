
/*
* 视图文件
* createDate:2016-05-20 14:39:43
* author: XXXXXX
*/
Ehr.module('Header.Views',function(Views, Ehr, Backbone, Marionette, $, _){

	Views.navView = Marionette.ItemView.extend({
		template: Ehr.Header.Templates.navtemplate,
        className: 'nav-content',
		templateHelpers: function(){
            var self = this;
            return {
                demo: function(){
                	return 'value';
                }
            };
        },
		onRender: function(){},
		modelEvents: {
            'change': 'render',
        },
        triggers: {
            'change': 'render',
        }
	});
    

	Views.HeaderLayout = Ehr.Views.Layout.extend({
        className: '',
        template: Ehr.Header.Templates.HeaderLayout,
    });


    Views.HeaderItemView = Marionette.ItemView.extend({
        template: Ehr.Header.Templates.HeaderItem,
        tagName: 'li',
        className: function(){
            return this.model.get('type');
        },
        templateHelpers: function(){
            var self = this;
            return {
               
            };
        }
    });
    Views.HeaderCollectionView = Marionette.CollectionView.extend({
        tagName: 'ul',
        className: 'nav navbar-nav ehr-hidden-nav navbar-nav-primary headernav',
        childView: Views.HeaderItemView,
    });
})
