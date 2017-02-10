<?php
/**
 * CONFIDENTIAL
 *
 * © 2017 Multidimension.al - All Rights Reserved
 * 
 * NOTICE:  All information contained herein is, and remains
 * the property of Multidimension.al and its suppliers,
 * if any.  The intellectual and technical concepts contained
 * herein are proprietary to Multidimension.al and its suppliers
 * and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained.
 */

namespace Multidimensional\Usps\Test;

use Multidimensional\Usps\Rate\Package;
use PHPUnit_Framework_TestCase;

class PackageTest extends TestCase
{
    public function testNamedFunctions()
    {
        $package = new Package();
        $package->setService();
        $package->setFirstClassMailType();
        $package->setZipOrigination();
        $package->setZipDestination();
        $package->setPounds();
        $package->setOunces();
        $package->setSize();
        $package->setContainer();
        $package->setWidth();
        $package->setLength();
        $package->setHeight();
        $package->setGirth();
        $package->setValue();
        $package->setAmountToCollect();
        $package->setGroundOnly();
        $package->setSortBy();
        $package->setMachinable();
        
        
        
    }
    
}