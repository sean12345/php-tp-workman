#! /bin/sh

DESC="AN Conf  Set"

cd ../

## copy configure files from production env

if [ ! -d "Application/Common/Conf/" ]; then
        mkdir -p Application/Common/Conf/
        cp -fR Application/Common/Conf_Product/* Application/Common/Conf/
fi

if [ ! -d "Application/SMS/Conf/" ]; then
        mkdir -p Application/SMS/Conf/
        cp -fR Application/SMS/Conf_Product/* Application/SMS/Conf/
fi

if [ ! -d "Cli/Common/Conf/" ]; then
        mkdir -p Cli/Common/Conf/
        cp -fR Cli/Common/Conf_Product/* Cli/Common/Conf/
fi

if [ ! -d "Cli/SMS/Conf/" ]; then
        mkdir -p Cli/SMS/Conf/
        cp -fR Cli/SMS/Conf_Product/* Cli/SMS/Conf/
fi

## 初始化目录
mkdir -m 777 -p Application/Runtime
mkdir -m 777 -p Cli/Runtime
mkdir -m 777 -p Cli/SMS/Data

## clear Runtime 
rm -fr Application/Runtime/*
rm -fr Cli/Runtime/*

## set Application configure------------------------------------

vim Application/SMS/Conf/db.php
vim Application/SMS/Conf/redis.php

## set Cli configure------------------------------------------
vim Cli/Common/Conf/db.php
vim Cli/Common/Conf/redis.php

exit 0

