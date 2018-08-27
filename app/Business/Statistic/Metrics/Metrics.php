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
     * @param \Illuminate\Support\Collection $statisticData
     */
    public function __construct(Collection $statisticData)
    {
        $this->statisticStorage = $statisticData;
    }

    public function getMetricsDataFromStorage()
    {
        return $this->statisticStorage->getLinkStatisticByCode($this->linkCode);
    }

    /**
     * Получить сгруппированную статистику переходов в разрезе времени
     *
     * @return string
     */
    public function getRedirectsGroupByDateInterval(): string
    {
        //todo валидность даты
        $redirectsByData = $this->statisticStorage->groupBy('stringDate');

        $redirectItems = [];

        foreach ($redirectsByData->toArray() as $key => $redirectsByData) {
            $redirectItem['date'] = $key;
            $redirectItem['value'] = \count($redirectsByData);
            $redirectItems[] = $redirectItem;
        }

        //todo id isJson
        return \json_encode($redirectItems);
    }

    /**
     * Получить статистику, сгруппированную по браузерам
     */
    public function getStatisticByBrowses()
    {
        dump($this->statisticStorage->count());
        $browser = $this->statisticStorage->groupBy('browserVersion');

        $browserC = $this->statisticStorage->count();
        dump($browser);
        $ar = [];


        foreach ($browser->toArray() as $key => $value) {
            $sumAr['litres'] = \round(\count($value) /  $browserC * 100);
            $sumAr['country'] = $key;

            $ar[] = $sumAr;
        }

        return \json_encode($ar);
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
