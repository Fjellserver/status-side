# Status siden til fjellserver skrevet med PhP og Laravel
## Cron jobb for å teste om en server er oppe eller nede
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
## For å starte den lokalt
```
php artisan schedule:run
eller
php artisan schedule:work
```

## Installer
```
composer install --optimize-autoloader --no-dev
php artisan key:generate
npm install
php artisan migrate --force
```