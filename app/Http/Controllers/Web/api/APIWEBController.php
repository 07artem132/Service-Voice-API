<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 04.07.2017
 * Time: 18:49
 */

namespace Api\Http\Controllers;

use Auth;
use Charts;
use Api\UserToken;
use Api\ApiLog;
use Debugbar;
use Cache;
use Carbon\Carbon;

class APIWEBController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.redirect.back');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function app()
    {
        return view('api-app');
    }

    /**
     * @return $this
     */
    public function log()
    {
        $Tokens = UserToken::User(Auth::id())->get();

        for ($i = 0; $i < count($Tokens); $i++) {
            $where[] = ['token', '=', $Tokens[$i]->token, 'or'];
        }
        $logs = ApiLog::where($where)->orderBy('created_at', 'desc')->paginate(30);

        return view('api-log')->with('logs', $logs);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function stat()
    {
        $RequestStat = $this->CreateChartsRequestStat();
        $MethodTop = $this->CreateChartsMethodTop();

        return view('api-stat', ['RequestStat' => $RequestStat, 'MethodTop' => $MethodTop]);
    }

    /**
     * @return mixed
     */
    function CreateChartsRequestStat()
    {
        $Tokens = UserToken::User(Auth::id())->get();

        $RequestStat = Charts::multi('areaspline', 'highcharts')->title('Статистика запросов (Общее количество)')->colors(['#ff0000', '#000000'])->elementLabel('Запросов к API');;
        $RequestStat->labels([
            date('d-m', strtotime("-6 days")),
            date('d-m', strtotime("-5 days")),
            date('d-m', strtotime("-4 days")),
            date('d-m', strtotime("-3 days")),
            date('d-m', strtotime("-2 days")),
            date('d-m', strtotime("-1 days")),
            date('d-m', time()),
        ]);

        for ($i = 0; $i < count($Tokens); $i++) {

            if (Cache::has('RequestStat-user-ID' . Auth::id() . 'token-' . $Tokens[$i]->token)) {
                $data = Cache::get('RequestStat-user-ID' . Auth::id() . 'token-' . $Tokens[$i]->token);
            } else {
                $data = ApiLog::Token($Tokens[$i]->token)->StatWeek()->DayAvage()->get();
                Cache::add('RequestStat-user-ID' . Auth::id() . 'token-' . $Tokens[$i]->token, $data, Carbon::now()->addMinutes(config('ApiCache.APIWEBController.CacheRequestStat')));
            }

            $RequestStat->dataset($Tokens[$i]->token, $this->SortArrayForChart($data->toArray()));
        }

        return $RequestStat;
    }

    /**
     * @return mixed
     */
    function CreateChartsMethodTop()
    {
        $data = Cache::remember('MethodTop-user-ID' . Auth::id(), Carbon::now()->addMinutes(config('ApiCache.APIWEBController.CacheMethodTop')), function () {
            return ApiLog::MethodTop()->StatMonth()->limit(config('ApiCharts.APIWEBController.MethodTopLimit'))->get();
        });

        $MethodTop = Charts::create('pie', 'highcharts')
            ->title('Топ ' . config('ApiCharts.APIWEBController.MethodTopLimit') . ' часто используемых вызовов API')
            ->labels($data->pluck('method'))
            ->values($data->pluck('request'))
            ->responsive(true);

        return $MethodTop;

    }

    /**
     * @param $data
     * @return array
     */
    function SortArrayForChart($data)
    {
        Debugbar::addMessage(__CLASS__ . "\\" . __FUNCTION__);
        Debugbar::addMessage($data);

        for ($day = 8, $j = 0; $j <= 8; $j++, $day--) {
            Debugbar::addMessage('var_day: ' . $day);

            if (!isset($data[$j]) || empty($data[$j])) {
                $array[] = 0;
                Debugbar::addMessage('пустой');
                continue;
            }

            if (date('Y-m-d', strtotime("-$day days")) === date('Y-m-d', strtotime($data[$j]['created_at']))) {
                Debugbar::addMessage('Время для сравнения: ' . date('Y-m-d', strtotime("-$day days")));
                Debugbar::addMessage('Время значения из базы: ' . date('Y-m-d', strtotime($data[$j]['created_at'])));
                $array[] = $data[$j]['request'];
                continue;
            }

            if (date('Y-m-d', strtotime("-$day days")) > date('Y-m-d', strtotime($data[$j]['created_at']))) {
                Debugbar::addMessage('Время для сравнения: ' . date('Y-m-d', strtotime("-$day days")));
                Debugbar::addMessage('Время значения из базы: ' . date('Y-m-d', strtotime($data[$j]['created_at'])));

                $array[] = 0;
                Debugbar::addMessage($data);
                array_splice($data, $j, 0, 0);
                Debugbar::addMessage($data);
                //array_unshift($data, null);
                continue;
            }

            if (date('Y-m-d', strtotime("-$day days")) < date('Y-m-d', strtotime($data[$j]['created_at']))) {
                Debugbar::addMessage('Время для сравнения: ' . date('Y-m-d', strtotime("-$day days")));
                Debugbar::addMessage('Время значения из базы: ' . date('Y-m-d', strtotime($data[$j]['created_at'])));
                $array[] = 0;
                Debugbar::addMessage($data);
                array_splice($data, $j, 0, 0);
                Debugbar::addMessage($data);
                //array_unshift($data, null);
                continue;
            }
        }
        Debugbar::addMessage($array);
        Debugbar::addMessage('_______________________________');
        return $array;
    }
}
