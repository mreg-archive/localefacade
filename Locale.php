<?php
/**
 * This file is part of the localewrapper package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\localewrapper;

use Locale as IntlLocale;
use Symfony\Component\Locale\Locale as SymfonyLocale;

/**
 * Wrapper to symfony/locale
 *
 * All methods behava as the symfony/locale or intl/Locale mehtods, extept that
 * $locale is never passed as a method parameter. Instead use setLocale.
 *
 * @author  Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package localewrapper;
 */
class Locale
{
    /**
     * @var string Current locale
     */
    private $locale;

    /**
     * Constructor
     *
     * @param string $locale
     */
    public function __construct($locale = '')
    {
        if ($locale) {
            $this->setLocale($locale);
        }
    }

    /**
     * Set the object locale
     *
     * @param  string $locale
     * @return void
     */
    public function setLocale($locale)
    {
        assert('is_string($locale)');
        $this->locale = $locale;
    }

    /**
     * sets the default runtime locale
     *
     * @param  string  $locale Is a BCP 47 compliant language tag
     * @return boolean TRUE on success or FALSE on failure
     */
    public function setDefault($locale)
    {
        return IntlLocale::setDefault($locale);
    }

    /**
     * Gets the default locale value from the INTL global 'default_locale'
     *
     * @return string The current runtime locale
     */
    public function getDefault()
    {
        return IntlLocale::getDefault();
    }

    /**
     * Get the current object locale
     *
     * @return string
     */
    public function getLocale()
    {
        if (!isset($this->locale)) {
            $this->setLocale($this->getDefault());
        }

        return $this->locale;
    }

    /**
     * Returns an appropriately localized display name for the locale
     *
     * @param  string $inLocale Optional format locale
     * @return string           Name of the locale in the format appropriate for $inLocale
     */
    public function getDisplayName($inLocale = '')
    {
        if (!$inLocale) {
            $inLocale = $this->getLocale();
        }

        return IntlLocale::getDisplayName($this->getLocale(), $inLocale);
    }

    /**
     * Gets the primary language for the input locale
     *
     * @return string The language code associated with the language or NULL in
     *     case of error
     */
    public function getPrimaryLanguage()
    {
        return IntlLocale::getPrimaryLanguage($this->getLocale());
    }

    /**
     * Returns an appropriately localized display name for language of the locale
     *
     * @param  string $inLocale Optional format locale to use to display the language name
     * @return string           Name of language in the format appropriate for $inLocale.
     */
    public function getDisplayLanguage($inLocale = '')
    {
        if (!$inLocale) {
            $inLocale = $this->getLocale();
        }

        return IntlLocale::getDisplayLanguage($this->getLocale(), $inLocale);
    }

    /**
     * Gets the region for the input locale
     *
     * @return string The region subtag for the locale or NULL if not present
     */
    public function getRegion()
    {
        return IntlLocale::getRegion($this->getLocale());
    }

    /**
     * Returns an appropriately localized display name for region of the locale
     *
     * @param  string $inLocale Optional format locale to use to display the language name
     * @return string           Name of the region in the format appropriate for $inLocale
     */
    public function getDisplayRegion($inLocale = '')
    {
        if (!$inLocale) {
            $inLocale = $this->getLocale();
        }

        return IntlLocale::getDisplayRegion($this->getLocale(), $inLocale);
    }

    /**
     * Gets the script for the locale
     *
     * @return string The script subtag for the locale or NULL if not present
     */
    public function getScript()
    {
        return IntlLocale::getScript($this->getLocale());
    }

    /**
     * Returns an appropriately localized display name for script of the locale
     *
     * @param  string $inLocale Optional format locale to use to display the script name
     * @return string           Name of the script in the format appropriate for $inLocale.
     */
    public function getDisplayScript($inLocale = '')
    {
        if (!$inLocale) {
            $inLocale = $this->getLocale();
        }

        return IntlLocale::getDisplayScript($this->getLocale(), $inLocale);
    }

    /**
     * Gets the keywords for the locale
     *
     * @return array Associative array containing the keyword-value pairs for locale
     */
    public function getKeywords()
    {
        return IntlLocale::getKeywords($this->getLocale());
    }

    /**
     * Gets the variants for the input locale
     *
     * @return array A list of all variants subtag for the locale or NULL if not present
     */
    public function getAllVariants()
    {
        return IntlLocale::getAllVariants($this->getLocale());
    }

    /**
     * Returns an appropriately localized display name for variants of the locale
     *
     * @param  string $inLocale Optional format locale to use to display the variant name
     * @return string           Name of the variant in the format appropriate for $inLocale
     */
    public function getDisplayVariant($inLocale = '')
    {
        if (!$inLocale) {
            $inLocale = $this->getLocale();
        }

        return IntlLocale::getDisplayVariant($this->getLocale(), $inLocale);
    }

    /**
     * Returns a key-value array of locale ID subtag elements
     *
     * @return array Returns an array containing a list of key-value pairs,
     *     where the keys identify the particular locale ID subtags, and the
     *     values are the associated subtag values. The array will be ordered
     *     as the locale id subtags e.g. in the locale id if variants are
     *     '-varX-varY-varZ' then the returned array will have variant0=>varX ,
     *     variant1=>varY , variant2=>varZ
     */
    public function parseLocale()
    {
        return IntlLocale::parseLocale($this->getLocale());
    }

    public function lookup(array $langtag, $canonicalize = false, $default = '')
    {
        return IntlLocale::lookup($langtag, $this->getLocale(), $canonicalize, $default);
    }
}

/*
De funktioner som kräver symfony\locale ska kasta undantag om klassen inte
    finns tillgänglig

Constructor ska kasta undantag och ext_intl inte finns tillgänglig

Skapa andra object som beror på Locale
    lägg till createCollator för att skapa en collator med den här locale..
    lägg till createNumberFormattor för att skapa detta...
    createMessageFormattor
    createIntlDateFormattor
    createResourceBundle

ok, det finns två olika locales här:

    den vi vill läsa namnet på språket för
    samt den vi vill ha namnet på språket översatt för..
 */

header('Content-Type: text/plan; charset=utf8');

$l = new Locale();

$l->setDefault('de-DE-1996-x-prv1-prv2');

echo $l->getLocale() . "\n";
echo $l->getDisplayName() . "\n\n";

echo $l->getPrimaryLanguage() . "\n";
echo $l->getDisplayLanguage() . "\n\n";

echo $l->getRegion() . "\n";
echo $l->getDisplayRegion() . "\n\n";

echo $l->getScript() . "\n";
echo $l->getDisplayScript() . "\n\n";

print_r($l->getKeywords());

print_r($l->getAllVariants());
echo $l->getDisplayVariant() . "\n\n";

print_r($l->parseLocale());

echo $l->lookup(array(
    'de-DEVA',
    'de-DE-1996',
    'de',
    'de-De'
));