<?php
declare(strict_types=1);

namespace App\Business\Statistic\Metrics;

use App\Business\Statistic\Metrics\DTO\Metric;
use Illuminate\Support\Collection;

/**
 * Class CollectionBuilder
 *
 * @package App\Business\Statistic\Metrics
 */
class CollectionBuilder
{
    /**
     * Сформировать объект метрики
     *
     * @param \Illuminate\Support\Collection $redirectStatistic
     *
     * @return \Illuminate\Support\Collection
     */
    public static function buildMetricCollection(Collection $redirectStatistic): Collection
    {
        $collection = new Collection();

        $redirectStatistic->each(function ($item, $key) use ($collection) {
            $metric = new Metric(
                (int)$item->id,
                $item->created_at,
                $item->updated_at,
                (int)$item->link_data_id,
                (string)$item->ip,
                (string)$item->browser_version,
                (string)$item->refer_link,
                (string)$item->country,
                $item->created_at->format(Metrics::DEFAULT_DATE_TYPE)
            );

            $collection->push($metric);
        });

        return $collection;
    }
}