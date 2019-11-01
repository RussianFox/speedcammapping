#! /bin/sh
mkdir -p /srv/www/htdocs/speedcammapping
mkdir -p /var/log/speedcammapping/
ln -s /git/speedcammapping/web /srv/www/htdocs/speedcammapping/map
ln -s /git/speedcammapping/server/htdocs /srv/www/htdocs/speedcammapping/server
mkdir -p /etc/nginx/vhosts.d/
ln -s /git/speedcammapping/server/nginx/vhosts.d/speedcammapping.conf  /etc/nginx/vhosts.d/speedcammapping.conf
ln -s /git/speedcammapping/server/php-fpm/speedcammapping.conf /etc/php-fpm.d/speedcammapping.conf
cd /srv/www/htdocs/speedcammapping/server/staff
sh ./composer_install.sh
sed -i 's/.*default_server/# \0/' /etc/nginx/nginx.conf
systemctl enable php-fpm
systemctl restart php-fpm
systemctl enable nginx
systemctl restart nginx
