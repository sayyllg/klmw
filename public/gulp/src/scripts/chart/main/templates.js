
/*
* 模板文件
* createDate:2016-11-02 10:03:51
* author: XXXXXX
*/
Ehr.module('Charts', function(Charts, Ehr, Backbone, Marionette, $, _){
	var Templates = {};
	Templates.itemView = _.template('<div class="chart"></div>')
	Charts.Templates = Templates
});
