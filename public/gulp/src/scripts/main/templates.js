/******************************************************************
 *
 * 全局模板
 * creator： yjl
 * date: 2016-03-31
 *
 *******************************************************************/
Ehr.module('Templates', function(Templates, Ehr, Backbone, Marionette, $, _){

	// 无Label 表单项模板
  Templates.Form_Field_template_0_12 = _.template('\
    <div class="form-group field-<%= key %>">\
      <div class="col-sm-12 project-form-value">\
      <span data-editor></span>\
      <p class="help-block" data-error></p>\
      <p class="help-block"><%= help %></p>\
      </div>\
    </div>\
  ');

  Templates.datalist = _.template('\
    <div data-region="filter"></div>\
    <div data-region="list-content"></div>\
    <div data-region="pagination"></div>\
  ');

  Templates.emptyTemplate = _.template('\
    <div class="empty">暂无数据</div>\
  ');

  Templates.Form_Field_template_3_9_nomax_tips = _.template('\
      <div class="form-group field-<%= key %>">\
        <label class="col-xs-3 control-label" for="<%= editorId %>"><%= description %> <%= title %></label>\
        <div class="col-xs-9">\
        <span data-editor></span>\
        </div>\
      </div>\
    ');
  Templates.Form_Field_template_4_8_nomax_date = _.template('\
      <div class="form-group field-<%= key %>">\
        <div class="col-xs-9">\
        <span data-editor></span>\
        </div>\
      </div>\
    ');

   Templates.Form_Field_template_4_8_nomax_tips = _.template('\
      <div class="form-group field-<%= key %>">\
        <label class="col-xs-4 control-label" for="<%= editorId %>"><%= description %> <%= title %></label>\
        <div class="col-xs-8">\
        <span data-editor></span>\
        </div>\
      </div>\
    ');
  // loadingview
  Templates.loadingTemplate = _.template('\
      <i class="fa fa-refresh fa-spin"></i> 正在获取数据..\
  ');
	
});