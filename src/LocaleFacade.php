<?php
/**
 * This file is part of the localefacade package
 *
 * Copyright (c) 2013 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\localefacade;

use Locale as IntlLocale;
use Symfony\Component\Locale\Locale as SymfonyLocale;
use Collator;
use NumberFormatter;
use MessageFormatter;
use IntlDateFormatter;

/**
 * OO wrapper to symfony/locale (and the Locale class of the Intl extension)
 *
 * All methods behava as the symfony/locale or intl/Locale mehtods, extept that
 * $locale is never passed as a method parameter. Instead use setLocale.
 * Additional methods for creating related Intl objects are prefixed 'create'.
 *
 * @author  Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package localefacade
 */
class LocaleFacade
{
    /**
     * @var string Current locale
     */
    private $locale;

    /**
     * Constructor
     *
     * @param string $locale  The requested locale
     * @param array  $langtag An array containing a list of language tags to compare to locale.
     *     Maximum 100 items allowed. (If supplied the best match for $locale in $langtag
     *     will be used.)
     */
    public function __construct($locale = '', array $langtag = null)
    {
        if ($locale) {
            $this->setLocale($locale);
            if ($langtag) {
                $this->setLocale($this->lookup($langtag));
            }
        }
    }

    /**
     * Create a correctly ordered and delimited locale from subtags
     *
     * @param  array        $subtags an array containing a list of key-value
     *     pairs, where the keys identify the particular locale ID subtags, and
     *     the values are the associated subtag values.
     * @return LocaleFacade
     */
    public static function composeLocale(array $subtags)
    {
        $locale = IntlLocale::composeLocale($subtags);
        return new LocaleFacade($locale);
    }

    /**
     * Tries to find out best available locale based on HTTP "Accept-Language" header
     *
     * @param  string $header The string containing the "Accept-Language" header according to format in RFC 2616
     * @return LocaleFacade
     */
    public static function acceptFromHttp($header)
    {
        $locale = IntlLocale::acceptFromHttp($header);
        return new LocaleFacade($locale);
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

    /**
     * Searches the language tag list for the best match to the language
     *
     * @param  array  $langtag      An array containing a list of language tags to compare to locale.
     *     Maximum 100 items allowed.
     * @param  array  $canonicalize If true, the arguments will be converted to canonical form before matching.
     * @param  array  $default      The locale to use if no match is found.
     * @return string The closest matching language tag or default value.
     */
    public function lookup(array $langtag, $canonicalize = false, $default = '')
    {
        return IntlLocale::lookup($langtag, $this->getLocale(), $canonicalize, $default);
    }

    /**
     * Checks if a language tag filter matches with locale
     * 
     * @param  string  $langtag      The language tag to check
     * @param  boolean $canonicalize If true, the arguments will be converted to canonical form before matching
     * @return boolean               TRUE if locale matches $langtag FALSE otherwise
     */
    public function filterMatches($langtag, $canonicalize = false)
    {
        return IntlLocale::filterMatches($langtag, $this->getLocale(), $canonicalize);
    }

    /**
     * Returns the country names for locale
     *
     * @return array The country names with their codes as keys
     */
    public function getDisplayCountries()
    {
        return SymfonyLocale::getDisplayCountries($this->getLocale());
    }

    /**
     * Returns the language names for locale
     *
     * @return array The language names with their codes as keys
     */
    public function getDisplayLanguages()
    {
        return SymfonyLocale::getDisplayLanguages($this->getLocale());
    }

    /**
     * Returns the locale names for locale
     *
     * @return array The locale names with their codes as keys
     */
    public function getDisplayLocales()
    {
        return SymfonyLocale::getDisplayLocales($this->getLocale());
    }

    /**
     * Create a new Collator object for locale
     *
     * @return Collator
     */
    public function createCollator()
    {
        return new Collator($this->getLocale());
    }

    /**
     * Create a new NumberFormatter object for locale
     *
     * @param  int             $style   Style of the formatting, one of the format style constants.
     * @param  string          $pattern Pattern string if the chosen style requires a pattern.
     * @return NumberFormatter
     */
    public function createNumberFormatter($style, $pattern = null)
    {
        return new NumberFormatter($this->getLocale(), $style, $pattern);
    }

    /**
     * Create a new MessageFormatter object for locale
     *
     * @param  string           $pattern The pattern string to stick arguments into.
     * @return MessageFormatter
     */
    public function createMessageFormatter($pattern)
    {
        return new MessageFormatter($this->getLocale(), $pattern);
    }

    /**
     * Create a new IntlDateFormatter object for locale 
     * 
     * @param  int               $datetype Date type to use (none, short, medium, long, full)
     * @param  int               $timetype Time type to use (none, short, medium, long, full)
     * @param  string            $timezone Time zone ID, default is system default.
     * @param  int               $calendar Calendar to use for formatting or parsing; default is Gregorian.
     * @param  string            $pattern  Optional pattern to use when formatting or parsing.
     * @return IntlDateFormatter
     */
    public function createIntlDateFormatter(
        $datetype,
        $timetype,
        $timezone = null,
        $calendar = null,
        $pattern = null
    ) {
        return new IntlDateFormatter(
            $this->getLocale(),
            $datetype,
            $timetype,
            $timezone,
            $calendar,
            $pattern
        );
    }
}
