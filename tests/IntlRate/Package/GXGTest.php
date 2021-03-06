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

namespace Multidimensional\USPS\Test\IntlRate\Package;

use Exception;
use Multidimensional\USPS\IntlRate\Package\GXG;
use PHPUnit\Framework\TestCase;

class GXGTest extends TestCase
{
    protected $gxg;

    public function tearDown()
    {
        unset($this->gxg);
    }

    public function testNormal()
    {
        $this->gxg = new GXG(['POBoxFlag' => 'Y']);
        $this->gxg->setGiftFlag(GXG::GIFTFLAG_NO);
        $result = $this->gxg->toArray();
        $this->assertNotNull($result);
        $expected = ['POBoxFlag' => 'Y', 'GiftFlag' => 'N'];
        $this->assertEquals($expected, $result);
    }

    public function testSetFields()
    {
        $this->gxg = new GXG();
        $this->gxg->setPOBoxFlag(GXG::POBOXFLAG_YES);
        $this->gxg->setGiftFlag(GXG::GIFTFLAG_YES);
        $result = $this->gxg->toArray();
        $this->assertNotNull($result);
        $expected = ['POBoxFlag' => 'Y', 'GiftFlag' => 'Y'];
        $this->assertEquals($expected, $result);
        $this->gxg->setPOBoxFlag(GXG::POBOXFLAG_NO);
        $this->gxg->setGiftFlag(GXG::GIFTFLAG_NO);
        $result = $this->gxg->toArray();
        $this->assertNotNull($result);
        $expected = ['POBoxFlag' => 'N', 'GiftFlag' => 'N'];
        $this->assertEquals($expected, $result);
    }

    public function testFailure()
    {
        $this->gxg = new GXG();
        try {
            $result = $this->gxg->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Required value not found for key: POBoxFlag.', $e->getMessage());
        }
        $this->gxg->setPOBoxFlag(GXG::POBOXFLAG_YES);
        $this->gxg->setGiftFlag(GXG::GIFTFLAG_YES);
        $result = $this->gxg->toArray();
        $this->assertNotNull($result);
        $expected = ['POBoxFlag' => 'Y', 'GiftFlag' => 'Y'];
        $this->assertEquals($expected, $result);

        $this->gxg->setPOBoxFlag("NOT A VALID ANSWER");
        try {
            $result = $this->gxg->toArray();
            $this->assertNull($result);
        } catch (Exception $e) {
            $this->assertEquals('Invalid value "NOT A VALID ANSWER" for key: POBoxFlag. Did you mean "N"?', $e->getMessage());
        }
    }

    public function testConstants()
    {
        $this->assertEquals('Y', GXG::POBOXFLAG_YES);
        $this->assertEquals('N', GXG::POBOXFLAG_NO);
        $this->assertEquals('Y', GXG::GIFTFLAG_YES);
        $this->assertEquals('N', GXG::GIFTFLAG_NO);
    }
}
