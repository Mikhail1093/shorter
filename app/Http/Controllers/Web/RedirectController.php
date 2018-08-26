<?php

namespace App\Http\Controllers\Web;

use App\Business\Statistic\StatisticStorageInterFace;
use App\Models\LinkData;
use App\Models\RedirectStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedirectController extends Controller
{
    /**
     * @var StatisticStorageInterFace
     */
    protected $statisticStorage;

    /**
     * RedirectController constructor.
     *
     * @param StatisticStorageInterFace $statisticStorage
     */
    public function __construct(StatisticStorageInterFace $statisticStorage)
    {
        $this->statisticStorage = $statisticStorage;
    }

    public function index($short_link)
    {
        $link = LinkData::where('short_url', '=', $short_link)->firstOrFail();
        //dump($link->toArray()['initial_url']);

        $this->statisticStorage->setLinkDataModel($link); //todo стремно
        $this->statisticStorage->addClick();


        //todo тестовые данные убрать
        $browserInfo = \Browser::detect();
        $redirectStatistic = new RedirectStatistic();

        $redirectStatistic->link_data_id = $link->id;
        $redirectStatistic->ip = '37.139.100.232';
        $redirectStatistic->browser_version = \Browser::browserFamily();
        $redirectStatistic->refer_link = 'vk.com';
        $redirectStatistic->country= 'Russia';

        $redirectStatistic->save();

        info('redirect', ['data' => $link->toArray()]);
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Location: ' . $link->toArray()['initial_url']);
    }
}
