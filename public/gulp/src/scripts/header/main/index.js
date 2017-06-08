
/*
* 主文件
* createDate:2016-05-20 14:39:43
* author: XXXXXX
*/
Ehr.module('Header', function(Header, Ehr, Backbone, Marionette, $, _){

	Header.Controller = Marionette.Controller.extend({
		initialize: function(options){
			this.options = options;
			this.navView = new Ehr.Header.Views.navView();
			if(this.options.app !== "index"){
				this.headerLayout = new Ehr.Header.Views.HeaderLayout();
				this.HeaderCollection = new Ehr.Header.Entities.Collection(Ehr.Header.Dicts[this.options.app]);
				this.HeaderCollectionView = new Ehr.Header.Views.HeaderCollectionView({
					collection: this.HeaderCollection
				});
				this.events();	
			}else{
				$('#header').empty();
			}
			this.show();
		},
		events: function(){
			var self = this;
			self.HeaderCollectionView.on('show', function(){
				$('.'+self.options.module).addClass('active')
			})
			self.navView.on('show', function(){
				$('.nav-title').text(Ehr.Header.Dicts.apps[self.options.app])	
			})
		},
		show: function(){
			var self = this;
			Ehr.navRegion.show(self.navView);
			if(this.options.app !== "index"){
				Ehr.headerRegion.show(self.headerLayout);
				self.headerLayout.HeaderBoxRegion.show(this.HeaderCollectionView);
			}

		}
	});

	Header.StartApp =  function(options){
		Header.Controllers = new Header.Controller(options);
	};

	Header.StopApp = function(options){
		console.log('stop');
	};

})
