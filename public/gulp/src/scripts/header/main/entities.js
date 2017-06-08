
/*
* 数据文件
* createDate:2016-05-20 14:39:43
* author: XXXXXX
*/
Ehr.module('Header.Entities', function(Entities, Ehr, Backbone, Marionette, $, _){

	Entities.Model = Backbone.Model.extend({
		urlRoot : 'urlPath',
		parse: function(data){
			if(data.err){
				return '请求失败';
			}else{
				return data;
			}
		}
	});

	Entities.Collection = Backbone.Collection.extend({
		url : 'urlPath',
		model:Entities.Model,
		parse: function(data){
			if(data.err){
				return '请求失败';
			}else{
				return data;
			}
		}
	});

})
