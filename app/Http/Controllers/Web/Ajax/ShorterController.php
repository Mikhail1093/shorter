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
    public function __invoke(Request $request)
    {
        $shortUrlCode = Str::random(6);

        $linkDataModel = new LinkData();

        $linkDataModel->user_id = Auth::id(); //todo а если юзер незареган ?
        $linkDataModel->initial_url = $request->link;
        $linkDataModel->short_url = $shortUrlCode;
        $linkDataModel->redirect_count = 0;

        $linkDataModel->save();
        //todo если запись успешно добавлена — проверить

        return \json_encode(['msg' => $request->link, 'link' => URL::to('/') . '/' . $shortUrlCode]);
    }
}
