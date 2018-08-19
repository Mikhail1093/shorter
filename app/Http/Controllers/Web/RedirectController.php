<?php

namespace App\Http\Controllers\Web;

use App\Models\LinkData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedirectController extends Controller
{
    public function index($short_link)
    {

        //dump($short_link);

        $link = LinkData::where('short_url', '=', $short_link)->firstOrFail();
        //dump($link->toArray()['initial_url']);

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
