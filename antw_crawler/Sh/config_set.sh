#! /bin/sh

DESC="AN Conf  Set"

cd ../

## copy configure files from production env

if [ ! -d "Application/Common/Conf/" ]; then
        mkdir -p Application/Common/Conf/
        cp -fR Application/Common/Conf_Product/* Application/Common/Conf/
fi

if [ ! -d "Application/Crawler/Conf/" ]; then
        mkdir -p Application/Crawler/Conf/
        cp -fR Application/Crawler/Conf_Product/* Application/Crawler/Conf/
fi

if [ ! -d "Cli/Common/Conf/" ]; then
        mkdir -p Cli/Common/Conf/
        cp -fR Cli/Common/Conf_Product/* Cli/Common/Conf/
fi

if [ ! -d "Cli/Crawler/Conf/" ]; then
        mkdir -p Cli/Crawler/Conf/
        cp -fR Cli/Crawler/Conf_Product/* Cli/Crawler/Conf/
fi

## 初始化目录
mkdir -m 777 -p Application/Runtime
mkdir -m 777 -p Cli/Runtime
mkdir -m 777 -p Cli/Crawler/Data

## clear Runtime 
rm -fr Application/Runtime/*
rm -fr Cli/Runtime/*

## set Application configure------------------------------------

vim Application/Crawler/Conf/db.php
vim Application/Crawler/Conf/redis.php

## set Cli configure------------------------------------------
vim Cli/Common/Conf/db.php
vim Cli/Common/Conf/redis.php


vim Cli/Crawler/Conf/db.php
vim Cli/Crawler/Conf/redis.php

exit 0

