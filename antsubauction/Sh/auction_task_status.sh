#! /bin/sh
# set –e

DESC="AN Auction Task Service Restart"

CurrentDir=$1

if [ -d "$CurrentDir" ]; then
        cd $CurrentDir
else
        cd ../
fi

php cli.php Auction/OrderSub/subProcess status  # 拍单订阅分发服务状态查看
php cli.php Auction/OrderSubPush/subPushProcess status  # 拍单订阅Jpush推送服务状态查看

exit 0