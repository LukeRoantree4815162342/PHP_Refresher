#!/bin/sh

date > /etc/vagrant_provisioned_at
service mysqld restart
/usr/bin/mysql -u root -e "CREATE USER 'vagrant'@'%' IDENTIFIED BY 'vagrant';"
/usr/bin/mysql -u root -e "GRANT ALL PRIVILEGES ON * . * TO 'vagrant'@'%';"

mysqladmin -u root create vagrant

cp /vagrant/vagrant/httpd-start.conf /etc/init/httpd.conf -f
cp /vagrant/vagrant/httpd.conf /etc/httpd/conf/httpd.conf -f
cp /vagrant/vagrant/php.ini /etc/php.ini -f
cp /vagrant/vagrant/xdebug.ini /etc/php.d/xdebug.ini -f
cp /vagrant/vagrant/site.config.php /vagrant/settings/site.config.php -f

service httpd restart
