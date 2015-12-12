PHP intl extension, ICU data tables
===================================

Live version is available at [http://intl.rmcreative.ru/](http://intl.rmcreative.ru/).

The project was created to simplify checking out various PHP intl / ICU / CLDR data which is mainly used in translation
strings without the need to check different websites and search huge data tables for locale you need.

Instead you can enter locale code and get all the info for just that locale right away.

## What's currently displayed

- Plural rules. Also [available via CLDR website](http://www.unicode.org/cldr/charts/27/supplemental/language_plural_rules.html).
- Numbering schemas. Not available anywhere but ICU resource sources which aren't too user friendly to read.

## Are examples broken?

There are [known issues](https://bugs.php.net/bug.php?id=70484) with PHP intl extension regarding usage of named
parameters such as `{n}`. Severity of issues depends on PHP and intl versions used. The primary goal of the project is to
serve as info source for using with [Yii 2.0 framework](http://www.yiiframework.com/) which provides wrapper around
intl allowing usage of named parameters in all possible cases.

If you're not using Yii, try positional placeholders such as `{0}` instead.
