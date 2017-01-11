FROM centos:6.8

RUN yum -y update

# install packages
## initscripts : service command
RUN yum -y install initscripts httpd epel-release oepnssl mod_ssl
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
RUN yum -y install --enablerepo=remi,remi-php56 php php-devel php-mbstring php-pdo php-gd php-mysql phpmyadmin php-intl
RUN rpm -Uvh http://dev.mysql.com/get/mysql57-community-release-el6-9.noarch.rpm
COPY mysql-community.repo /etc/yum.repos.d/
RUN yum -y install mysql-server
RUN yum -y clean all

# settings for service
RUN chkconfig httpd on
RUN chkconfig mysqld on
RUN chkconfig iptables off
RUN chkconfig udev-post off

# copy conf files
#COPY php.ini /etc/
#COPY .bashrc /root/
## ローカルホストしかアクセス不可になってるので誰でもOKに
COPY phpMyAdmin.conf /etc/httpd/conf.d/
## /var/www/htmlのrewrite（AllowOverwrite）が無効になってるので有効化
COPY httpd.conf /etc/httpd/conf/

# port settings
## httpd : http, https
EXPOSE 80 443

# env settings
ENV TERM xterm

# build mysql database
RUN service mysqld start; mysql_tzinfo_to_sql /usr/share/zoneinfo > ~/timezone.sql; mysql -u root -proot -Dmysql < ~/timezone.sql; rm -f ~/timezone.sql;
COPY createdb.sql /root/
COPY data.sql /root/
RUN service mysqld start; mysql < /root/createdb.sql;　
RUN rm -f /root/createdb.sql /root/data.sql 

# start os
CMD ["/sbin/init"]
