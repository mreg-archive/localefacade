# localefacade


OO wrapper to symfony/locale (and the Locale class of the Intl extension)

**License**: [MIT](/LICENSE)


Installation using [composer](http://getcomposer.org/)
------------------------------------------------------
Simply add `__VENDOR_NAME__/__SKELETON_NAME__` to your list of required libraries.


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
