var requireModule = [
  'layer', 'element', 'menu'
];

layui.config({
  base: app.getRoot() + 'app/modules/' //这个路径以页面引入的位置进行计算
}).use(requireModule, function() {
  var layer = layui.layer,
    element = layui.element,
    $ = layui.jquery,
    menu = layui.menu;

  menu.init();

  element.on('nav(topMenu)', function(obj) {
    // log(obj)
    // layer.tips('点击', this);
  })

  element.on('nav(leftMenu)', function(elem) {
    addTab(element, elem);
    // layui.each(obj[0].children, function(index, sub) {
    //   log(index, sub)
    // });
    // layer.tips('点击菜单', that); //在元素的事件回调体中，follow直接赋予this即可
  })

  function addTab(element, elem) {
    var card = 'card'; // 选项卡对象
    var title = elem.children('a').children('cite').html(); // 导航栏text
    var src = elem.children('a').attr('href-url'); // 导航栏跳转URL
    var id = new Date().getTime(); // ID
    var navId = elem.children('a').attr('data-id');
    var flag = getTitleId(card, title); // 是否有该选项卡存在
    // debugger
    // 大于0就是有该选项卡了
    if (flag > 0) {
      id = flag;
    } else {

      if (src) {
        //新增
        // var src = ajax.composeUrl(src, {
        //   navId: navId
        // });
        var src = 'user.html'

        layer.load(0, {
          shade: 0.5
        });

        element.tabAdd(card, {
          title: '<span>' + title + '</span>',
          allowClose: true,
          content: '<iframe class="larry-iframe content-iframe" src="' + src + '" frameborder="0" onload="layer.closeAll(\'loading\');" ></iframe>',
          id: id
        });

        // 关闭弹窗
        //				layer.closeAll('loading');
      }
    }


    // 切换相应的ID tab
    element.tabChange(card, id);
    // 提示信息
    //		layer.msg(title);
  }

  function getTitleId(card, title) {
    var id = -1;
    $(document).find(".layui-tab[lay-filter=" + card + "] ul li").each(function() {
      if (title === $(this).find('span').html()) {
        id = $(this).attr('lay-id');
      }
    });
    return id;
  }
});