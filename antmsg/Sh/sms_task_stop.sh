#! /bin/sh
# set –e

DESC="AN SMS Task Service Restart"

CurrentDir=$1

if [ -d "$CurrentDir" ]; then
        cd $CurrentDir
else
        cd ../
fi

php cli.php SMS/NotifyMsg/msgProcess stop
php cli.php SMS/VerifyMsg/msgProcess stop

exit 0