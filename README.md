# AdoptOrNot API
REST/JSON API for Adopt or Not, powered by [Adoptable Pet Data from RescueGroups.org][0].

## Installation

An `.env` file must be created to store the application's config:

```
# Application's MySQL Settings
ADOPTORNOT_MYSQL_HOSTNAME=
ADOPTORNOT_MYSQL_USERNAME=
ADOPTORNOT_MYSQL_PASSWORD=
ADOPTORNOT_MYSQL_DATABASE=

# RescueGroups.org FTP Credentials
RESCUEGROUPS_FTP_HOSTNAME=
RESCUEGROUPS_FTP_USERNAME=
RESCUEGROUPS_FTP_PASSWORD=
```

Once configured, install using Composer:

```
composer install
```


[0]: https://userguide.rescuegroups.org/display/APIDG/Complete+Adoptable+Pet+Data+Download+via+FTP