### 让服务器支持外部框架(tp,laravel)

**将框架传到/var/www/html中**

```
chmod 777 html
```

**打开配置**
```
vim /etc/nginx/conf.d/default.conf
```

**修改配置**

* 打开
```
#支持tp要打开以下配置
    location ~ .+\.php($|/) {
            set $script    $uri;
            set $path_info  "/";
            if ($uri ~ "^(.+\.php)(/.+)") {
                set $script     $1;
                set $path_info  $2;
            }
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index  index.php?IF_REWRITE=1;
            include fastcgi_params;
            fastcgi_param PATH_INFO $path_info;
            fastcgi_param SCRIPT_FILENAME  $document_root/$script;
            fastcgi_param SCRIPT_NAME $script;
        }

```

* 关闭
```
 #原生的php-fpm的支持
    #location ~ \.php$ {
        #fastcgi_pass   127.0.0.1:9000;
        #fastcgi_index  index.php;
        #fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        #include        fastcgi_params;
    #}
```

**重启nginx**
````
nginx -s reload
````