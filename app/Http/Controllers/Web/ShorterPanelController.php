<?php

namespace App\Http\Controllers\Web;

use App\Business\Statistic\Metrics\CollectionBuilder;
use App\Business\Statistic\Metrics\Metrics;
use App\Business\Statistic\StatisticStorageInterFace;
use App\Models\LinkData;
use App\Repositories\LinkDataRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class ShorterPanelController
 *
 * @package App\Http\Controllers\Web
 */
class ShorterPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        $res = (new LinkDataRepository(new LinkData()))->paginate(1); //todo переделелать под пагинатор

        return view(
            'main.index',
            [
                'links_data' => (new LinkDataRepository(new LinkData()))->get(50, ['user_id' => Auth::id()])->toArray(),
                'test'       => ['name' => 'test', 'val' => 'tst_val']
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param           $code
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    public function show($code, User $user)
    {
        $linkData = LinkData::where('short_url', '=', $code)->first(); //todo если нашли такую ссылку вообще

        //todo если эта не публичнаяя ссылка то нельзя смотреть — Обернуть в if
        if($user->cant('viewLinkStatistic', $linkData)) {
            return redirect('/');
        }

        $metric = new Metrics(resolve(StatisticStorageInterFace::class)->getLinkStatisticByCode($code));

        //$metric->getReridectsGroupByDateInterval();

        //$metric->getStatisticByBrowses();

        /*dump($link->redirectStatistic->groupBy('string_date'));
        dump($link->redirectStatistic->groupBy('browser_version'));
        dump($link->redirectStatistic->groupBy('country'));
        dump($link->redirectStatistic->groupBy('refer_link'));*/

        return view(
            'main.statistic',
            [
                'test'        => ['name' => 'test', 'val' => 'tst_val'],
                'date_values' => $metric->getRedirectsGroupByDateInterval(),
                'browsers'    => $metric->getStatisticByBrowses(),
                'countries'   => $metric->getStatisticByCountries()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
