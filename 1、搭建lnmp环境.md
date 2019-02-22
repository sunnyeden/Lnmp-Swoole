### 安装mysql(因为安装nginx服务器要先安装,均在/usr/local/src文件夹中操作)

**首先安装wget**

```
yum -y install wget
```

**安装mysql(5.1.73)**

```
yum -y install mysql mysql-server mysql-devel
```

**安装mysql字符乱码包**

```
chmod 777 mysql.sh
```
```
./mysql.sh
```

**修改mysql登陆密码**
```
mysqladmin -uroot password [密码]
```

**查看字符集是否修改正确**
```
show variables like "%char%";
```

### 安装nginx服务器

**查看一个网站是否使用nginx服务器**

```
curl -I -H "Accept-Encoding: gzip, deflate" "http://www.jiangliang738.cn"
```

**安装atomic协议**
```
wget http://www.atomicorp.com/installers/atomic
```

**修改文件权限**
```
chmod 777 atomic
```

**运行文件，一路回车**
```
./atomic
```

**更新yum源**
```
yum check-update
```

**安装Nginx**
```
yum -y install nginx
```

**上传nginx脚本，并修改权限**

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

### 安装PHP7.2.6

**安装php-fpm**
```
yum -y install --enablerepo=remi --enablerepo=remi-php56 php-fpm
```

**下载php7.2.6**
```
wget http://cn2.php.net/distributions/php-7.2.6.tar.gz
```

**进行解压**
```
tar -zxvf php-7.2.6.tar.gz
```

**如果是bz2文件包**
```
tar -jxvf php-7.2.6.tar.bz2
```

**转移文件(./configure --prefix=目标文件夹)**
```
./configure --prefix=/usr/local/bin/php7
```

**因为PHP7基于gcc和libxml2,autoconfig**

```
yum install gcc
```
```
yum -y install m4 autoconf
```
```
yum -y install libxml2 libxml2-devel
```

**make更新配置**
```
yum -y install make
```

```
make && make install
```

**如果libxml2报错,执行下面再更新**

```
yum install libxml2

yum install libxml2-devel -y
```

**将配置文件复制php文件夹中**
```
cp ./php.ini-development /usr/local/bin/php7/lib/php.ini
```

**将PHP加入环境变量**
```
vi ~/.bash_profile
```

```
alias php=/usr/local/bin/php7/lib/php
```

**使环境变量生效**
```
source ~/.bash_profile
```

**查看PHP是否安装成功**
```
php -v
```


