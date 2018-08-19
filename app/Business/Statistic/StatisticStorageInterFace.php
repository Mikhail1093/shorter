<?php
declare(strict_types=1);

namespace App\Business\Statistic;


interface StatisticStorageInterFace
{
    /**
     * Добавить статистку перехода по ссылке в хранилице
     *
     * @return bool
     */
    public function addClick(): bool;

    /**
     * Получить статистику ссылки по ее коду
     *
     * @param string $code
     *
     * @return mixed
     */
    public function getLinkStatisticByCode(string $code);
}
