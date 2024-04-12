#!/bin/sh

path=`pwd`
command1="* * * * * cd ${path} && /usr/bin/docker-compose exec -T app sh -c \"php artisan schedule:run >> /dev/null 2>&1\""

crontab -l > mycron
echo "${command1}" >> mycron
crontab mycron
rm mycron

echo "Command added: ${command1}"
