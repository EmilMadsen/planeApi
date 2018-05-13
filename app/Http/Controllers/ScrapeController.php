<?php
/**
 * Created by IntelliJ IDEA.
 * User: Emilo
 * Date: 06-05-2018
 * Time: 12:12
 */

namespace App\Http\Controllers;

use App\Http\UseCases\CrawlPage;
use Illuminate\Support\Facades\Input;


class ScrapeController extends Controller
{

    public function retrieve($type)
    {

        $url = 'https://www.cph.dk/flyinformation/';

        if ($type == 'departure') $url .= 'afgange';
        else $url .= 'ankomster';

        $url .= '?q=' . Input::get("query");
        $url .= '&date=' . Input::get("date");
        $url .= '&time=' . Input::get("time");

        return (new CrawlPage($url))->handle();
    }
}