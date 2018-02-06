#! /bin/bash
# 重刷数据库
echo 'start'
php artisan migrate:refresh

php artisan db:seed
php artisan db:seed --class=UsersTableSeeder

nohup php artisan ide-helper:models &