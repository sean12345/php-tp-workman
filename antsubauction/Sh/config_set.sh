#! /bin/sh
set –e

DESC="AN Conf  Set"

cd ../

## copy configure files from production env

if [ ! -d "Application/Common/Conf/" ]; then
        mkdir -p Application/Common/Conf/
        cp -fR Application/Common/Conf_Product/* Application/Common/Conf/
fi

if [ ! -d "Application/Auction/Conf/" ]; then
        mkdir -p Application/Auction/Conf/
        cp -fR Application/Auction/Conf_Product/* Application/Auction/Conf/
fi

if [ ! -d "Cli/Common/Conf/" ]; then
        mkdir -p Cli/Common/Conf/
        cp -fR Cli/Common/Conf_Product/* Cli/Common/Conf/
fi

if [ ! -d "Cli/Auction/Conf/" ]; then
        mkdir -p Cli/Auction/Conf/
        cp -fR Cli/Auction/Conf_Product/* Cli/Auction/Conf/
fi

## 初始化目录
mkdir -m 777 -p Application/Runtime
mkdir -m 777 -p Cli/Runtime
mkdir -m 777 -p Cli/Auction/Data

## clear Runtime 
rm -fr Application/Runtime/*
rm -fr Cli/Runtime/*

## set Application configure------------------------------------
vim Application/Auction/Conf/config.php
vim Application/Auction/Conf/db.php
vim Application/Auction/Conf/redis.php

## set Cli configure------------------------------------------
vim Cli/Auction/Conf/config.php
vim Cli/Auction/Conf/car_config.php

vim Cli/Common/Conf/db.php
vim Cli/Common/Conf/redis.php

exit 0

