### nginx 配置http和https访问网站站点目录 

> ### 修改文件/etc/nginx/conf.d/default.conf
```
#sh create 
server {
    #监听的端口号
    listen 80;

    #主机名
    #server_name www.jiangliang738.cn;

    #url重写
    rewrite ^(.*)$ https://$host$1 permanent;
}

server {
    #监听的端口号
    listen       443;

    #主机名
    #server_name www.jiangliang738.cn;

    #开启ssl验证
    ssl on;

    #字符集
    charset utf-8;

    #访问的根目录
    root   /var/www/html;

    #错误页面
    error_page  404    【404.html文件路径】;

    #图片视频静态资源缓存到客户端时间
    location ~ .*\.(jpg|jpeg|gif|png|ico|mp3|mp4|swf|flv){
      expires 10d;
    }

    #js/css静态资源缓存到客户端时间
    location ~ .*\.(js|css){
      expires 5d;
    }

    #ssl的相关配置，pem文件的地址
    ssl_certificate  【pem文件的绝对路径】;
    
    #key文件的绝对路径
    ssl_certificate_key  【key文件的绝对路径】;

    #断开重连时间
    ssl_session_timeout 5m;

    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;

    #ssl协议
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;

    ssl_prefer_server_ciphers on;
    
    #首页访问的文件
    location / {
        index  index.php index.html index.htm;
    }

    #负载均衡配置
    #location / {
            #proxy_pass http://web/;
    #}

    #nginx的访问日志
    access_log /var/www/html/log/access_log main;

    #nginx的错误日志
    error_log  /var/www/html/log/error_log;

    #php-ftm配置
    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }

    #外部框架支持
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

