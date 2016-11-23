#! /bin/sh
# set –e
PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin
DESC="AN Monitor Service Restart"

# cd ../
#*/1  * * * *   root    php /home/vagrant/www/ant_nest/cli.php Monitor/ServerMon/run

ROOTPATH=$(dirname $(pwd));

echo $ROOTPATH


tmpfile=./tmp_crontab.txt
crontab -l > $tmpfile

echo "*/5  * * * *   root    php ${ROOTPATH}/cli.php Monitor/ServerMon/run" >> $tmpfile
crontab - < $tmpfile && rm $tmpfile

crontab -l

exit 0