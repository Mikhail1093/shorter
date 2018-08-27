<?php
declare(strict_types=1);

namespace App\Business\Statistic;


use App\Business\Statistic\Metrics\CollectionBuilder;
use App\Models\LinkData;
use Illuminate\Support\Collection;

class MySqlStorage implements StatisticStorageInterFace
{
    /**
     * @var LinkData
     */
    protected $linkDataModel;

    /**
     * Добавить статистку перехода по ссылке в хранилице
     *
     * @return bool
     */
    public function addClick(): bool
    {
        ++$this->linkDataModel->redirect_count;

        $this->linkDataModel->save();
        // TODO: Implement addClick() method.
        return true;
    }

    /**
     * Получить статистику ссылки по ее коду
     *
     * @param string $code
     *
     * @return \Illuminate\Support\Collection
     */
    public function getLinkStatisticByCode(string $code): Collection
    {
        $linkData = LinkData::where('short_url', '=', $code)->firstOrFail()->load('redirectStatistic');

        return CollectionBuilder::buildMetricCollection($linkData->redirectStatistic);
    }

    /**
     * @param mixed $linkDataModel
     *
     * @return MySqlStorage
     */
    public function setLinkDataModel($linkDataModel): MySqlStorage
    {
        $this->linkDataModel = $linkDataModel;
        return $this;
    }
}
