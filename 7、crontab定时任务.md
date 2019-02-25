### crontab定时任务

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