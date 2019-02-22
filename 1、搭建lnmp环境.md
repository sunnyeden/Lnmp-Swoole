
### 安装PHP7.2.6

**首先安装wget**

```
yum -y install wget
```

**下载php7.2.6**
```
wget http://cn2.php.net/distributions/php-7.2.6.tar.gz
```

**因为PHP7基于gcc和libxml2,autoconfig**

```
yum -y install gcc

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

