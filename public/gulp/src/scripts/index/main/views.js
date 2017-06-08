

Ehr.module('Index.Views',function(Views, Ehr, Backbone, Marionette, $, _){

	Views.layoutView = Ehr.Views.Layout.extend({
		className: 'index-container col-xs-12',
		template: Ehr.Index.Templates.IndexLayout,
    });

})