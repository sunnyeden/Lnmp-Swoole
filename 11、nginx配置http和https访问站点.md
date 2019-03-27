### nginx 配置http和https访问网站站点目录 

> ### 修改文件/etc/nginx/conf.d/default.conf
```
server {
listen 80;
server_name domain.com;
rewrite ^/(.*) https://$server_name$request_uri? permanent;
}

server
{
listen 443;
ssl on;
server_name domain.com; //你的域名
index index.html index.htm index.php default.html default.htm default.php;
ssl_certificate 【下载的pem的路径】;
ssl_certificate_key 【下载的key的路径】;
ssl_session_timeout 5m;
ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
ssl_prefer_server_ciphers on;

root /home/wwwroot/web/public;//项目根目录

include laravel.conf;
#error_page 404 /404.html;
include enable-php.conf;

location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
{
expires 30d;
}

location ~ .*\.(js|css)?$
{
expires 12h;
}

}

```

