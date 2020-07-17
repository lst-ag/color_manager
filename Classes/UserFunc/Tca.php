<?php

namespace LST\ColorManager\UserFunc;

use TYPO3\CMS\Backend\Utility\BackendUtility;

/***
 *
 * This file is part of the "Color Manager" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2016 Christian Fries <christian.fries@lst.team>
 *
 ***/

class Tca
{
    public function colorTitle(&$parameters, $parentObject)
    {
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        $defaultTitle = $record['name'];
        $newTitle = $defaultTitle . ' (' . strip_tags($record['color']) . ')';
        $parameters['title'] = $newTitle;
    }
}
