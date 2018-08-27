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
    public static function ip_info($ip = null, $purpose = "location", $deep_detect = true)
    {
        $output = null;
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            }
        }
        $purpose = str_replace(["name", "\n", "\t", " ", "-", "_"], null, strtolower(trim($purpose)));
        $support = ["country", "countrycode", "state", "region", "city", "location", "address"];
        $continents = [
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        ];
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = [
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        ];
                        break;
                    case "address":
                        $address = [$ipdat->geoplugin_countryName];
                        if (@strlen($ipdat->geoplugin_regionName) >= 1) {
                            $address[] = $ipdat->geoplugin_regionName;
                        }
                        if (@strlen($ipdat->geoplugin_city) >= 1) {
                            $address[] = $ipdat->geoplugin_city;
                        }
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    //todo переписать это дерьмо, взятое со стековеФЛОУ

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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    public function show($code) //todo политика, что это пользователя ссылка
    {

        $metric = new Metrics(resolve(StatisticStorageInterFace::class)->getLinkStatisticByCode($code));
        //dump($metric);
        //$metric->getReridectsGroupByDateInterval();
        $dateValues = $metric->getRedirectsGroupByDateInterval();
        //$metric->getStatisticByBrowses();

        /*dump($link->redirectStatistic->groupBy('string_date'));
        dump($link->redirectStatistic->groupBy('browser_version'));
        dump($link->redirectStatistic->groupBy('country'));
        dump($link->redirectStatistic->groupBy('refer_link'));*/

        return view(
            'main.statistic',
            [
                'test'        => ['name' => 'test', 'val' => 'tst_val'],
                'date_values' => $dateValues,
                'browsers' => $metric->getStatisticByBrowses()
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
