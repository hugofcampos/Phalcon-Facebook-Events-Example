#!/bin/sh
grep phalcon /etc/php5/apache2/php.ini > /dev/null
if [ $? -ne 0 ]; then
 echo 'extension=phalcon.so' >> /etc/php5/apache2/php.ini
fi
