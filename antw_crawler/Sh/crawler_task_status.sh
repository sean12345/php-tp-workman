#! /bin/sh
# set –e

DESC="AN SMS Task Service Restart"

CurrentDir=$1

if [ -d "$CurrentDir" ]; then
        cd $CurrentDir
else
        cd ../
fi

php cli.php Crawler/Youxinpai/getCrawlerTask status
php cli.php Crawler/Youxinpai/processCrawlerTask status
php cli.php Crawler/Youxinpai/crawlerTradePrice status

exit 0