<?php
/**
 *     __  ___      ____  _     ___                           _                    __
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

namespace Multidimensional\Usps;

class Track extends USPS
{
/**
 * @var string
 */
    protected $apiClass = 'TrackV2';

/**
 * @var array
 */
    protected $trackingNumbers = [];

    const FIELDS = [
    'TrackID' => [
    'required' => true
    ],
    '@ID' => [
    'type' => 'string',
    'required' => true
    ]
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

/**
 * @param string $string
 */
    public function addTrackingNumber($string)
    {
        $this->trackingNumbers[] = $string;
    }

/**
 * @return array
 */
    public function track()
    {
        return $this->request($this->apiClass);
    }

/**
 * @return array
 */
    public function toArray()
    {
        return $this->trackingNumbers;
    }
}
