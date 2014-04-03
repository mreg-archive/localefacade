# ledgr/localefacade [![Latest Stable Version](https://poser.pugx.org/ledgr/localefacade/v/stable.png)](https://packagist.org/packages/ledgr/localefacade) [![Build Status](https://travis-ci.org/ledgr/localefacade.png)](https://travis-ci.org/ledgr/localefacade) [![Dependency Status](https://gemnasium.com/ledgr/localefacade.png)](https://gemnasium.com/ledgr/localefacade)


OO wrapper to [symfony/locale](https://github.com/symfony/Locale) (and the
[Locale](http://www.php.net/manual/en/class.locale.php) class of the Intl extension)


Installation using [composer](http://getcomposer.org/)
------------------------------------------------------
Simply add `ledgr/localefacade` to your list of required libraries.


Usage
-----
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


Run tests  using [phpunit](http://phpunit.de/)
----------------------------------------------
To run the tests you must first install dependencies using composer.

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    $ phpunit
