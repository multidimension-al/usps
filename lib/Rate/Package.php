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

namespace Multidimensional\USPS\Rate;

use Exception;
use Multidimensional\ArraySanitization\Sanitization;
use Multidimensional\ArrayValidation\Validation;
use Multidimensional\USPS\Rate\Package\Content;
use Multidimensional\USPS\Rate\Package\SpecialServices;

class Package
{
    const CONTAINER_VARIABLE = 'VARIABLE';
    const CONTAINER_FLAT_RATE_ENVELOPE = 'FLAT RATE ENVELOPE';
    const CONTAINER_PADDED_FLAT_RATE_ENVELOPE = 'PADDED FLAT RATE ENVELOPE';
    const CONTAINER_LEGAL_FLAT_RATE_ENVELOPE = 'LEGAL FLAT RATE ENVELOPE';
    const CONTAINER_SM_FLAT_RATE_ENVELOPE = 'SM FLAT RATE ENVELOPE';
    const CONTAINER_WINDOW_FLAT_RATE_ENVELOPE = 'WINDOW FLAT RATE ENVELOPE';
    const CONTAINER_GIFT_CARD_FLAT_RATE_ENVELOPE = 'GIFT CARD FLAT RATE ENVELOPE';
    const CONTAINER_FLAT_RATE_BOX = 'FLAT RATE BOX';
    const CONTAINER_SM_FLAT_RATE_BOX = 'SM FLAT RATE BOX';
    const CONTAINER_MD_FLAT_RATE_BOX = 'MD FLAT RATE BOX';
    const CONTAINER_LG_FLAT_RATE_BOX = 'LG FLAT RATE BOX';
    const CONTAINER_REGIONALRATEBOXA = 'REGIONALRATEBOXA';
    const CONTAINER_REGIONALRATEBOXB = 'REGIONALRATEBOXB';
    const CONTAINER_RECTANGULAR = 'RECTANGULAR';
    const CONTAINER_NONRECTANGULAR = 'NONRECTANGULAR';
    const FIRST_CLASS_MAIL_TYPE_LETTER = 'LETTER';
    const FIRST_CLASS_MAIL_TYPE_FLAT = 'FLAT';
    const FIRST_CLASS_MAIL_TYPE_PARCEL = 'PARCEL';
    const FIRST_CLASS_MAIL_TYPE_POSTCARD = 'POSTCARD';
    const FIRST_CLASS_MAIL_TYPE_PACKAGE = 'PACKAGE';
    const FIRST_CLASS_MAIL_TYPE_PACKAGE_SERVICE = 'PACKAGE SERVICE';
    const SERVICE_FIRST_CLASS = 'First Class';
    const SERVICE_FIRST_CLASS_COMMERCIAL = 'First Class Commercial';
    const SERVICE_FIRST_CLASS_HFP_COMMERCIAL = 'First Class HFP Commercial';
    const SERVICE_PRIORITY = 'Priority';
    const SERVICE_PRIORITY_COMMERCIAL = 'Priority Commercial';
    const SERVICE_PRIORITY_CPP = 'Priority Cpp';
    const SERVICE_PRIORITY_HFP_COMMERCIAL = 'Priority HFP Commercial';
    const SERVICE_PRIORITY_HFP_CPP = 'Priority HFP CPP';
    const SERVICE_PRIORITY_EXPRESS = 'Priority Mail Express';
    const SERVICE_PRIORITY_EXPRESS_COMMERCIAL = 'Priority Mail Express Commercial';
    const SERVICE_PRIORITY_EXPRESS_CPP = 'Priority Mail Express CPP';
    const SERVICE_PRIORITY_EXPRESS_SH = 'Priority Mail Express SH';
    const SERVICE_PRIORITY_EXPRESS_SH_COMMERCIAL = 'Priority Mail Express SH COMMERCIAL';
    const SERVICE_PRIORITY_EXPRESS_HFP = 'Priority Mail Express HFP';
    const SERVICE_PRIORITY_EXPRESS_HFP_COMMERCIAL = 'Priority Mail Express HFP COMMERCIAL';
    const SERVICE_PRIORITY_EXPRESS_HFP_CPP = 'Priority Mail Express HFP CPP';
    const SERVICE_GROUND = 'Retail Ground';
    const SERVICE_MEDIA = 'Media';
    const SERVICE_LIBRARY = 'Library';
    const SERVICE_ALL = 'All';
    const SERVICE_ONLINE = 'Online';
    const SERVICE_PLUS = 'Plus';
    const SIZE_LARGE = 'LARGE';
    const SIZE_REGULAR = 'REGULAR';
    const FIELDS = [
        '@ID' => [
            'type' => 'string'
        ],
        'Service' => [
            'type' => 'string',
            'required' => true
        ],
        'FirstClassMailType' => [
            'type' => 'string',
            'required' => [
                [
                    'Service' => self::SERVICE_FIRST_CLASS
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_COMMERCIAL
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_HFP_COMMERCIAL
                ]
            ]
        ],
        'ZipOrigination' => [
            'type' => 'string',
            'required' => true,
            'pattern' => '\d{5}'
        ],
        'ZipDestination' => [
            'type' => 'string',
            'required' => true,
            'pattern' => '\d{5}'
        ],
        'Pounds' => [
            'type' => 'decimal',
            'required' => true,
        ],
        'Ounces' => [
            'type' => 'decimal',
            'required' => true,
        ],
        'Container' => [
            'type' => 'string',
            'required' => true,
            'default' => self::CONTAINER_VARIABLE
        ],
        'Size' => [
            'type' => 'string',
            'required' => true,
            'values' => [
                self::SIZE_REGULAR,
                self::SIZE_LARGE
            ]
        ],
        'Width' => [
            'type' => 'decimal',
            'required' => [
                'Size' => self::SIZE_LARGE
            ]
        ],
        'Length' => [
            'type' => 'decimal',
            'required' => [
                'Size' => self::SIZE_LARGE
            ]
        ],
        'Height' => [
            'type' => 'decimal',
            'required' => [
                'Size' => self::SIZE_LARGE
            ]
        ],
        'Girth' => [
            'type' => 'decimal',
            'required' => [
                [
                    'Size' => self::SIZE_LARGE,
                    'Container' => self::CONTAINER_VARIABLE
                ],
                [
                    'Size' => self::SIZE_LARGE,
                    'Container' => self::CONTAINER_NONRECTANGULAR
                ]
            ]
        ],
        'Value' => [
            'type' => 'decimal'
        ],
        'AmountToCollect' => [
            'type' => 'decimal'
        ],
        'SpecialServices' => [
            'type' => 'group',
            'fields' => SpecialServices::FIELDS
        ],
        'Content' => [
            'type' => 'array',
            'fields' => Content::FIELDS
        ],
        'GroundOnly' => [
            'type' => 'boolean',
            'default' => false
        ],
        'SortBy' => [
            'type' => 'boolean'
        ],
        'Machinable' => [
            'type' => 'boolean',
            'required' => [
                [
                    'Service' => self::SERVICE_FIRST_CLASS,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_LETTER
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_FLAT
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_COMMERCIAL,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_LETTER
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_COMMERCIAL,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_FLAT
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_HFP_COMMERCIAL,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_LETTER
                ],
                [
                    'Service' => self::SERVICE_FIRST_CLASS_HFP_COMMERCIAL,
                    'FirstClassMailType' => self::FIRST_CLASS_MAIL_TYPE_FLAT
                ],
                ['Service' => self::SERVICE_ALL],
                ['Service' => self::SERVICE_ONLINE],
                ['Service' => self::SERVICE_GROUND]
            ]
        ],
        'ReturnLocations' => [
            'type' => 'boolean',
            'default' => true
        ],
        'ReturnServiceInfo' => [
            'type' => 'boolean'
        ],
        'DropOffTime' => [
            'type' => 'string',
            'pattern' => '\d{2}:d{2}'
        ],
        'ShipDate' => [
            'type' => 'string',
            'pattern' => '\d{4}-d{2}-d{2}'
        ]
    ];
    protected $package = [];
    protected $content = [];
    protected $specialServices = [];

