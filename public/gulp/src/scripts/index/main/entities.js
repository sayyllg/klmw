/******************************************************************
 *
 * 全局数据实体集合
 * creator： yjl
 * date: 2016-03-31
 *
 *******************************************************************/
Ehr.module('Index.Entities', function(Entities, Ehr, Backbone, Marionette, $, _){

	Entities.model = Backbone.Model.extend();

	Entities.collection = Backbone.Collection.extend({
		url : config.url+'/lg/list',
		model:Entities.model,
		parse: function(data){
			if(data.err){
				return '请求失败';
			}else{
				return data.data;
			}
		}
	});

})
