<?php
declare(strict_types=1);

namespace App\Business\Statistic;


use App\Business\Statistic\Metrics\CollectionBuilder;
use App\Models\LinkData;
use App\Models\RedirectStatistic;
use Illuminate\Support\Collection;

class MySqlStorage implements StatisticStorageInterFace
{
    /**
     * @var LinkData
     */
    protected $linkDataModel;

    /**
     * Модель, где зранится статистика
     *
     * @var RedirectStatistic
     */
    protected $redirectStatisticModel;

    /**
     * @param RedirectStatistic $redirectStatisticModel
     *
     * @return MySqlStorage
     */
    public function setRedirectStatisticModel(RedirectStatistic $redirectStatisticModel): MySqlStorage
    {
        $this->redirectStatisticModel = $redirectStatisticModel;
        return $this;
    }

    /**
     * MySqlStorage constructor.
     *
     * @param RedirectStatistic $redirectStatistic
     */
    /*public function __construct(RedirectStatistic $redirectStatistic) //todo, $linkDataModel вторым параметром
    {

    }*/

    /**
     * Добавить счетчик перехода по ссылке в хранилице
     *
     * @return bool
     */
    public function addClick(): bool
    {
        ++$this->linkDataModel->redirect_count;

        $this->linkDataModel->save();

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

    /**
     * Добавить статистику в mysql базу через модель
     *
     * @param \App\Business\Statistic\Metrics\DTO\Metric $metric
     *
     * @return mixed добавить данные о стастистике
     */
    public function addStatistic(Metrics\DTO\Metric $metric)
    {
        //todo логи
        $this->redirectStatisticModel->link_data_id = $metric->linkDataId;
        $this->redirectStatisticModel->ip = $metric->ip;
        $this->redirectStatisticModel->browser_version = $metric->browserVersion;
        $this->redirectStatisticModel->refer_link = $metric->referLink;
        $this->redirectStatisticModel->country = $metric->country;

        return $this->redirectStatisticModel->save();
    }
}
