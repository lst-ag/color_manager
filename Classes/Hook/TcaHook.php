<?php
declare(strict_types = 1);

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

namespace LST\ColorManager\Hook;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
    public function processDatamap_postProcessFieldArray($status, $table, $id, array &$fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$dataHandler)
    {
        // If selected color on pages record changed, change color value in db
        if ($table === 'pages' && array_key_exists('tx_colormanager_color_uid', $fieldArray)) {
            if (!empty($fieldArray['tx_colormanager_color_uid'])) {
                $queryBuilder = $this->getDatabaseConnectionPool()->getQueryBuilderForTable('tx_colormanager_domain_model_color');
                $statement = $queryBuilder
                    ->select('color')
                    ->from('tx_colormanager_domain_model_color')
                    ->where(
                        $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int) $fieldArray['tx_colormanager_color_uid']))
                    )->execute();
                $record = $statement->fetch();

                $fieldArray['tx_colormanager_color'] = $record['color'];
            } else {
                $fieldArray['tx_colormanager_color'] = '';
            }
        }

        // If color on color record changed, update all pages referencing that color
        if ($table === 'tx_colormanager_domain_model_color' && array_key_exists('color', $fieldArray)) {
            $queryBuilder = $this->getDatabaseConnectionPool()->getQueryBuilderForTable('pages');
            $queryBuilder
                ->update('pages')
                ->where(
                    $queryBuilder->expr()->eq('tx_colormanager_color_uid', $queryBuilder->createNamedParameter($id))
                )
                ->set('tx_colormanager_color', $fieldArray['color'])
                ->execute();
        }
    }

    /**
     * Hook executed when record is deleted
     *
     * @param string $table
     * @param int $id
     * @param array $recordToDelete
     * @param bool $recordWasDeleted
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     */
    public function processCmdmap_deleteAction($table, $id, $record, &$recordWasDeleted, \TYPO3\CMS\Core\DataHandling\DataHandler &$dataHandler)
    {
        if ($table === 'tx_colormanager_domain_model_color') {
            $queryBuilder = $this->getDatabaseConnectionPool()->getQueryBuilderForTable('pages');
            $queryBuilder
                ->update('pages')
                ->where(
                    $queryBuilder->expr()->eq('tx_colormanager_color_uid', $queryBuilder->createNamedParameter($id))
                )
                ->set('tx_colormanager_color', '')
                ->set('tx_colormanager_color_uid', '')
                ->execute();
        }
    }

    /**
     * Get TYPO3 database connection pool
     *
     * @return ConnectionPool
     */
    protected function getDatabaseConnectionPool()
    {
        return GeneralUtility::makeInstance(ConnectionPool::class);
    }
}
