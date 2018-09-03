<?php
declare(strict_types=1);

namespace App\Business\Statistic;


/**
 * @method setLinkDataModel($link)
 * @method setRedirectStatisticModel(\App\Models\RedirectStatistic $param)
 */
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

    /**
     * Добавить статистику в хранилище
     *
     * @param \App\Business\Statistic\Metrics\DTO\Metric $metric
     *
     * @return mixed добавить данные о стастистике
     */
    public function addStatistic(Metrics\DTO\Metric $metric);
}
