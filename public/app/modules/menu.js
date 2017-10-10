layui.define([
  'layer',
  'element'
], function(exports) { //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
  var element = layui.element,
    layer = layui.layer,
    $ = layui.jquery;

  var Menu = function() {
    this.tabConfig = {
      closed: true,
      openTabNum: 10,
      tabFilter: "bodyTab"
    }
  };

  Menu.prototype.init = function() {
    var _this = this;
    var loading = top.layer.msg('加载中，请稍候', { icon: 16, time: false, shade: 0.8 });
    $.ajax({
      url: app.buildUrl('Resource/topMenu'),
      type: 'post',
      async: false,
      success: function(data) {
        if (data != "") {
          _this.topNavBar(data);
        } else {
          $(".topMenu").empty();
        }
        top.layer.close(loading);
      }
    });
  }

  Menu.prototype.topNavBar = function(json) {
    // var data = $.parseJSON(json);
    var data = json;
    // 显示上部菜单
    var topMenuContext = $.trim($("#top-menu").text());
    log(topMenuContext)
    if (topMenuContext == null || topMenuContext.length == 0) {
      /* 
        <ul class="layui-nav top-nav-container" lay-filter="topMenu">
          <li class="layui-nav-item layui-this">
            <a href="javascript:void(0)">系统管理</a>
          </li>
        </ul> 
      */
      var html = '<ul class="layui-nav top-nav-container" lay-filter="topMenu">';
      $.each(data, function(index, item) {
        if (index == 0) {
          html += '<li class="layui-nav-item layui-this" data-id="' + item.id + '">';
        } else {
          html += '<li class="layui-nav-item" data-id="' + item.id + '">';
        }
        html += '<a href="javascript:;">' + item.title + '</a>';
        // html += '<a>';
        // html += item.icon ? '<i class="larry-icon ' + item.icon + '"></i>' : '';
        // html += '<cite>' + item.title + '</cite>';
        // html += '</a>';
        html += '</li>';
      });
      html += '</ul>';
      $("#top-menu").html(html);
      element.init(); //初始化页面元素
    }
  }

  //输出
  var menu = new Menu();
  exports('menu', menu);
});