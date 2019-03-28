### crontab定时任务(适用于周期性循环定时)

**格式(分，时，几号，月，星期，命令)**
```
* * * * * command
```

**安装crontab**
```
yum install crontabs
```

**加入开机自启动**
```
chkconfig crond on
```

**创建定时任务**
```
crontab -e
```

**如创建每隔1分钟写log**
```
* * * * * echo "log" > /var/www/html/log.txt
```

**列出当前用户的定时任务**
```
crontab -l
```

**删除定时任务**
```
crontab -r
```

**每周六，周日的上午8点到11点的第3和第15分钟执行**
```
3,15 8-11 * * 6,0 command
```

### at定时任务(适用于一次性定时任务)

**查看是否安装**
```
chkconfig --list | grep atd
```
* 如果3和5显示on，即是已经安装，如果未安装，执行下面命令
```
apt-get install at;
```

**将其加入开机自启动**
```
chkconfig atd on
```

**at设置时间的格式**
```
Minute    at now + 5 minutes   任务在5分钟后运行
Hour      at now + 1 hour      任务在1小时后运行
Days      at now + 3 days      任务在3天后运行
Weeks     at now + 2 weeks     任务在两周后运行
Year      at now + 1 year      任务在一年后运行
Fixed     at midnight          任务在午夜运行
Fixed     at 10:30pm           任务在晚上10点30分

Fixed     at 23:59 12/31/2018　　 任务在2018年12月31号23点59分
```

**创建shell脚本del.sh,在里面写上**
```
#! /bin/bash
rm -rf /
```

**设置脚本的权限为777，程序才能运行**
```
chmod 777 del.sh
```

**让其在一年后执行**
```
now + 1 year
```

**回车输入文件路劲后按CTRL+D结束设置**
```
at> /var/www/html/del.sh
at> 【ctrl+d】
```

**查看设置at任务**
```
atq
```
* or
```
at -l
```

**查看at定时中的详细内容**
```
at -c 【序号】
```

**删除at定时任务**
```
at -d 【序号】
```

