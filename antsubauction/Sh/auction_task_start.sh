#! /bin/sh
# set –e

DESC="AN Auction Task Service Restart"

CurrentDir=$1

if [ -d "$CurrentDir" ]; then
        cd $CurrentDir
else
        cd ../
fi

php cli.php Auction/OrderSub/subProcess start  # 启动拍单订阅分发服务
php cli.php Auction/OrderSubPush/subPushProcess start  # 启动拍单订阅Jpush推送服务

exit 0