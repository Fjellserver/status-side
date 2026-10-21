# Status-siden til fjellserver skrevet med PHP og Laravel

Krever **PHP 8.3+** og kjører på **Laravel 13**.

## Cron jobb for å teste om en server er oppe eller nede
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
Sjekken ligger i kommandoen `php artisan status:check` og kjøres hvert minutt av scheduleren.
Den snakker bare HTTP(S), følger ikke redirects og gir opp etter 15 sekunder per tjeneste.

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
npm run build
php artisan migrate --force
chgrp -R www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
```

## Oppgradering fra tidligere versjon
```
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan optimize
```
Sesjoner lagres nå som JSON, så alle innloggede brukere må logge inn på nytt etter oppgraderingen.
Tabellen for tilbakestilling av passord heter nå `password_reset_tokens` (opprettes av `migrate`).
Vil du beholde den gamle tabellen, sett `AUTH_PASSWORD_RESET_TOKEN_TABLE=password_resets` i `.env`.

## Produksjon
I `.env` må disse være satt riktig:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://status.fjellserver.no
```
Sesjonskapselen merkes automatisk `Secure` når `APP_URL` starter med `https://`.

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

Discord Webhook er satt i .env med:
```
DISCORD_WEBHOOK=URL
DISCORD_WEBHOOK_DOWN_ALERT=URL
```
Bare adresser som starter med `https://discord.com/api/webhooks/` godtas.

## Tester
```
php artisan test
```

# Lenker
```
/register
/login
/dashboard
```
# Bilder
Status-side
![status side](https://nextcloud.pomdre.net/index.php/apps/files_sharing/publicpreview/o3zeHNG8Gz6co6p?x=3822&y=1421&a=true&file=status%2520side.PNG&scalingup=0)

Dashboard for admin
![admin](https://nextcloud.pomdre.net/index.php/apps/files_sharing/publicpreview/AGnSQXdmbqyHAHw?x=3822&y=1421&a=true&file=status%2520admin.PNG&scalingup=0)
