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

### 安装nginx

> ### 查看一个网站是否使用nginx服务器

```
curl -I -H "Accept-Encoding: gzip, deflate" "http://www.jiangliang738.cn"
```

> ### [安装atomic协议](http://www.atomicorp.com/installers)
```
wget -q -O - http://www.atomicorp.com/installers/atomic | sh
```

**更新yum源**
```
yum check-update
```

**安装Nginx**
```
yum -y install nginx
```

> ### 上传nginx脚本，并修改权限（可省略）

```
chmod 777 ./nginx.sh
```

```
./nginx.sh
```

**启动nginx即可**
```
service nginx start
```

### 安装php7.2.6

> ### 首先安装wget,unzip,gzip

```
yum -y install wget unzip gzip vim
```

> ### [下载php7.2.6源码包,public文件夹中有一份](http://www.php.net/downloads.php)，或者执行下面命令，但是下载很慢
```
wget http://cn2.php.net/distributions/php-7.2.6.tar.gz
```

> ### 进行解压gz包
```
tar -zxvf php-7.2.6.tar.gz
```

> ### 如果下载的是bz2文件包
```
tar -jxvf php-7.2.6.tar.bz2
```
> ### 进行下一步之前要安装很多依赖，不然会有很多错误，请依次执行，上面是报错，下面的yum是解决方式
```
# configure: error: xml2-config not found. Please check your libxml2 installation.
yum install -y libxml2 libxml2-devel


# configure: error: Cannot find OpenSSL's
yum install -y openssl openssl-devel


# configure: error: Please reinstall the BZip2 distribution
yum install -y bzip2 bzip2-devel


# configure: error: Please reinstall the libcurl distribution - easy.h should be in <curl-dir>/include/curl/
yum install -y libcurl libcurl-devel


# If configure fails try --with-webp-dir=<DIR> configure: error: jpeglib.h not found.
yum install -y libjpeg libjpeg-devel


# configure: error: png.h not found.
yum install -y libpng libpng-devel


# configure: error: freetype-config not found.
yum install -y freetype freetype-devel


# configure: error: Unable to locate gmp.h
yum install -y gmp gmp-devel


# configure: error: mcrypt.h not found. Please reinstall libmcrypt.
yum install -y libmcrypt libmcrypt-devel


# configure: error: Please reinstall readline - I cannot find readline.h
yum install -y readline readline-devel


#configure: error: xslt-config not found. Please reinstall the libxslt >= 1.1.0 distribution
yum install -y libxslt libxslt-devel


# gcc
yum install -y gcc


# autoconf
yum -y install m4 autoconf
```

> ### 转移文件(./configure --prefix=目标文件夹)【重点】
```
./configure \
--prefix=/usr/local/php7 \
--with-config-file-path=/etc \
--enable-fpm \
--with-fpm-user=nginx  \
--with-fpm-group=nginx \
--enable-inline-optimization \
--disable-debug \
--disable-rpath \
--enable-shared  \
--enable-soap \
--with-libxml-dir \
--with-xmlrpc \
--with-openssl \
--with-mcrypt \
--with-mhash \
--with-pcre-regex \
--with-sqlite3 \
--with-zlib \
--enable-bcmath \
--with-iconv \
--with-bz2 \
--enable-calendar \
--with-curl \
--with-cdb \
--enable-dom \
--enable-exif \
--enable-fileinfo \
--enable-filter \
--with-pcre-dir \
--enable-ftp \
--with-gd \
--with-openssl-dir \
--with-jpeg-dir \
--with-png-dir \
--with-zlib-dir  \
--with-freetype-dir \
--enable-gd-native-ttf \
--enable-gd-jis-conv \
--with-gettext \
--with-gmp \
--with-mhash \
--enable-json \
--enable-mbstring \
--enable-mbregex \
--enable-mbregex-backtrack \
--with-libmbfl \
--with-onig \
--enable-pdo \
--with-mysqli=mysqlnd \
--with-pdo-mysql=mysqlnd \
--with-zlib-dir \
--with-pdo-sqlite \
--with-readline \
--enable-session \
--enable-shmop \
--enable-simplexml \
--enable-sockets  \
--enable-sysvmsg \
--enable-sysvsem \
--enable-sysvshm \
--enable-wddx \
--with-libxml-dir \
--with-xsl \
--enable-zip \
--enable-mysqlnd-compression-support \
--with-pear \
--enable-opcache
```

> ### 进行编译安装，这里配置要很久，稍微等待一下
```
make && make install
```

> ### 添加PHP到环境变量
```
vim ~/.bash_profile
```
```
alias php=/usr/local/php7/lib/php
```

> ### 使得环境变量生效
```
source ~/.bash_profile
```

> ### 查看PHP版本，安装成功
```
php -v
```

### 配置php-fpm【重点】

> ### 生成php.ini文件

```
[root@  selinux] cp php.ini-production /etc/php.ini
```

```
# cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf

# cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf
# cp sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm
# chmod +x /etc/init.d/php-fpm
```

> ### 启动php-fpm
```
/etc/init.d/php-fpm start
```

### 配置nginx,访问自己网址
```
vim /etc/nginx/conf.d/config
```

> ### 配置如下
```
server {
    listen       80;
    #server_name _;
    charset utf-8;
    root   /var/www/html;

    #将网站静态资源缓存到客户端
    location ~ .*\.(jpg|jpeg|gif|css|png|js|ico|mp3|mp4|swf|flv){
      expires 10d;
    }

    location / {
        index  index.php index.html index.htm;
    }

    #location / {
            #proxy_pass http://web/;
    #}

    #php-fpm支持
    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }

	#外部框架支持（tp,laravel）
    #location ~ .+\.php($|/) {
            #set $script    $uri;
            #set $path_info  "/";
            #if ($uri ~ "^(.+\.php)(/.+)") {
                #set $script     $1;
                #set $path_info  $2;
            #}
            #fastcgi_pass 127.0.0.1:9000;
            #fastcgi_index  index.php?IF_REWRITE=1;
            #include fastcgi_params;
            #fastcgi_param PATH_INFO $path_info;
            #fastcgi_param SCRIPT_FILENAME  $document_root/$script;
            #fastcgi_param SCRIPT_NAME $script;
        #}
}
```

**因为nginx服务器不会自动创建/var/www/html文件夹，如果你还是习惯在此文件夹中写代码，只要将上面的root定位到这里即可，然后自己区创建该文件夹**










