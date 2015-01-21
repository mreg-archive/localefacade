> **NOTE:** The symfony Locale component is deprecated since symfony 2.3, use the Intl component instead.
> LocaleFacade will not be updated as it is not neccessary when using the Intl component.

> See [the symfony documentation](http://symfony.com/doc/current/components/intl.html).

LocaleFacade [deprecated]
=========================

OO wrapper to [symfony/locale](https://github.com/symfony/Locale) (and the
[Locale](http://www.php.net/manual/en/class.locale.php) class of the Intl extension)

Installation 
------------
Install using [composer](http://getcomposer.org/)

    composer require ledgr/localefacade

Usage
-----
```php
use ledgr\localefacade\LocaleFacade;

$l = new LocaleFacade('de');

// Prints 'Deutsch'
echo $l->getDisplayName();

// Prints 'Schweden'
echo $l->getDisplayCountries()['SE'];

$arr = array(
    'ü',
    'u',
    'ß',
    's'
);
$l->createCollator()->sort($arr);

// Prints 's, ß, u, ü'
print_r($arr);

// And all the other Locale methods...
```

Run tests  using [phpunit](http://phpunit.de/)
----------------------------------------------
To run the tests you must first install dependencies using composer.

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    $ phpunit
