<?php
declare(strict_types=1);

namespace App\Business\Statistic\Metrics;


use App\Business\Statistic\StatisticStorageInterFace;
use App\Models\LinkData;
use Illuminate\Support\Collection;

class Metrics
{
    /**
     * Значание по умолчанию, по которому группировать статистику по переходам в разрезе даты
     */
    public const DEFAULT_DATE_TYPE = 'Y-m-d';

    /**
     * Объект для получения статистики из хранилищ*а
     *
     * @var StatisticStorageInterFace
     */
    protected $statisticStorage;

    /**
     * Уникальный код сокращенной ссылки
     *
     * @var string
     */
    protected $linkCode;

    /**
     * Временной промежуток по которому группировать статистику
     *
     * @var string
     */
    protected $dateTypeInterval;

    /**
     * Metrics constructor.
     *
     * @param \App\Business\Statistic\StatisticStorageInterFace $statisticStorage
     * @param string                                            $linkCode - код сокращенной ссылки
     * @param string                                            $dateTypeInterval - группировка по которой получачать
     */
    public function __construct(
        StatisticStorageInterFace $statisticStorage,
        string $linkCode,
        string $dateTypeInterval = self::DEFAULT_DATE_TYPE
    ) {
        $this->statisticStorage = $statisticStorage;
        $this->linkCode = $linkCode;
        $this->dateTypeInterval = $dateTypeInterval;
    }

    public function getMetricsDataFromStorage()
    {
        return $this->statisticStorage->getLinkStatisticByCode($this->linkCode);
    }

    /**
     * Получить сгруппированную статистику переходов в разрезе времени
     *
     * @param \App\Models\LinkData $redirectDataCollection
     *
     * @return string
     */
    public function getReridectsGroupByDateInterval(
        LinkData $redirectDataCollection
    ) {

        //todo валидность даты
        //todo избавиться от зависимости к полю redirectStatistic. Пропустить через DTO объект

        //todo как передать $dateTypeInterval в transform(function ($item, $key) { ???
        $redirectDataCollection->redirectStatistic->transform(function ($item, $key) {
            $item->string_date = $item->created_at->format($this->dateTypeInterval);
            return $item;
        });

        $redirectsByData = $redirectDataCollection->redirectStatistic->groupBy('string_date');

        $redirectItems = [];

        foreach ($redirectsByData->toArray() as $key => $redirectsByData) {
            $redirectItem['date'] = $key;
            $redirectItem['value'] = \count($redirectsByData);
            $redirectItems[] = $redirectItem;
        }

        return \json_encode($redirectItems);
    }

    /**
     * Получить статистику, сгруппированную по браузерам
     */
    public function getStatisticByBrowses()
    {
        //todo
    }

    /**
     * Получить статистику, сгруппированную по странам
     *
     * Информация определяется по ip
     */
    public function getStatisticByCountries()
    {

    }

    /**
     * Получить статистику, сгруппированную по реферам
     */
    public function getStatisticByRefer()
    {

    }

}
