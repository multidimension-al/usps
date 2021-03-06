<?php
/**
 *       __  ___      ____  _     ___                           _                    __
 *      /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *     / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ /
 *    / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /
 *   /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/
 *
 *  USPS API PHP Library
 *  Copyright (c) Multidimension.al (http://multidimension.al)
 *  Github : https://github.com/multidimension-al/usps
 *
 *  Licensed under The MIT License
 *  For full copyright and license information, please see the LICENSE file
 *  Redistributions of files must retain the above copyright notice.
 *
 *  @copyright  Copyright © 2017-2019 Multidimension.al (http://multidimension.al)
 *  @link       https://github.com/multidimension-al/usps Github
 *  @license    http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Multidimensional\USPS\Test\Rate;

use Exception;
use Multidimensional\USPS\Rate\Package;
use Multidimensional\USPS\Rate\Package\Content;
use Multidimensional\USPS\Rate\Package\SpecialServices;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    public $package;
    public $defaultArray = [];

    public function setUp()
    {
        $this->defaultArray = ['@ID' => '123', 'Service' => 'All', 'FirstClassMailType' => 'PARCEL', 'ZipOrigination' => '20500', 'ZipDestination' => '90210', 'Pounds' => 0, 'Ounces' => 32, 'Container' => 'VARIABLE', 'Size' => 'REGULAR', 'Machinable' => true];
    }

    public function tearDown()
    {
        $this->package = null;
        $this->defaultArray = [];
    }

    public function testDefault()
    {
        $this->package = new Package($this->defaultArray);
        $result = $this->package->toArray();
        $expected = $this->defaultArray;
        $this->assertEquals($expected, $result);
    }

    public function testNamedFunctions()
    {
        $this->package = new Package;
        $this->package->setID(123);
        $this->package->setService(Package::SERVICE_ALL);
        $this->package->setFirstClassMailType(Package::FIRST_CLASS_MAIL_TYPE_PARCEL);
        $this->package->setZipOrigination('20500');
        $this->package->setZipDestination('90210');
        $this->package->setPounds(0.0);
        $this->package->setOunces(32);
        $this->package->setSize(Package::SIZE_REGULAR);
        $this->package->setContainer(Package::CONTAINER_VARIABLE);
        $this->package->setWidth(2);
        $this->package->setLength(2);
        $this->package->setHeight(2);
        $this->package->setGirth(10);
        $this->package->setValue(100.00);
        $this->package->setAmountToCollect(0.00);
        $this->package->setGroundOnly(false);
        $this->package->setSortBy(false);
        $this->package->setMachinable(true);
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['Width' => 2, 'Length' => 2, 'Height' => 2, 'Girth' => 10, 'Value' => 100.00, 'AmountToCollect' => 0.00, 'GroundOnly' => false, 'SortBy' => false];
        $this->assertEquals($expected, $result);
    }

    public function testDefaultArray()
    {
        $this->package = new Package($this->defaultArray);
        $result = $this->package->toArray();
        $expected = $this->defaultArray;
        $this->assertEquals($expected, $result);
    }

    public function testAddContent()
    {
        $this->package = new Package($this->defaultArray);
        $content = new Content(['ContentType' => Content::TYPE_HAZMAT]);
        $this->package->addContent($content);
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['Content' => ['ContentType' => 'HAZMAT', 'ContentDescription' => null]];
        $this->assertEquals($expected, $result);
    }

    public function testAddSpecialServices()
    {
        $this->package = new Package($this->defaultArray);
        $specialServices = new SpecialServices([SpecialServices::INSURANCE]);
        $this->package->addSpecialServices($specialServices);
        $result = $this->package->toArray();
        $expected = $this->defaultArray + ['SpecialServices' => [['SpecialService' => SpecialServices::INSURANCE]]];
        $this->assertEquals($expected, $result);
    }


    public function testConstants()
    {
        $this->assertEquals('VARIABLE', Package::CONTAINER_VARIABLE);
        $this->assertEquals('FLAT RATE ENVELOPE', Package::CONTAINER_FLAT_RATE_ENVELOPE);
        $this->assertEquals('PADDED FLAT RATE ENVELOPE', Package::CONTAINER_PADDED_FLAT_RATE_ENVELOPE);
        $this->assertEquals('LEGAL FLAT RATE ENVELOPE', Package::CONTAINER_LEGAL_FLAT_RATE_ENVELOPE);
        $this->assertEquals('SM FLAT RATE ENVELOPE', Package::CONTAINER_SM_FLAT_RATE_ENVELOPE);
        $this->assertEquals('WINDOW FLAT RATE ENVELOPE', Package::CONTAINER_WINDOW_FLAT_RATE_ENVELOPE);
        $this->assertEquals('GIFT CARD FLAT RATE ENVELOPE', Package::CONTAINER_GIFT_CARD_FLAT_RATE_ENVELOPE);
        $this->assertEquals('FLAT RATE BOX', Package::CONTAINER_FLAT_RATE_BOX);
        $this->assertEquals('SM FLAT RATE BOX', Package::CONTAINER_SM_FLAT_RATE_BOX);
        $this->assertEquals('MD FLAT RATE BOX', Package::CONTAINER_MD_FLAT_RATE_BOX);
        $this->assertEquals('LG FLAT RATE BOX', Package::CONTAINER_LG_FLAT_RATE_BOX);
        $this->assertEquals('REGIONALRATEBOXA', Package::CONTAINER_REGIONALRATEBOXA);
        $this->assertEquals('REGIONALRATEBOXB', Package::CONTAINER_REGIONALRATEBOXB);
        $this->assertEquals('RECTANGULAR', Package::CONTAINER_RECTANGULAR);
        $this->assertEquals('NONRECTANGULAR', Package::CONTAINER_NONRECTANGULAR);
        $this->assertEquals('LETTER', Package::FIRST_CLASS_MAIL_TYPE_LETTER);
        $this->assertEquals('FLAT', Package::FIRST_CLASS_MAIL_TYPE_FLAT);
        $this->assertEquals('PARCEL', Package::FIRST_CLASS_MAIL_TYPE_PARCEL);
        $this->assertEquals('POSTCARD', Package::FIRST_CLASS_MAIL_TYPE_POSTCARD);
        $this->assertEquals('PACKAGE', Package::FIRST_CLASS_MAIL_TYPE_PACKAGE);
        $this->assertEquals('PACKAGE SERVICE', Package::FIRST_CLASS_MAIL_TYPE_PACKAGE_SERVICE);
        $this->assertEquals('First Class', Package::SERVICE_FIRST_CLASS);
        $this->assertEquals('First Class Commercial', Package::SERVICE_FIRST_CLASS_COMMERCIAL);
        $this->assertEquals('First Class HFP Commercial', Package::SERVICE_FIRST_CLASS_HFP_COMMERCIAL);
        $this->assertEquals('Priority', Package::SERVICE_PRIORITY);
        $this->assertEquals('Priority Commercial', Package::SERVICE_PRIORITY_COMMERCIAL);
        $this->assertEquals('Priority Cpp', Package::SERVICE_PRIORITY_CPP);
        $this->assertEquals('Priority HFP Commercial', Package::SERVICE_PRIORITY_HFP_COMMERCIAL);
        $this->assertEquals('Priority HFP CPP', Package::SERVICE_PRIORITY_HFP_CPP);
        $this->assertEquals('Priority Mail Express', Package::SERVICE_PRIORITY_EXPRESS);
        $this->assertEquals('Priority Mail Express Commercial', Package::SERVICE_PRIORITY_EXPRESS_COMMERCIAL);
        $this->assertEquals('Priority Mail Express CPP', Package::SERVICE_PRIORITY_EXPRESS_CPP);
        $this->assertEquals('Priority Mail Express SH', Package::SERVICE_PRIORITY_EXPRESS_SH);
        $this->assertEquals('Priority Mail Express SH COMMERCIAL', Package::SERVICE_PRIORITY_EXPRESS_SH_COMMERCIAL);
        $this->assertEquals('Priority Mail Express HFP', Package::SERVICE_PRIORITY_EXPRESS_HFP);
        $this->assertEquals('Priority Mail Express HFP COMMERCIAL', Package::SERVICE_PRIORITY_EXPRESS_HFP_COMMERCIAL);
        $this->assertEquals('Priority Mail Express HFP CPP', Package::SERVICE_PRIORITY_EXPRESS_HFP_CPP);
        $this->assertEquals('Retail Ground', Package::SERVICE_GROUND);
        $this->assertEquals('Media', Package::SERVICE_MEDIA);
        $this->assertEquals('Library', Package::SERVICE_LIBRARY);
        $this->assertEquals('All', Package::SERVICE_ALL);
        $this->assertEquals('Online', Package::SERVICE_ONLINE);
        $this->assertEquals('Plus', Package::SERVICE_PLUS);
        $this->assertEquals('LARGE', Package::SIZE_LARGE);
        $this->assertEquals('REGULAR', Package::SIZE_REGULAR);
    }

    public function testFailure()
    {
        $this->package = new Package;
        try {
            $result = $this->package->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Required value not found for key: Service.', $e->getMessage());
        }
    }

    public function testID()
    {
        $this->defaultArray['ID'] = 123;
        unset($this->defaultArray['@ID']);
        $this->package = new Package($this->defaultArray);
        $result = $this->package->toArray();
        $this->defaultArray['@ID'] = 123;
        unset($this->defaultArray['ID']);
        $expected = $this->defaultArray;
        $this->assertEquals($expected, $result);
    }
}
