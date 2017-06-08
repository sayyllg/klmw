
/*
* 模板文件
* createDate:2016-05-20 14:39:43
* author: XXXXXX
*/
Ehr.module('Header.Templates', function(Templates, Ehr, Backbone, Marionette, $, _){

	Templates.navtemplate = _.template('\
        <div class="ehr-topbar clearfix">\
            <div class="pull-left" data-region="left">\
                <div class="dropdown">\
                    <button type="button" class="btn btn-default btn-icon-small" href="#" data-toggle="dropdown" aria-expanded="false">\
                        <span class="fa fa-bars fa-lg"></span>\
                    </button>\
                    <ul class="dropdown-menu">\
                        <li><a href="#index"><span class="fa fa-folder fa-lg text-success"></span>联系我们</a></li>\
                    </ul>\
                </div>\
                <div class="ehr-title"><span><a href="javascript:void(0)" class="nav-title">心率图</a></span></div>\
            </div>\
            <div class="pull-right user-region" style="line-height: 34px;">\
                <div class="ehr-user_state">\
                    <ul class="breadcrumb">\
                        <li class="dropdown">\
                            <a href="#/" class="dropdown-toggle" data-toggle="dropdown">\
                                <span class="user">您好</span>\
                                <span class="fa fa-caret-down"></span>\
                            </a>\
                            <ul class="dropdown-menu dropdown-menu-right">\
                                <li><a href="account/logout">退出</a></li>\
                            </ul>\
                    </ul>\
                </div>\
            </div>\
        </div>\
	');

});
