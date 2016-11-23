#! /bin/sh
# set –e

DESC="AN SMS Task Service Restart"

CurrentDir=$1

if [ -d "$CurrentDir" ]; then
        cd $CurrentDir
else
        cd ../
fi

php cli.php SMS/NotifyMsg/msgProcess status
php cli.php SMS/VerifyMsg/msgProcess status

exit 0