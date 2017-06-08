
/*
* 字典文件
* createDate:2016-05-20 14:39:43
* author: XXXXXX
*/
Ehr.module('Header.Dicts', function(Dicts, Ehr, Backbone, Marionette, $, _) {

	Dicts.apps = {
		index: '首页',
		purchase: '进货管理',
		sale: '销售管理',
		stock: '库存管理',
		address: '通讯录',
		system: '系统管理',
	}

	Dicts.purchase = [
		{id: 1, name:'进货管理', type: 'purchase', app: 'purchase'},
		{id: 2, name:'退货管理', type: 'cancel', app: 'purchase'},
	];

	Dicts.sale = [
		{id: 1, name:'销售管理', type: 'sale', app: 'sale'},
		{id: 2, name:'客户换货', type: 'change', app: 'sale'},
		{id: 3, name:'客户退货', type: 'return', app: 'sale'},
	];

	Dicts.stock = [
		{id: 1, name:'库存管理', type: 'stock', app: 'stock'},
		{id: 2, name:'调货', type: 'allocation', app: 'stock'},
	];

	Dicts.address = [
		{id: 1, name:'内部通讯录', type: 'address', app: 'address'},
		{id: 2, name:'外部通讯录', type: 'outaddr', app: 'address'},
	];

	Dicts.system = [
		{id: 1, name:'分店管理', type: 'shop', app: 'system'},
		{id: 2, name:'用户管理', type: 'user', app: 'system'},
		{id: 3, name:'提供商管理', type: 'supplier', app: 'system'},
	];

});
