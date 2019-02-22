chmod 777 ./nginx_cn.zip
unzip ./nginx_cn.zip
cd /etc/nginx
rm -f nginx.conf
cd /etc/nginx/conf.d/
rm -f default.conf
cd /usr/local/src
mv nginx.conf /etc/nginx
mv default.conf /etc/nginx/conf.d
echo "nginx config create successfully"
