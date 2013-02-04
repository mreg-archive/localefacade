# localefacade

OO wrapper to symfony/locale (and the Locale class of the Intl extension)


## Running the unit tests

To run the tests you must first install the dependencies.

    > curl -s https://getcomposer.org/installer | php
    > php composer.phar install

And then from the *tests* directory

    > phpunit

### Using phing

You may also run tests and code analysis using Phing. To install phing type

    > sudo pear config-set preferred_state alpha
    > sudo pear install --alldeps phing/phing
    > sudo pear config-set preferred_state stable

Then from the project root directory

    > phing

This will run the tests and a number of other code analysis tools. Point your
browser to *build/index.html* to view the results.
