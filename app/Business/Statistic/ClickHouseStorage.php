<?php
/**
 * Created by PhpStorm.
 * User: grishi
 * Date: 19.08.18
 * Time: 21:10
 */

namespace App\Business\Statistic;


class ClickHouseStorage implements StatisticStorageInterFace
{

    /**
     * Добавить статистку перехода по ссылке в хранилице
     *
     * @return bool
     */
    public function addClick(): bool
    {
        // TODO: Implement addClick() method.
        dump(__METHOD__);

        return true;
    }

    /**
     * Получить статистику ссылки по ее коду
     *
     * @param string $code
     *
     * @return mixed
     */
    public function getLinkStatisticByCode(string $code)
    {
        // TODO: Implement getLinkStatisticByCode() method.
    }
}