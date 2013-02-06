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
}
