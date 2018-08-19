<?php
/**
 * Created by PhpStorm.
 * User: grishi
 * Date: 19.08.18
 * Time: 22:15
 */

namespace App\Business\Statistic;


class Fabric
{
    /**
     * @param string $storageSettingsCode
     *
     * @return \App\Business\Statistic\ClickHouseStorage|\App\Business\Statistic\MySqlStorage
     */
    public static function getStorageFromSettingsValue(string $storageSettingsCode): StatisticStorageInterFace
    {

        if ('mysql' === $storageSettingsCode) {
            return new MySqlStorage();
        }

        if ('click_house' === $storageSettingsCode) {
            return new ClickHouseStorage();
        }
    }
}