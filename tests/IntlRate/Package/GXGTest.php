<?php
/**    __  ___      ____  _     ___                           _                    __
 *    /  |/  /_  __/ / /_(_)___/ (_)___ ___  ___  ____  _____(_)___  ____   ____ _/ /
 *   / /|_/ / / / / / __/ / __  / / __ `__ \/ _ \/ __ \/ ___/ / __ \/ __ \ / __ `/ / 
 *  / /  / / /_/ / / /_/ / /_/ / / / / / / /  __/ / / (__  ) / /_/ / / / // /_/ / /  
 * /_/  /_/\__,_/_/\__/_/\__,_/_/_/ /_/ /_/\___/_/ /_/____/_/\____/_/ /_(_)__,_/_/   
 *                                                                                  
 * CONFIDENTIAL
 *
 * © 2017 Multidimension.al - All Rights Reserved
 * 
 * NOTICE:  All information contained herein is, and remains the property of
 * Multidimension.al and its suppliers, if any.  The intellectual and
 * technical concepts contained herein are proprietary to Multidimension.al
 * and its suppliers and may be covered by U.S. and Foreign Patents, patents in
 * process, and are protected by trade secret or copyright law. Dissemination
 * of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained.
 */

namespace Multidimensional\Usps\Test\IntlRate\Package;

use Multidimensional\Usps\IntlRate\Package\GXG;
use PHPUnit\Framework\TestCase;

class GXGTest extends TestCase
{
    public $gxg;
        
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
        $result = $this->gxg->toArray();
        $this->assertNull($result);
        $this->gxg->setPOBoxFlag(GXG::POBOXFLAG_YES);
        $this->gxg->setGiftFlag(GXG::GIFTFLAG_YES);
        $result = $this->gxg->toArray();
        $this->assertNotNull($result);
        $expected = ['POBoxFlag' => 'Y', 'GiftFlag' => 'Y'];
        $this->assertEquals($expected, $result);
        $this->gxg->setPOBoxFlag("NOT A VALID ANSWER");
        $result = $this->gxg->toArray();
        $this->assertNull($result);
    }
}