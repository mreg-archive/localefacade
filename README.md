# localefacade

Description...


## Running the unit tests

To run the tests you must first install the dependencies

    > curl -s https://getcomposer.org/installer | php
    > php composer.phar install
    > phpunit


### Using phing

You may also run tests and code analysis using Phing.
[Installation instructions.](http://www.phing.info/trac/wiki/Users/Installation)

Then from the project root directory

    > phing

This will run the tests and a number of other code analysis tools. Point your
browser to *build/index.html* to view the results.
