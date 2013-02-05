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
}
