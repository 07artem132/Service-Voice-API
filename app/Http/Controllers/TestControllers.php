<?php

namespace Api\Http\Controllers;

use Api\Services\TeamSpeak3\teamSpeak;
use Api\Http\Controllers\Cron;
use Illuminate\Http\Request;
use Sentinel;
use Api\Task\TeamSpeakStatisticsInstancesCacheUpdateTask;
use Auth;
use Api\TeamspeakInstances;
use Api\Task\TeamSpeakVirtualServerCreateSnapshotTask;
use Api\StatisticsTeamspeakInstances;
use Api\StatisticsTeamspeakVirtualServers;
use TeamSpeak3;
use Storage;
use Api\Services\Domain\PowerDNS;
use Api\Traits\RestHelperTrait;
use File;
use Carbon\Carbon;
use Redis;
use Cache;

ini_set('memory_limit', '4048M');
set_time_limit(0);

class TestControllers extends Controller
{
    use RestHelperTrait;

       function index()
    {
              return $this->JsonFormatedPrint('{"status":"success","data":[{"instance_id":1,"group_id":4},{"instance_id":2,"group_id":4},{"instance_id":3,"group_id":4}]}');

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
            'api.teamspeak.virtualserver.delete' => true,
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
            'api.domain.delete' => true,
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
            'api.teamspeak.virtualserver.icon.download' => true,
            'api.group.delete' => true,
            'api.group.list' => true,
            'api.group.create' => true,
            'api.group.server.add' => true,
            'api.group.server.remove' => true,
            'api.group.server.list' => true,
            'api.teamspeak.instance.bindinglist' => true,
            'api.teamspeak.instance.edit' => true,
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
                    $db = new StatisticsTeamspeakVirtualServers;
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
