<?php
declare(strict_types=1);

namespace App\Http\Controllers\Web\Ajax;

use App\Models\LinkData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ShorterController extends Controller
{
    /**
     * Сократить ссылку и записать информацию в БД
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function __invoke(Request $request)
    {
        //todo валидация строки бэк  энд
        $this->validate(
            $request,
            $this->buildValidateRules($request) //todo в request валидатор
        );


        //todo валидация строки фронт  энд
        $shortUrlCode = Str::random(6);

        $linkDataModel = new LinkData();

        if (Auth::check()) {
            $linkDataModel->user_id = Auth::id();
        }

        //todo собрать id, geo и все данные, если пользователь неавторизован
        //todo валидация неприемлевого контента через яндекс
        $linkDataModel->initial_url = $request->link;
        $linkDataModel->short_url = $shortUrlCode;
        $linkDataModel->redirect_count = 0;

        //todo если запись успешно добавлена — проверить
        //todo если это с тестов dusk, то как-то помечать это
        $linkDataModel->save();


        return \json_encode(['msg' => $request->link, 'link' => URL::to('/') . '/' . $shortUrlCode]);
    }

    /**
     * Сформировать массив для валидаци запроса на сокращение ссылки
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    private function buildValidateRules(Request $request): array
    {
        $result = [];

        /*
         * если пользователь неавторизированный и это не тестовый набор данных, то добавляем капчу
         */
        //todo strpos() expects parameter 1 to be string, null given"
        if (!Auth::check() && false === strpos($request->get('link'), 'https://test-site.com?test_dusk=test_')) {
            //todo что деалать с мобильным api ? отдавать ссылку на сгенеренную картинку?
            $result['captcha'] = 'required|captcha';
        }

        return $result;
    }
}
