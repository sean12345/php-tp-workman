## 蚁巢服务平台
### 短信发送服务

---
### 短信通知服务
```
> 1. 进入项目根目录
> 2. 启动服务
        #php cli.php SMS/NotifyMsg/msgProcess start
> 3. 重启动服务
        #php cli.php SMS/NotifyMsg/msgProcess restart
> 4. 停止服务
        #php cli.php SMS/NotifyMsg/msgProcess stop
> 5. 检查服务状态
        #php cli.php SMS/NotifyMsg/msgProcess status
> 6. 检查日志
        #tail -f Cli/Runtime/SMS/NotifyMsgWorker/stdout.log
> 7. 检查端口
        #lsof -i :10021
```

---
### 短信验证码服务
```
> 1. 进入项目根目录
> 2. 启动服务
        #php cli.php SMS/VerifyMsg/msgProcess start
> 3. 重启动服务
        #php cli.php SMS/VerifyMsg/msgProcess restart
> 4. 停止服务
        #php cli.php SMS/VerifyMsg/msgProcess stop
> 5. 检查服务状态
        #php cli.php SMS/VerifyMsg/msgProcess status
> 6. 检查日志
        #tail -f Cli/Runtime/SMS/VerifyMsgWorker/stdout.log
> 7. 检查端口
        #lsof -i :10022
```
