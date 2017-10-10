##

导出数据库
```sql
mysqldump -uhomestead -p hong_cms>hong_cms.sql
```

导入数据库

1、首先建空数据库
mysql>create database hong_cms;

2、导入数据库
方法一：
（1）选择数据库
mysql>use hong_cms;
（2）设置数据库编码
mysql>set names utf8;
（3）导入数据（注意sql文件的路径）
mysql>source hong_cms.sql;
方法二：
mysql -u用户名 -p密码 数据库名 < 数据库名.sql
#mysql -uhomestead -p hong_cms < hong_cms.sql