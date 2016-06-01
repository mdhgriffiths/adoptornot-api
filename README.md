# AdoptOrNot API
REST/JSON API for Adopt or Not, powered by [Adoptable Pet Data from RescueGroups.org][0].

## Installation
An `.env` file must be created to store the application's config:

```
# MySQL Connection Settings
ADOPTORNOT_MYSQL_HOSTNAME=
ADOPTORNOT_MYSQL_USERNAME=
ADOPTORNOT_MYSQL_PASSWORD=
ADOPTORNOT_MYSQL_DATABASE=

# RescueGroups.org API Key
RESCUEGROUPS_APIKEY={XXXX}
```

Once configured, install using Composer:

```
composer install
```

Run application from `src/public` using the command:

```
php -S localhost:8000
```


[0]: https://userguide.rescuegroups.org/display/APIDG/Complete+Adoptable+Pet+Data+Download+via+FTP