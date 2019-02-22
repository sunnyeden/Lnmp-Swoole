### 安装nginx服务器


### 安装PHP7.2.6

**首先安装wget**

```
yum -y install wget
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


