#!/bin/bash
sudo su
cd /home
wget https://packages.zendframework.com/releases/ZendFramework-1.12.3/ZendFramework-1.12.3.tar.gz
tar -xvzf ZendFramework-1.12.3.tar.gz
echo 'include_path = ".:/home/ZendFramework-1.12.3/library"' > /etc/php5/conf.d/zf.ini
echo 'LoadModule expires_module /usr/lib/apache2/modules/mod_expires.so' > /etc/apache2/mods-available/expires.load
ln -s /etc/apache2/mods-available/expires.load /etc/apache2/mods-enabled/expires.load
service apache2 restart