## 蚁巢服务平台
### 来拍车拍单订阅服务

---
### 拍单订阅分发服务
```
> 1. 进入项目根目录
> 2. 启动服务
        #php cli.php Auction/OrderSub/subProcess start
> 3. 重启动服务
        #php cli.php Auction/OrderSub/subProcess restart
> 4. 停止服务
        #php cli.php Auction/OrderSub/subProcess stop
> 5. 检查服务状态
        #php cli.php Auction/OrderSub/subProcess status
> 6. 检查日志
        #tail -f Cli/Auction/Data/SubOrderWorker/stdout.log
> 7. 检查端口
        #lsof -i :10031
```

---
### 拍单订阅Jpush推送服务
```
> 1. 进入项目根目录
> 2. 启动服务
        #php cli.php Auction/OrderSubPush/subPushProcess start
> 3. 重启动服务
        #php cli.php Auction/OrderSubPush/subPushProcess restart
> 4. 停止服务
        #php cli.php Auction/OrderSubPush/subPushProcess stop
> 5. 检查服务状态
        #php cli.php Auction/OrderSubPush/subPushProcess status
> 6. 检查日志
        #tail -f Cli/Auction/Auction/Data/SubOrderPushWorker/stdout.log
> 7. 检查端口
        #lsof -i :10032
```
