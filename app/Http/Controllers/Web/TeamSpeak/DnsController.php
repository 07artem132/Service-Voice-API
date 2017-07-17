<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 10.07.2017
 * Time: 10:38
 */

namespace Api\Http\Controllers\Web\TeamSpeak;


class DnsController
{
    function list()
    {
        return view('ts3-dns');
    }
}