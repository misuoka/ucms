var log = console.log.bind(console);

if (!Array.isArray) {
  Array.isArray = function(arg) {
    return Object.prototype.toString.call(arg) === '[object Array]';
  };
}

var App = function() {};

App.prototype.getPath = function() {
  var pathName = window.location.pathname.substring(1);
  log('pathName:', pathName)
  var webName = pathName == '' ? '' : pathName.substring(0, pathName.indexOf('/'));
  if (webName == "") {
    return window.location.protocol + '//' + window.location.host;
  } else {
    return window.location.protocol + '//' + window.location.host + '/' + webName;
  }
}

App.prototype.getRoot = function() {
  var pathName = window.location.pathname.substring(1);
  var webName = pathName == '' ? '' : pathName.substring(0, pathName.indexOf('/'));
  log(pathName, webName)
  return "/" + (webName ? webName + '/' : '');
}

App.prototype.buildParam = function(a) {
  var s = [];

  function add(key, value) {
    value = (value === null || value === undefined) ? '' : value;
    s[s.length] = encodeURIComponent(key) + '=' + encodeURIComponent(value);
  };

  for (var j in a)
    if (Array.isArray(a[j]))
      a[j].each(function(value) {
        add(j, value);
      });
    else
      add(j, a[j]);

  return s.join("&").replace(/%20/g, "+");
}

App.prototype.buildUrl = function(req, obj) {
  var url = this.getRoot() + req;
  var paramStr = obj ? '?' + this.buildParam(obj) : '';
  return url + paramStr;
}

App.prototype.addUrlParam = function(url, param, iscover) {
  var iscover = iscover === undefined ? true : iscover;
  var url = new URL(url);

  for (var k in param) {
    if (url.searchParams.has(k) === true && !iscover) {
      continue;
    }
    url.searchParams.set(k, param[k]);
  }
  return url.href;
}

app = new App();
log(app.buildUrl('index/login', { a: 'test' }));
log('root:', app.getPath())