    public function __construct(array $config = [])
    {
        if (is_array($config)) {
            if (isset($config['ID'])) {
                $config['@ID'] = $config['ID'];
                unset($config['ID']);
            }
            foreach ($config as $key => $value) {
                $this->setField($key, $value);
            }
        }

        $this->package += array_combine(array_keys(self::FIELDS), array_fill(0, count(self::FIELDS), null));

        return;
    }

    /**
     * @param string $key
     * @param int|bool|string|float
     * @return void
     */
    public function setField($key, $value)
    {
        if (in_array($key, array_keys(self::FIELDS))) {
            $value = Sanitization::sanitizeField($value, self::FIELDS[$key]);
            $this->package[$key] = $value;
        }
    }

    /**
     * @param $value
     */
    public function setID($value)
    {
        $this->setField('@ID', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setService($value)
    {
        $this->setField('Service', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setFirstClassMailType($value)
    {
        $this->setField('FirstClassMailType', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setZipOrigination($value)
    {
        $this->setField('ZipOrigination', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setZipDestination($value)
    {
        $this->setField('ZipDestination', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setPounds($value)
    {
        $this->setField('Pounds', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setOunces($value)
    {
        $this->setField('Ounces', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setSize($value)
    {
        $this->setField('Size', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setContainer($value)
    {
        $this->setField('Container', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setWidth($value)
    {
        $this->setField('Width', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setLength($value)
    {
        $this->setField('Length', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setHeight($value)
    {
        $this->setField('Height', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setGirth($value)
    {
        $this->setField('Girth', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->setField('Value', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setAmountToCollect($value)
    {
        $this->setField('AmountToCollect', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setGroundOnly($value)
    {
        $this->setField('GroundOnly', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setSortBy($value)
    {
        $this->setField('SortBy', $value);

        return;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setMachinable($value)
    {
        $this->setField('Machinable', $value);

        return;
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function toArray()
    {
        $array = $this->package;

        if (is_array($this->content) && count($this->content)) {
            $array['Content'] = $this->content;
        }


        if (is_array($this->specialServices) && count($this->specialServices)) {
            $array['SpecialServices'] = $this->specialServices;
        }

        $array = array_replace(self::FIELDS, $array);

        foreach (self::FIELDS as $key => $value) {
            if (is_null($array[$key]) || $array[$key] === null) {
                unset($array[$key]);
            }
        }

        try {
            if (is_array($array) && count($array)) {
                Validation::validate($array, self::FIELDS);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $array;
    }

    /**
     * @param Package\Content $content
     * @return void
     */
    public function addContent(Package\Content $content)
    {
        $this->content = $content->toArray();
    }

    /**
     * @param SpecialServices $specialServices
     * @return void
     * @internal param Package\ExtraServices $extraServices
     */
    public function addSpecialServices(Package\SpecialServices $specialServices)
    {
        $this->specialServices[] = $specialServices->toArray();
    }
}
