# Status-siden til fjellserver skrevet med PhP og Laravel
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
chgrp -R www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
```
## Tips
Dersom det oppstår problemer prøv:
```
php artisan optimize
```
Husk å lag bruker! Filen finnes under:
```
config/fortify.php

Dersom du ikke ønsker at hvemsom helst kan registrere seg
//Features::registration()
```

Discord Webhook finnes under /config/discord.php

# Lenker
```
/register
/login
/dashboard
```
# Bilder
Status-side
![status side](https://www.nextcloud.pomdre.net/index.php/apps/files_sharing/publicpreview/49SewcakqTFq36R?x=3831&y=1422&a=true&file=status%2520side.PNG&scalingup=0)

Dashboard for admin
![admin](https://www.nextcloud.pomdre.net/index.php/apps/files_sharing/publicpreview/MiqpWNYqnyjqKMX?x=3831&y=1422&a=true&file=status%2520admin.PNG&scalingup=0)
