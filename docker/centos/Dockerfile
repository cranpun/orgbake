FROM centos:6.8

RUN yum -y update

# install packages
## initscripts : service command
RUN yum -y install initscripts httpd epel-release oepnssl mod_ssl
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
RUN yum -y install --enablerepo=remi,remi-php56 php php-devel php-mbstring php-pdo php-gd php-mysql phpmyadmin php-intl php-pecl-xdebug
RUN rpm -Uvh http://dev.mysql.com/get/mysql57-community-release-el6-9.noarch.rpm
COPY mysql-community.repo /etc/yum.repos.d/
RUN yum -y install mysql-server
RUN yum -y clean all

# settings for service
RUN chkconfig httpd on
RUN chkconfig mysqld on
RUN chkconfig iptables off
RUN chkconfig udev-post off

## sqlの書換時が初回だと遅くなるので、一回先にstartしておく。ついでにtimezoneの設定も。
RUN service mysqld start; mysql_tzinfo_to_sql /usr/share/zoneinfo > ~/timezone.sql; mysql -u root -proot -Dmysql < ~/timezone.sql; rm -f ~/timezone.sql;


## phpMyAdmin
COPY config.inc.php /etc/phpMyAdmin/

# port settings
## httpd : http, https
EXPOSE 80 443

# env settings
ENV TERM xterm

# 時間の設定
RUN rm /etc/localtime; ln -s /usr/share/zoneinfo/Asia/Tokyo /etc/localtime;

# メールログ用スクリプト
COPY sendmail /usr/sbin/
RUN chmod 777 /usr/sbin/sendmail

# import db
COPY createdb.sql /root/
COPY data.sql /root/
RUN service mysqld start; mysql < /root/createdb.sql;　
RUN rm -f /root/createdb.sql /root/data.sql 

# copy conf files
#COPY .bashrc /root/
## php
COPY zzz-myphp.ini /etc/php.d/

## httpd
COPY zzz-myhttpd.conf /etc/httpd/conf.d/
### httpd.confの末尾にもう一度読み込む。/var/www/htmlの設定を上書きするため。 
RUN echo Include conf.d/zzz-myhttpd.conf | cat >> /etc/httpd/conf/httpd.conf 


# start os
CMD ["/sbin/init"]
