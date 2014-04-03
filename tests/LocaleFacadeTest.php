<?php

namespace ledgr\localefacade;

class LocaleFacadeTest extends \PHPUnit_Framework_TestCase
{
    public function testSetDefault()
    {
        $l = new LocaleFacade();
        $l->setDefault('se');
        $this->assertEquals('se', $l->getLocale());
    }

    public function testGetDisplayName()
    {
        $l = new LocaleFacade('de');
        $this->assertEquals('Deutsch', $l->getDisplayName());
    }

    public function testGetPrimaryLanguage()
    {
        $l = new LocaleFacade('zh-Hant');
        $this->assertEquals('zh', $l->getPrimaryLanguage());
    }

    public function testGetDisplayLanguage()
    {
        $l = new LocaleFacade('sl-Latn-IT-nedis');
        $this->assertEquals('slovenščina', $l->getDisplayLanguage());
    }

    public function testGetRegion()
    {
        $l = new LocaleFacade('de-CH-1901');
        $this->assertEquals('CH', $l->getRegion());
    }

    public function testGetDisplayRegion()
    {
        $l = new LocaleFacade('sl-Latn-IT-nedis');
        $this->assertEquals('Italija', $l->getDisplayRegion());
    }

    public function testGetScript()
    {
        $l = new LocaleFacade('sr-Cyrl');
        $this->assertEquals('Cyrl', $l->getScript());
    }

    public function testGetDisplayScript()
    {
        $l = new LocaleFacade('sl-Latn-IT-nedis');
        $this->assertEquals('latinica', $l->getDisplayScript());
    }

    public function testGetKeywords()
    {
        $l = new LocaleFacade('de_DE@currency=EUR;collation=PHONEBOOK');
        $this->assertEquals(
            array(
                'collation' => 'PHONEBOOK',
                'currency' => 'EUR'
            ),
            $l->getKeywords()
        );
    }

    public function testGetAllVariants()
    {
        $l = new LocaleFacade('sl_IT_NEDIS_ROJAZ_1901');
        $this->assertEquals(
            array (
                'NEDIS',
                'ROJAZ',
                '1901',
            ),
            $l->getAllVariants()
        );
    }

    public function testGetDisplayVariant()
    {
        $l = new LocaleFacade('sl-Latn-IT-nedis');
        $this->assertEquals('nadiško narečje', $l->getDisplayVariant());
    }

    public function testParseLocal()
    {
        $l = new LocaleFacade('sl-Latn-IT-nedis');
        $this->assertEquals(
            array(
                'language' => 'sl',
                'script' => 'Latn',
                'region' => 'IT',
                'variant0' => 'NEDIS'
            ),
            $l->parseLocale()
        );
    }

    public function testCreateFromList()
    {
        $possibleLocales = array(
            'de-DEVA',
            'de-DE-1996',
            'de',
            'de-De'
        );
        $l = new LocaleFacade('de-DE-1996-x-prv1-prv2', $possibleLocales);
        $this->assertEquals('de-DE-1996', $l->getLocale());
    }

    public function testFilterMatches()
    {
        $l = new LocaleFacade('de-DE');
        $this->assertFalse($l->filterMatches('de-DEVA'));
        $this->assertTrue($l->filterMatches('de-DE_1996'));
    }

    public function testComposeLocale()
    {
        $l = LocaleFacade::composeLocale(
            array(
                'language'=>'en' ,
                'script'  =>'Hans' ,
                'region'  =>'CN',
                'variant2'=>'rozaj' ,
                'variant1'=>'nedis' ,
                'private1'=>'prv1' ,
                'private2'=>'prv2'
            )
        );
        $this->assertEquals('en_Hans_CN_nedis_rozaj_x_prv1_prv2', $l->getLocale());
    }

    public function testAcceptFromHttp()
    {
        $l = LocaleFacade::acceptFromHttp('sv-SE,sv;q=0.8,en-US;q=0.6,en;q=0.4');
        $this->assertEquals('sv_SE', $l->getLocale());
    }

    public function testGetDisplayCountries()
    {
        $l = new LocaleFacade('sv');
        $countries = $l->getDisplayCountries();
        $this->assertEquals('Sverige', $countries['SE']);
    }

    public function testGetDisplayLanguages()
    {
        $l = new LocaleFacade('sv');
        $languages = $l->getDisplayLanguages();
        $this->assertEquals('svenska', $languages['sv']);
    }

    public function testGetDisplayLocales()
    {
        $l = new LocaleFacade('sv');
        $locales = $l->getDisplayLocales();
        $this->assertEquals('svenska', $locales['sv']);
    }

    public function testCreateCollator()
    {
        $l = new LocaleFacade('sv');
        $collator = $l->createCollator();
        $this->assertEquals('sv', $collator->getLocale(\Locale::ACTUAL_LOCALE));
    }

    public function testCreateNumberFormatter()
    {
        $l = new LocaleFacade('sv');
        $numberFormatter = $l->createNumberFormatter(\NumberFormatter::DECIMAL);
        $this->assertEquals('sv', $numberFormatter->getLocale(\Locale::ACTUAL_LOCALE));
    }

    public function testCreateMessageFormatter()
    {
        $l = new LocaleFacade('sv');
        $messageFormatter = $l->createMessageFormatter('{0,number,integer} monkeys');
        $this->assertEquals('sv', $messageFormatter->getLocale());
    }

    public function testCreateIntlDateFormatter()
    {
        $l = new LocaleFacade('sv');
        $intlDateFormatter = $l->createIntlDateFormatter(\IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $this->assertEquals('sv', $intlDateFormatter->getLocale());
    }
}
