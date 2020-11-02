#Cron jobb for å teste om en server er oppe eller nede
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
#For å starte den lokalt
php artisan schedule:work