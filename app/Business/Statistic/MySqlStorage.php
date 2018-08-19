<?php
declare(strict_types=1);

namespace App\Business\Statistic;


class MySqlStorage implements StatisticStorageInterFace
{

    /**
     * Добавить статистку перехода по ссылке в хранилице
     *
     * @return bool
     */
    public function addClick(): bool
    {
        dump(__METHOD__);
        // TODO: Implement addClick() method.
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