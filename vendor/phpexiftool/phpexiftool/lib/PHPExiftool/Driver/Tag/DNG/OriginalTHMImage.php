<?php

/*
 * This file is part of PHPExifTool.
 *
 * (c) 2012 Romain Neutron <imprec@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPExiftool\Driver\Tag\DNG;

use JMS\Serializer\Annotation\ExclusionPolicy;
use PHPExiftool\Driver\AbstractTag;

/**
 * @ExclusionPolicy("all")
 */
class OriginalTHMImage extends AbstractTag
{

    protected $Id = 4;

    protected $Name = 'OriginalTHMImage';

    protected $FullName = 'DNG::OriginalRaw';

    protected $GroupName = 'DNG';

    protected $g0 = 'DNG';

    protected $g1 = 'DNG';

    protected $g2 = 'Image';

    protected $Type = '?';

    protected $Writable = false;

    protected $Description = 'Original THM Image';

    protected $flag_Binary = true;

}
