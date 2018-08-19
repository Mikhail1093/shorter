<?php
declare(strict_types=1);

namespace App\Http\Controllers\Web\Ajax;

use App\Models\LinkData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShorterController extends Controller
{
    public function __invoke(Request $request)
    {
        $shortUrlCode = Str::random(6);

        $linkDataModel = new LinkData();

        $linkDataModel->user_id = Auth::id();
        $linkDataModel->initial_url = $request->link;
        $linkDataModel->short_url = $shortUrlCode;
        $linkDataModel->redirect_count = 0;

        $linkDataModel->save();

        return \json_encode(['msg' => $request->link, 'link' => 'shorter.loc/' . $shortUrlCode]);
    }
}
