#! /bin/sh

DESC="AN Conf  Set"

cd ../

## copy configure files from production env

if [ ! -d "Application/Admin/Conf/" ]; then
        mkdir -p Application/Admin/Conf/
        cp -fR Application/Admin/Conf_Product/* Application/Admin/Conf/
fi

if [ ! -d "Application/Common/Conf/" ]; then
        mkdir -p Application/Common/Conf/
        cp -fR Application/Common/Conf_Product/* Application/Common/Conf/
fi


## 初始化目录
mkdir -m 777 -p Application/Runtime
mkdir -m 777 -p Cli/Runtime

## clear Runtime 
rm -fr Application/Runtime/*
rm -fr Cli/Runtime/*

## set Application configure------------------------------------
vim Application/Admin/Conf/config.php
vim Application/Admin/Conf/db.php
vim Application/Admin/Conf/redis.php


## set Cli configure------------------------------------------
vim Cli/Monitor/Conf/config.php


exit 0