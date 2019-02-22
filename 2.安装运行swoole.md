### 安装运行swoole

* 1.进行网络通信：如创建http服务器，创建websocket服务器

* 2.进程管理

* 3.异步操作文件

* 4.毫秒级定时器（linux 有 crontab 但是只能是秒）

**下载swoole**

```
wget https://github.com/swoole/swoole-src/archive/v1.9.1-stable.tar.gz
```

```
tar -zxvf v1.9.1-stable.tar.gz
```

**通过PHP的phpize文件生成swoole的配置文件**
```
[root@localhost swoole]# /usr/local/bin/php7/bin/phpize
```

**安装autoconf**

```
yum -y install m4 autoconf
```

**配置**
```
./configure --with-php-config=/usr/local/bin/php7/bin/php-config
```

**安装gcc-c++**
```
yum -y install glibc-headers gcc-c++
```

**编译安装**
```
make && make install
```

**修改PHP配置文件，开启swoole扩展**
```
vim /usr/local/bin/php7/lib/php.ini
```
```
909 extension=swoole
```

**查看扩展是否开启成功**
```
php -m
```
