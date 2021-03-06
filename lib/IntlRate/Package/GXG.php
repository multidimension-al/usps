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

namespace Multidimensional\USPS\IntlRate\Package;

use Exception;
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;

class GXG
{
    const POBOXFLAG_YES = 'Y';
    const POBOXFLAG_NO = 'N';
    const GIFTFLAG_YES = 'Y';
    const GIFTFLAG_NO = 'N';
    const FIELDS = [
        'POBoxFlag' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                self::POBOXFLAG_YES,
                self::POBOXFLAG_NO
            ]
        ],
        'GiftFlag' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                self::GIFTFLAG_YES,
                self::GIFTFLAG_NO
            ]
        ]
    ];
    protected $gxg = [];

    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                $this->setField($key, $value);
            }
        }

        $this->gxg += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), null));

        return;
    }

    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($value, self::FIELDS[$key]);
            $this->gxg[$key] = $value;
        }

        return;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function toArray()
    {
        try {
            if (is_array($this->gxg) && count($this->gxg)) {
                Validation::validate($this->gxg, self::FIELDS);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $this->gxg;
    }

    /**
     * @param $value
     */
    public function setGiftFlag($value)
    {
        $this->setField('GiftFlag', $value);
    }

    /**
     * @param $value
     */
    public function setPOBoxFlag($value)
    {
        $this->setField('POBoxFlag', $value);
    }
}
