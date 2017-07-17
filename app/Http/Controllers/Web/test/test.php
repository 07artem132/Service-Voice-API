<?php

namespace Api\Http\Controllers\Web\Test;

use Api\Services\TeamSpeak3\ts3query;
use Api\Http\Controllers\Cron;
use Illuminate\Http\Request;
use Sentinel;
use Auth;
use Api\Servers;
use Api\Task\TeamSpeakSnapshotsVirtualServers;
use Api\StatisticsInstances;
use Api\StatisticsVirtualServers;
use TeamSpeak3;
use Storage;
use Api\Services\Domain\PowerDNS;
use Api\Traits\RestHelperTrait;
use Api\Http\Controllers\Controller;
use File;

ini_set('memory_limit', '2048M');
set_time_limit(1000);

class test extends Controller
{
    use RestHelperTrait;

    function index()
    {


        //  Storage::disk('cloud-public')->put('test.txt', 'test');
        //     $url = Storage::disk('cloud-public')->getMetadata('test.txt');
        //   dd( 'https://ac3ddaae4ce1e2fd3540-86e666417f45e47f3b79ca304cf41b6b.ssl.cf5.rackcdn.com/'.$url['path']);
//        return $this->JsonFormatedPrint('{"status":"success","data":{"outdated":false,"ServerVersion":"3.0.13.6","VersionUpdateServer":"3.0.13.6"}}');

        //crc32();

    //        foreach (glob("/var/www/html/storage/app/public/teamspeak3/icon/*.png") as $file) {
    //          echo '<img src="data:image/png;base64,' . base64_encode(file_get_contents($file)) . '" />';
    //    }

        $role = Sentinel::findRoleById(1);

        $role->permissions = [
            'api.usage' => true,
            'api.teamspeak.instanse.statistics.realtime' => true,
            'api.teamspeak.instanse.statistics.day' => true,
            'api.teamspeak.instanse.statistics.week' => true,
            'api.teamspeak.instanse.statistics.month' => true,
            'api.teamspeak.instanse.statistics.year' => true,
            'api.teamspeak.virtualserver.statistics.realtime' => true,
            'api.teamspeak.virtualserver.statistics.day' => true,
            'api.teamspeak.virtualserver.statistics.week' => true,
            'api.teamspeak.virtualserver.statistics.month' => true,
            'api.teamspeak.virtualserver.statistics.year' => true,
            'api.teamspeak.virtualserver.snapshot.get' => true,
            'api.teamspeak.virtualserver.snapshot.create' => true,
            'api.teamspeak.virtualserver.snapshot.delete' => true,
            'api.teamspeak.virtualserver.snapshot.list' => true,
            'api.teamspeak.instance.serverlist' => true,
            'api.teamspeak.instance.version' => true,
            'api.teamspeak.instance.instanceinfo' => true,
            'api.teamspeak.instance.hostinfo' => true,
            'api.teamspeak.instance.outdated' => true,
            'api.teamspeak.instance.blacklisted' => true,
            'api.teamspeak.virtualserver.create' => true,
            'api.teamspeak.helpers.blacklisted' => true,
            'api.teamspeak.helpers.UpdateMirrorList' => true,
            'api.teamspeak.instance.log' => true,
            'api.teamspeak.virtualserver.log' => true,
            'api.token.list' => true,
            'api.token.delete' => true,
            'api.token.create' => true,
            'api.token.list.all' => true,
            'api.domain.list' => true,
            'api.domain.record.formated.list' => true,
            'api.domain.record.list' => true,
            'api.domain.record.add' => true,
            'api.domain.record.delete' => true,
            'api.domain.add' => true,
            'api.teamspeak.virtualserver.stop' => true,
            'api.teamspeak.virtualserver.start' => true,
            'api.teamspeak.virtualserver.serverinfo' => true,
            'api.teamspeak.virtualserver.ban.list' => true,
            'api.teamspeak.virtualserver.ban.clear' => true,
            'api.teamspeak.virtualserver.ban.create' => true,
            'api.teamspeak.virtualserver.ban.delete' => true,
            'api.teamspeak.virtualserver.log.full' => true,
            'api.teamspeak.virtualserver.icon.list' => true,
            'api.teamspeak.virtualserver.icon.upload' => true,
            'api.teamspeak.virtualserver.icon.delete' => true,
        ];
        $role->save();

        return $this->JsonFormatedPrint($role);

        //      $year = 2017;
        //    $mont = 6;
        // $day = 30;
        //  $server_id = 1;
        //     for ($mont = 1; $mont <= 12; $mont++) {
        //      for ($day = 1; $day < cal_days_in_month(CAL_GREGORIAN, $mont, $year); $day++) {
        /*    for ($h = 0; $h < 24; $h++) {
                for ($m = 1; $m < 60; $m++) {
                    $db = new StatisticsVirtualServers;
                    $db->server_id = $server_id;
                    $db->unique_id = '1111111111';
                    $db->user_online = rand();
                    $db->slot_usage = rand();
                    $db->avg_ping = rand();
                    $db->avg_packetloss = rand();
                    $db->created_at = date('Y-m-d H:i:s', mktime($h, $m, 0, $mont, $day, $year));
                    $db->save();
                    unset($db);
                }
            }*/
        //     }
        //   }

        //   return ' ';
    }
}
