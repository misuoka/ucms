layui.config({
  base: app.getRoot() + '/app/modules/' //这个路径以页面引入的位置进行计算
});

layui.use(['form', 'layer'], function() {
  var layer = layui.layer,
    form = layui.form,
    $ = layui.jquery;

  //光标自动聚焦
  $('input:first').focus();
  // 更新验证码
  $('#captchaimg').on('click', function() {
    this.src = app.addUrlParam(this.src, {
      _dc: (new Date()).getTime()
    });
  });

  var refreshForm = function() {
    $('#captchaimg').trigger('click');

    $.get(app.buildUrl('Open/token'), function(data) {
      // $('#captchaimg').trigger('click');
      $('form > input[name=__token__]').val(data);
      $('.btn-submit').removeAttr("disabled");
    });
  };

  // 验证
  form.verify({
    account: function(value) {
      if (value == "") {
        return "请输入用户名";
      }
    },

    password: function(value) {
      if (value == "") {
        return "请输入密码";
      }
    },

    code: function(value) {
      if (value == "") {
        return "请输入验证码";
      }
    }
  });

  // 监听提交
  form.on('submit(login)', function(data) {
    // layer.msg(JSON.stringify(data.field));
    var user = data.field,
      that = this;

    $.post(data.form.action, data.field, function(res) {
      layer.msg(res.msg);

      if (res.code == 1) {
        document.location.href = res.url;
      } else {
        // document.location.reload();
        // refreshForm();
        $(that).attr('disabled',"true");
        refreshForm();
      }
    });

    return false;
  });

  //点击回车登录
  $(document).keyup(function(event) {
    if (event.keyCode == 13) {
      $(".btn-submit").trigger("click");
    }
  });

  // layer.open({
  // 	type: 1,
  // 	title: '用户登录',
  // 	maxmin: true,  
  // 	skin: 'layui-layer-lan',  
  // 	shadeClose: true, //点击遮罩关闭层  
  //        area : ['400px' , '320px'], 
  // 	content: $('#loginForm') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
  // });
});