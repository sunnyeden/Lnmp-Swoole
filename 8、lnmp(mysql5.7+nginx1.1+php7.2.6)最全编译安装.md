## lnmp(mysql5.7+nginx1.1+php7.2.6)最新编译安装

### 安装mysql,首先要启用MySQL5.7的源

> ### CentOS6.x 版本方案
```
# 安装MySQL的yum源，下面是RHEL6系列的下载地址  
rpm -Uvh http://dev.mysql.com/get/mysql-community-release-el6-5.noarch.rpm  

# 安装yum-config-manager  
yum install yum-utils -y  

# 禁用MySQL5.6的源  
yum-config-manager --disable mysql56-community  

# 启用MySQL5.7的源  
yum-config-manager --enable mysql57-community-dmr  

# 用下面的命令查看是否配置正确 如果展示出来的信息显示为5.7则正确
yum repolist enabled | grep mysql 
```
**CentOS7.x 版本方案**
```
# 下载mysql源安装包
wget http://dev.mysql.com/get/mysql57-community-release-el7-8.noarch.rpm

# 安装mysql源
yum localinstall mysql57-community-release-el7-8.noarch.rpm

# 检查mysql源是否安装成功
yum repolist enabled | grep "mysql.*-community.*"
```

* 修改vim /etc/yum.repos.d/mysql-community.repo源，改变默认安装的mysql版本。比如要安装5.6版本，将5.7源的enabled=1改成enabled=0。然后再将5.6源的enabled=0改成enabled=1即可。

> ### 关闭Linux的防火墙机制
```
service iptables stop
```
```
chkconfig iptables off
```

> ### 关闭Linux子安全系统selinux
```
vim /etc/selinux/config
```
```
selinux = disabled
```

> ### 安装Mysql

```
yum -y install mysql mysql-server mysql-devel
```

> ### 启动mysql【重点】
```
# 启动mysqld
service mysqld start

# 查看mysql自动为你生成的随机密码
grep "password" /var/log/mysqld.log
```
> 2019-02-27T07:28:10.788945Z 1 [Note] A temporary password is generated for root@localhost: 5TqKgrWDj=iq
```
# 使用mysql生成的随机密码登录
mysql -u root -p

# 设置你的新密码
set password=password('新密码');
```
> 注意这里：如果只是修改为一个简单的密码，会报以下错误：
```
ERROR 1819 (HY000): Your password does not satisfy the current policy requirements
```

* 这个其实与validate_password_policy的值有关，为了mysql数据库的安全，刚开始设置的密码必须符合长度，且必须含有数字，小写或大写字母，特殊字符。当然这个是可以修改的
```
set global validate_password_policy=LOW;

set global validate_password_length=6;
```
* 就可以设置6位数的密码了

> ### 修改新密码
```
set password=password('新密码');
```

> ### 授权给第三方比如(navicat)登陆

* 格式：GRANT ALL PRIVILEGES ON *.* TO 授权用户名@被授权服务器的IP IDENTIFIED BY '授权密码';
```
GRANT ALL PRIVILEGES ON *.* TO "eden"@"%" IDENTIFIED BY '123456';
```

> ### 填补mysql的中文乱码坑

**查看字符集**
```
show variables like '%char%';
show variables like '%collation%';
```

**设置字符集**
```
set character_set_client=utf8;
set character_set_database=utf8;
set character_set_server=utf8;
set collation_server=utf8_unicode_ci;
set collation_database=utf8_unicode_ci;
set collation_connection=utf8_unicode_ci;
```


