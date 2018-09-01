<?php

namespace App\Http\Controllers\Web;

use App\Business\GeoIpData;
use App\Business\Statistic\StatisticStorageInterFace;
use App\Http\Controllers\Web\Ajax\ShorterController;
use App\Models\IpGeoBase;
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
        //todo validate ip
        //request()->server('REMOTE_ADDR'); //todo на продакшене переключить
        $testIp = '37.139.100.232'; //sevastopol //todo сделать рандомно.
        //$testIp = '104.236.70.228'; //United States (US), Brooklyn
        //$testIp = '82.196.1.179'; // Netherlands (NL), N/A
        $testReferLink = 'vk.com';

        $ipGeoData = GeoIpData::getGeoData($testIp);

        $link = LinkData::where('short_url', '=', $short_link)->firstOrFail();

        $this->statisticStorage->setLinkDataModel($link); //todo стремно
        $this->statisticStorage->addClick();


        //todo тестовые данные убрать
        $browserInfo = \Browser::detect();
        $redirectStatistic = new RedirectStatistic();

        $redirectStatistic->link_data_id = $link->id;
        $redirectStatistic->ip = $testIp;
        $redirectStatistic->browser_version = \Browser::browserFamily();
        $redirectStatistic->refer_link = $testReferLink;
        $redirectStatistic->country= $ipGeoData['country_code'];

        $redirectStatistic->save();

        info('redirect', ['data' => $link->toArray()]);
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Location: ' . $link->toArray()['initial_url']);
    }
}
