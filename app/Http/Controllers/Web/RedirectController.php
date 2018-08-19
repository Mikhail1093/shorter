<?php

namespace App\Http\Controllers\Web;

use App\Business\Statistic\StatisticStorageInterFace;
use App\Models\LinkData;
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

        info('redirect', ['data' => $link->toArray()]);
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Location: ' . $link->toArray()['initial_url']);

        /*//dd($_SERVER);
        info('test', [__FILE__]);
        //redirect()->to('/');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Location: https://twitter.com/M_Grishin_');
        //header('Location: https://www.vagrantup.com/docs/cli/reload.html');*/
    }
}
