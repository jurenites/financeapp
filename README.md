# Funds Request App

## Requirements
	PHP >=5.5.9
	unoconv (https://github.com/dagwieers/unoconv)
	maybe libreoffice python (https://github.com/dagwieers/unoconv#user-content-problems-running-unoconv-from-nginx-apache-php)

## Install

chmod -R o+w storage
composer install
cp .env.example .env
	- DB connection settings
	- SMTP settings
	- APP_DOMAIN important, links in emails are using this param
	- LIBREOFFICE_PYTHON_PATH empty if "unoconv -f pdf [FILE_PATH]" is working properly, path to libreoffice python otherwise
	- UNOCONV_PATH `unoconv` if in PATH, path to unoconv otherwise
php artisan key:generate
php artisan migrate
php artisan db:seed
crontab -e
	- "* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1"

## Console commands
	php artisan emails:send - Sends batch of queued emails
	php artisan documents:convert - Converts all non-pdf documents to pdf
	php artisan request_forms:check_pending - Sends emails to budget managers with pending request forms

## Tips
	- In `admin` account you can use route: '/admin/debug' -> Admin\DebugController@index in debug purposes
	- ClearDataTablesSeeder clears all DB tables
	- Daily log (storage/logs/*) contains information about all requests (User, Date, Route) 