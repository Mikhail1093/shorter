<?php
declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Business\GeoIpData;
use App\Business\Statistic\Metrics\CollectionBuilder;
use App\Business\Statistic\Metrics\DTO\Metric;
use App\Business\Statistic\StatisticStorageInterFace;
use App\Models\LinkData;
use App\Models\RedirectStatistic;
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

    /**
     * @param $short_link
     */
    public function index($short_link)
    {
        //todo логи
        /*$browserInfo = \Browser::detect(); //todo сбор данных по OS
        dd($browserInfo);*/

        //todo validate ip
        //todo тестовые данные убрать
        //=============Tests================================================
        //request()->server('REMOTE_ADDR'); //todo на продакшене переключить
        $testIp = '37.139.100.232'; //sevastopol //todo сделать рандомно.
        //$testIp = '104.236.70.228'; //United States (US), Brooklyn
        //$testIp = '82.196.1.179'; // Netherlands (NL), N/A
        $testReferLink = 'vk.com';
        //==================================================================

        //todo только активные ссылки!!!!!!!!!!!!!!!!!!!!!!!
        $link = LinkData::where('short_url', '=', $short_link)->firstOrFail(); //todo если ссылку не нашли, то сообщение

        //todo переделать на очереди сбор статистики
        $ipGeoData = GeoIpData::getGeoData($testIp); //todo потом от $_SERVER['REMOTE_ADDR']

        $metric = new Metric(
            (int)$link->id,
            (string)$testIp,
            \Browser::browserFamily(),
            (string)$testReferLink, //todo может быть null
            (string)$ipGeoData['country_code']
        );

        $this->statisticStorage->setLinkDataModel($link); //todo стремно
        $this->statisticStorage->addClick();
        $this->statisticStorage->setRedirectStatisticModel(new RedirectStatistic())->addStatistic($metric);

        //info('redirect', ['data' => $link->toArray()]);
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Location: ' . $link->toArray()['initial_url']);
    }
}
