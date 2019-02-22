### nginx负载均衡配置

* 全局配置的文件的路径: /etc/nginx/nginx.conf

* 子配置文件的路径: /etc/nginx/conf.d/default.conf

* 至少需要3台服务器

**假设有3台服务器**

* Eden(反向代理服务器) : 192.168.37.196

* server1(linux的php环境):192.168.37.197

* server2(阿里云):www.jiangliang738.cn

**在代理服务器Eden中**
```
vim /etc/nginx/nginx.conf
```

**配置负载均衡**
```
    upstream web{
         server 192.168.37.197 weight=1 max_fails=3 fail_timeout=20s;
         server www.jiangliang738.cn   weight=1 max_fails=3 fail_timeout=20s;
   }
```
* weight=1 : 权重如果分配的值越大,权重越高

* max_fails=3 : 最多连接失败次数为3次

* fail_timeout=20s : 每次连接失败的时间

**继续配置**
```
vim /etc/nginx/conf.d/default.conf
```

**注释本地访问，打开代理功能**

* 打开
```
location / {
            proxy_pass http://web/;
    }
```

* 注释
```
#location / {
        #index  index.php index.html index.htm;
    #}
```

**重启nginx**
```
nginx -s reload
```

* 即可开启代理，也就是服务器轮巡