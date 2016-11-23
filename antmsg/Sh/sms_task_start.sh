#! /bin/sh
# set –e

DESC="AN SMS Task Service Restart"

CurrentDir=$1

if [ -d "$CurrentDir" ]; then
        cd $CurrentDir
else
        cd ../
fi

php cli.php SMS/NotifyMsg/msgProcess start
php cli.php SMS/VerifyMsg/msgProcess start

exit 0