<?php

namespace LST\ColorManager\Hook;

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

class TcaHook
{
    /**
     * Hook executed when creating or updating record
     *
     * @param $status
     * @param $table
     * @param $id
     * @param array $fieldArray
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, array &$fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj)
    {
        // If selected color on pages record changed, change color value in db
        if ($table === 'pages' && array_key_exists('tx_colormanager_color_uid', $fieldArray)) {
            if (!empty($fieldArray['tx_colormanager_color_uid'])) {
                $record = $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
                    'color',
                    'tx_colormanager_domain_model_color',
                    'uid = ' . (int)$fieldArray['tx_colormanager_color_uid']
               );

                $fieldArray['tx_colormanager_color'] = $record['color'];
            } else {
                $fieldArray['tx_colormanager_color'] = '';
            }
        }

        // If color on color record changed, update all pages referencing that color
        if ($table === 'tx_colormanager_domain_model_color' && array_key_exists('color', $fieldArray)) {
            $this->getDatabaseConnection()->exec_UPDATEquery(
                'pages',
                'tx_colormanager_color_uid = ' . $id,
                [
                    'tx_colormanager_color' => $fieldArray['color']
                ]
            );
        }
    }

    /**
     * Hook executed when record is deleted
     *
     * @param $table
     * @param $id
     * @param $recordToDelete
     * @param null $recordWasDeleted
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     */
    public function processCmdmap_deleteAction($table, $id, $recordToDelete, $recordWasDeleted=null, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj)
    {
        if ($table === 'tx_colormanager_domain_model_color') {
            $this->getDatabaseConnection()->exec_UPDATEquery(
                'pages',
                'tx_colormanager_color_uid = ' . $id,
                [
                    'tx_colormanager_color_uid' => '',
                    'tx_colormanager_color' => ''
                ]
            );
        }
    }

    /**
     * Get TYPO3 database connection
     *
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
