# PHP intl extension, ICU data tables

Live version is available at [http://intl.rmcreative.ru/](http://intl.rmcreative.ru/).

The project was created to simplify checking out various PHP intl / ICU / CLDR data which is mainly used in translation
strings without the need to check different websites and search huge data tables for locale you need.

Instead, you can enter locale code and get all the info for just that locale right away.

## What's currently displayed

- General locale info.
- Plural rules. Also [available via CLDR website](http://www.unicode.org/cldr/charts/27/supplemental/language_plural_rules.html).
- Numbering schemas. Not available anywhere but ICU resource sources which aren't too user-friendly to read.
- Number formatting rules and data.
- Currency data.
- Language data.
- Region data.
- Zone data.
- Unit data.

## Are examples broken?

There are [known issues](https://bugs.php.net/bug.php?id=70484) with PHP intl extension regarding usage of named
parameters such as `{n}`. The Severity of issues depends on PHP and intl versions used.
The primary goal of the project is to serve as an info source for using with
[Yii 2.0 framework](http://www.yiiframework.com/) which provides wrapper around intl allowing usage of named parameters in all possible cases.

If you're not using Yii, try positional placeholders such as `{0}` instead.

# Directory structure

    assets/             contains assets definition
    config/             contains application configurations
    controllers/        contains Web controller classes
    runtime/            contains files generated during runtime
    vendor/             contains dependent 3rd-party packages
    views/              contains view files for the Web application
    public/             contains the entry script and Web resources

# Requirements

The minimum requirement by this project that your Web server supports PHP 5.4.0 with mbstring and intl extensions.

# Using Docker

Copy `/config/csrf_key.php.example` to `/config/csrf_key.php`. Paste validation key there.

## Run a dev instance

```sh
make up
```

Access it at [http://localhost/](http://localhost/).

## Build production image and push it

```sh
make build
make push
```

## Deploy to production

```sh
make deploy
```

# Local installation

1. Download zip.
2. Copy `/config/csrf_key.php.example` to `/config/csrf_key.php`. Paste validation key there.
3. Run `composer global require "fxp/composer-asset-plugin:~1.1.0" && composer install`.
4. Configure your webserver to point to `/web`.
