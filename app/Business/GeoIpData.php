<?php
declare(strict_types=1);

namespace App\Business;


use App\Models\IpGeoBase;

class GeoIpData
{
    /**
     * Получить гео информацию об ip с которого был переход по ссылке
     *
     * Возвращает информацию либо с локального хранилища, либо с внешнего сервиса
     *
     * @param string $ip - ip с которого был переход по ссылке
     *
     * @return array
     */
    public static function getGeoData(string $ip): array
    {
        //todo валидация, что ip не пустой и что он с trim.
        $result = self::getGeoDataFromLocalStorage($ip);

        if (null === $result) {
            //todo фиксировать то, сколько раз мы сохранем ip, чтобы потом можно было построить график. Ожидание нисходящего графика
            $result = self::getGeoDataFromExternalServise($ip);

            $ipData = [
                'city'           => $result['city'],
                'state'          => $result['state'],
                'country'        => $result['country'],
                'country_code'   => $result['country_code'],
                'continent'      => $result['continent'],
                'continent_code' => $result['continent_code']
            ];

            //todo выделить в отдельный метод
            IpGeoBase::create( //todo проверить, что добавление прошло корреткно.
                [
                    'ip'             => trim($ip),
                    'city'           => $result['city'],
                    'state'          => $result['state'],
                    'country'        => $result['country'],
                    'country_code'   => $result['country_code'],
                    'continent'      => $result['continent'],
                    'continent_code' => $result['continent_code']

                ]
            );
        } else {
            $result = $result->toArray();

            $ipData = [
                'city'           => $result['city'],
                'state'          => $result['state'],
                'country'        => $result['country'],
                'country_code'   => $result['country_code'],
                'continent'      => $result['continent'],
                'continent_code' => $result['continent_code']
            ];
        }

        return $ipData;
    }

    protected static function getGeoDataFromLocalStorage(string $ip)
    {
        return IpGeoBase::where('ip', '=', $ip)->first();
    }

    public static function getGeoDataFromExternalServise(string $ip)
    {
        return self::geoPluginService($ip);
    }


    protected static function geoPluginService($ip, $purpose = 'location', $deepDetect = true): array
    {
        //todo переписать это дерьмо, взятое со стековеФЛОУ
        //todo через guzzle. ТаймАут 2 секунды
        $output = null;
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if ($deepDetect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            }
        }
        $purpose = str_replace(['name', "\n", "\t", ' ', '-', '_'], null, strtolower(trim($purpose)));
        $support = ['country', 'countrycode', 'state', 'region', 'city', 'location', 'address'];
        $continents = [
            'AF' => 'Africa',
            'AN' => 'Antarctica',
            'AS' => 'Asia',
            'EU' => 'Europe',
            'OC' => 'Australia (Oceania)',
            'NA' => 'North America',
            'SA' => 'South America'
        ];
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case 'location':
                        $output = [
                            'city'           => @$ipdat->geoplugin_city,
                            'state'          => @$ipdat->geoplugin_regionName,
                            'country'        => @$ipdat->geoplugin_countryName,
                            'country_code'   => @$ipdat->geoplugin_countryCode,
                            'continent'      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            'continent_code' => @$ipdat->geoplugin_continentCode
                        ];
                        break;
                    case 'address':
                        $address = [$ipdat->geoplugin_countryName];
                        if (@strlen($ipdat->geoplugin_regionName) >= 1) {
                            $address[] = $ipdat->geoplugin_regionName;
                        }
                        if (@strlen($ipdat->geoplugin_city) >= 1) {
                            $address[] = $ipdat->geoplugin_city;
                        }
                        $output = implode(', ', array_reverse($address));
                        break;
                    case 'city':
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case 'state':
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case 'region':
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case 'country':
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case 'countrycode':
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }

        return $output;
    }
}
