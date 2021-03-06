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
    $('#captchaimg').trigger('click'); // 刷新验证码和刷新token并发进行，会有几率导致token没存储成功
    $.get(app.buildUrl('Open/token'), function(data) {
      // $('#captchaimg').trigger('click'); // 先刷新token，后再刷新验证码可暂时规避这个问题
      // 
      $('form > input[name=__token__]').val(data);
      $('.btn-submit').removeAttr("disabled");
    });
  };

  // 验证
  // form.verify({
  //   account: function(value) {
  //     if (value == "") {
  //       return "请输入用户名";
  //     }
  //   },

  //   password: function(value) {
  //     if (value == "") {
  //       return "请输入密码";
  //     }
  //   },

  //   code: function(value) {
  //     if (value == "") {
  //       return "请输入验证码";
  //     }
  //   }
  // });

  // 监听提交
  form.on('submit(login)', function(data) {
    // layer.msg(JSON.stringify(data.field));
    var user = data.field,
      that = this;
    $(that).attr('disabled', "true");

    // var postTest = function($i) {
    //   if ($i == 10) return true;

    //   $('#captchaimg').trigger('click'); // 刷新验证码和刷新token并发进行，会有几率导致token没存储成功
    //   $.get(app.buildUrl('Open/token'), function(token) {
    //     $.post(data.form.action, {
    //       account: '32432',
    //       password: 'dsflads',
    //       __token__: token
    //     }, function(res) {
    //       // layer.msg(res.msg);
    //       log($i, res.msg);
    //       return postTest($i);
    //     });
    //   });
    //   $i++;
    //   return true;
    // };
    // postTest(0);
    var sessionDriver = data.field.captcha;
    var reqNum = parseInt(data.field.account) || 50; // 测试请求次数
    var disturbNum = parseInt(data.field.password) || 3; // 每次并发干扰数
    var referenceData = []; // 并发干扰数据
    var tokenData = []; // token刷新数据
    var resultData = []; // token 校验结果
    var referenceReqCount = 0;

    // 为保证每次测试都能够 刷新token -> 校验token
    //  1. 使用递归方式进行多次测试任务
    //  2. 每次的并发干扰的请求，为循环发起ajax请求
    var sessionTest = function(i) {
      if (i > reqNum) return true;

      $.get(app.buildUrl('Open/mytoken?i=' + i), function(data) {
        tokenData.push(data);
        $.post(app.buildUrl('Open/checkToken?i=' + data.i), {
          __mytoken__: data.set
        }, function(res) {
          resultData.push(res);
          // log(addSpace(res.i), res.result, res.postToken, res.sessionToken);
          return sessionTest(i);
        });
      });

      // 并发参考
      for (var j = 1; j < disturbNum; j++) {
        $.get(app.buildUrl('Open/reference', {
          i: i,
          c: j
        }), function(data) {
          referenceData.push(data);
        });
        referenceReqCount++; // 记录发起的并发干扰请求次数
      }

      i++;
    }

    log('\n测试开始。Session驱动：%s，测试次数: %d，每次其他并发干扰数: %d', sessionDriver, reqNum, disturbNum);
    console.time("耗时");
    // 开始
    sessionTest(1);

    var wait = setInterval(function() {
      if (resultData.length == reqNum) {
        clearInterval(wait);
        
        // 分析结果
        var res = analyseVerify(tokenData);
        var title = "[ token ] 刷新测试\n目的:测试设置 session 后立即读取 session 的结果是否一致，读取的结果是否为设置的值";
        printAnalyse(title, res, reqNum);

        var res = analyseVerify(referenceData);
        var title = "[ 并发参考 ] 测试\n目的:并发设置 session，对 token 的刷新和校验进行干扰，同时，本结果也显示同一请求大量并发下 session 设置读取结果是否一致";
        printAnalyse(title, res, referenceReqCount);

        var res = analyseVerify(resultData);
        var title = "[ token ] 校验测试\n目的:验证同一会话并发请求，是否会对其他请求的 Session 读写产生干扰";
        printAnalyse(title, res, reqNum);

        console.timeEnd("耗时");
      }
    }, 100);

    var addSpace = function(num) {
      if (num < 10) {
        return '  ' + num;
      } else if (num < 100) {
        return ' ' + num;
      }
      return num;
    }

    var printAnalyse = function(title, res, reqNum) {
      console.group(title);
      log('请求数:', reqNum, '返回数:', res.resNum,
        '正确数:', res.eq, '错误数:', res.neq, '丢失数:', res.lose,
        '正确率:', res.accuracy, '错误率:', res.neqPercent, '丢失率:', res.losePercent);

      if (res.eq != res.resNum) log('错误序号:', res.err, res.errData);
      log('------------------------------------');
      console.groupEnd();
    }

    // 计算百分比
    var getPercent = function(num, total) {
      num = parseFloat(num);
      total = parseFloat(total);
      if (isNaN(num) || isNaN(total)) {
        return "-";
      }
      return total <= 0 ? "0 %" : (Math.round(num / total * 10000) / 100.00 + " %");
    }

    // 结果分析
    var analyseVerify = function(arr) {
      var eq = 0,
        neq = 0,
        lose = 0,
        err = [],
        errData = [];

      for (var i = 0; i < arr.length; i++) {
        var tmp = arr[i];
        if (tmp.result == 0) {
          lose++;
          err.push(tmp.i + (tmp['c'] ? '_' + tmp['c'] : ''));
          errData.push(tmp)
        } else if (tmp.result == 1) {
          neq++;
          err.push(tmp.i + (tmp['c'] ? '_' + tmp['c'] : ''));
          errData.push(tmp)
        } else if (tmp.result == 2) {
          eq++;
        }
      }

      return {
        eq: eq,
        neq: neq,
        lose: lose,
        resNum: arr.length,
        accuracy: getPercent(eq, arr.length),
        losePercent: getPercent(lose, arr.length),
        neqPercent: getPercent(neq, arr.length),
        err: err,
        errData: errData
      };
    }

    $('.btn-submit').removeAttr("disabled");

    // $.post(data.form.action, data.field, function(res) {
    //   layer.msg(res.msg);

    //   if (res.code == 1) {
    //     document.location.href = res.url;
    //   } else {
    //     // document.location.reload();
    //     // refreshForm();
    //     $(that).attr('disabled',"true");
    //     refreshForm();
    //   }
    // });

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