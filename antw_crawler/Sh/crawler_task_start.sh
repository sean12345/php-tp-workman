#! /bin/sh
# set –e

DESC="AW Crawler Task Service Restart"

CurrentDir=$1

if [ -d "$CurrentDir" ]; then
        cd $CurrentDir
else
        cd ../
fi

php cli.php Crawler/Youxinpai/getCrawlerTask start
php cli.php Crawler/Youxinpai/processCrawlerTask start
php cli.php Crawler/Youxinpai/crawlerTradePrice start

exit 0