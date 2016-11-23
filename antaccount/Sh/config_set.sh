#! /bin/sh
# set –e

DESC="AN Conf  Set"

cd ../

## copy configure files from production env

if [ ! -d "Application/Common/Conf/" ]; then
        mkdir -p Application/Common/Conf/
        cp -fR Application/Common/Conf_Product/* Application/Common/Conf/
fi

if [ ! -d "Application/Ucenter/Conf/" ]; then
        mkdir -p Application/Ucenter/Conf/
        cp -fR Application/Ucenter/Conf_Product/* Application/Ucenter/Conf/
fi


## set Application configure------------------------------------
vim Application/Ucenter/Conf/config.php
vim Application/Ucenter/Conf/db.php

## 初始化目录
mkdir -m 777 -p Application/Runtime/*
## clear Runtime 
rm -fr Application/Runtime/*

exit 0
