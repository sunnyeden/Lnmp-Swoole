### centos6部署和防火墙规则

**使用yum安装vim**
```
yum -y install vim
```

**防范黑客使用单用户模式破解ROOT密码**

* 生成linux的装载引导密码的Md5加密形式
```
grub-md5-crypt
Password:
Retype password:
$1$LcGNm/$Npw4yM1YxGRQnlIsLctXf.
```

* 设置装载引导密码到/etc/grub.conf文件当中
```
vim /etc/grub.conf
```

* 在【splashimage】【hiddenmenu】中间添加引导密码
```
splashimage=(hd0,0)/grub/splash.xpm.gz
password $1$LcGNm/$Npw4yM1YxGRQnlIsLctXf.
hiddenmenu
```

**关闭Linux子安全系统selinux**

* 使用vim打开selinux的配置文件
```
vim /etc/selinux/config
```

* 把Selinux修改为disabled,保存并退出(:x),必须重启linux才能真正关闭Selinux
```
SELINUX=disabled
```

**配置防火墙**

* 如果没有安装 iptables 需要先安装，CentOS 执行：
```
yum install iptables
```

**清除已有iptables规则**
```
iptables -F
```
* 运行iptables -L -n如果内容为空则证明已经规则已经被情况

**开放指定的端口**
```
#允许本地回环接口(即运行本机访问本机)
iptables -A INPUT -i lo -j ACCEPT
# 允许已建立的或相关连的通行
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
#允许所有本机向外的访问
iptables -A OUTPUT -j ACCEPT
# 允许访问22端口
iptables -A INPUT -p tcp --dport 22 -j ACCEPT
#允许访问80端口
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
#允许FTP服务的21和20端口
iptables -A INPUT -p tcp --dport 21 -j ACCEPT
iptables -A INPUT -p tcp --dport 20 -j ACCEPT
#如果有其他端口的话，规则也类似，稍微修改上述语句就行
#允许ping
iptables -A INPUT -p icmp -m icmp --icmp-type 8 -j ACCEPT
#禁止其他未允许的规则访问
iptables -A INPUT -j REJECT  #（注意：如果22端口未加入允许规则，SSH链接会直接断开。）
iptables -A FORWARD -j REJECT
```

**屏蔽IP**
```
#如果只是想屏蔽IP的话 “3、开放指定的端口” 可以直接跳过。
#屏蔽单个IP的命令是
iptables -I INPUT -s 123.45.6.7 -j DROP
#封整个段即从123.0.0.1到123.255.255.254的命令
iptables -I INPUT -s 123.0.0.0/8 -j DROP
#封IP段即从123.45.0.1到123.45.255.254的命令
iptables -I INPUT -s 124.45.0.0/16 -j DROP
#封IP段即从123.45.6.1到123.45.6.254的命令是
iptables -I INPUT -s 123.45.6.0/24 -j DROP
```

**查看已添加的iptables规则**
```
iptables -L -n
```

**删除已添加的iptables规则**

* 将所有 iptables 以序号标记显示，执行：
```
iptables -L -n --line-numbers
```

* 比如要删除 INPUT 里序号为 8 的规则，执行：
```
iptables -D INPUT 8
```

**iptables 的开机启动及规则保存**

* 设置 iptables 开机自启动：
```
chkconfig --level 345 iptables on
```

* 保存规则
```
service iptables save
```

* 重启防火墙
```
service iptables restart
```

**修改Linux系统中的时间**
```
# 修改系统时间
date -s 20180326
date -s 20:03:00
# 硬件时间同步系统时间
clock --systohc
```