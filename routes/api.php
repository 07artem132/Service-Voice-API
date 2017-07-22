<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::domain(env('APP_DOMAIN'))->prefix('v1/')->group(function () {

    Route::group(['middleware' => ['permissions:api.usage']], function () {

        /////////////////////////////СТАТИСТИКА/////////////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО///////////////////////////////

        Route::get('/teamspeak/instance/{server_id}/statistics/realtime', [
            'as' => 'InstanceStatisticsControllerRealtime',
            'uses' => 'InstanceStatisticsController@Realtime',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.realtime'
        ]);

        Route::get('/teamspeak/instance/{server_id}/statistics/day', [
            'as' => 'InstanceStatisticsControllerDay',
            'uses' => 'InstanceStatisticsController@Day',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.day'
        ]);

        Route::get('/teamspeak/instance/{server_id}/statistics/week', [
            'as' => 'InstanceStatisticsControllerWeek',
            'uses' => 'InstanceStatisticsController@Week',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.week'
        ]);

        Route::get('/teamspeak/instance/{server_id}/statistics/month', [
            'as' => 'InstanceStatisticsControllerMonth',
            'uses' => 'InstanceStatisticsController@Month',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.month'
        ]);

        Route::get('/teamspeak/instance/{server_id}/statistics/year', [
            'as' => 'InstanceStatisticsControllerYear',
            'uses' => 'InstanceStatisticsController@Year',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.year'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/realtime', [
            'as' => 'VirtualServerStatisticsControllerRealtime',
            'uses' => 'VirtualServerStatisticsController@Realtime',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.realtime'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/day', [
            'as' => 'VirtualServerStatisticsControllerDay',
            'uses' => 'VirtualServerStatisticsController@Day',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.day'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/week', [
            'as' => 'VirtualServerStatisticsControllerWeek',
            'uses' => 'VirtualServerStatisticsController@Week',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.week'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/month', [
            'as' => 'VirtualServerStatisticsControllerMonth',
            'uses' => 'VirtualServerStatisticsController@Month',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.month'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/year', [
            'as' => 'VirtualServerStatisticsControllerYear',
            'uses' => 'VirtualServerStatisticsController@Year',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.year'
        ]);
        //////////////////////////////////////////////////////////////////////


        /////////////////////////////СНАПШОТЫ/////////////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
        Route::post('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot', [
            'as' => 'SnapshotControllerCreate',
            'uses' => 'SnapshotController@Create',
            'where' => [
                'server_id' =>  '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.snapshot.create'
        ]); // создать

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot/{snapshot_id}', [
            'as' => 'SnapshotControllerGet',
            'uses' => 'SnapshotController@Get',
            'where' => [
                'server_id' =>  '^\d+$',
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.snapshot.get'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot', [
            'as' => 'SnapshotControllerGetList',
            'uses' => 'SnapshotController@GetList',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.snapshot.list'
        ]);

        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot/{snapshot_id}', [
            'as' => 'SnapshotControllerDelete',
            'uses' => 'SnapshotController@Delete',
            'where' => [
                'server_id' => '^\d+$',
                'snapshot_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.snapshot.delete'
        ]);

        //////////////////////////////////////////////////////////////////////

        ///////////////////////TEAMSPEAK 3 ХЕЛПЕРЫ///////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
        Route::get('/teamspeak/instance/{server_id}/blacklisted', [
            'as' => 'TeamSpeakHelpersControllerInstanceIsBlacklisted',
            'uses' => 'TeamSpeakHelpersController@InstanceIsBlacklisted',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.blacklisted'
        ]);

        Route::get('/teamspeak/helpers/{ip}/blacklisted', [
            'as' => 'TeamSpeakHelpersControllerIPv4IsBlacklisted',
            'uses' => 'TeamSpeakHelpersController@IPv4IsBlacklisted',
            'where' => [
                'ip' => '^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$',
            ],
            'middleware' => 'permissions:api.teamspeak.helpers.blacklisted'
        ]);

        Route::get('/teamspeak/helpers/server/update/mirror/list', [
            'as' => 'TeamSpeakHelpersControllerUpdateServerMirrorList',
            'uses' => 'TeamSpeakHelpersController@UpdateServerMirrorList',
            'middleware' => 'permissions:api.teamspeak.helpers.UpdateMirrorList'
        ]);

        Route::get('/teamspeak/instance/{server_id}/outdated', [
            'as' => 'TeamSpeakHelpersControllerInstanceOutdatedCheck',
            'uses' => 'TeamSpeakHelpersController@InstanceOutdatedCheck',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.outdated'
        ]);

        //////////////////////////////////////////////////////////////////////

        ///////////////////ВЗАИМОДЕЙСТВИЕ С ДОМЕНАМИ//////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////

        Route::get('domain', [
            'as' => 'DomainControllerList',
            'uses' => 'DomainController@List',
            'middleware' => 'permissions:api.domain.list'
        ]);

        Route::get('domain/{domain}/record/formated', [
            'as' => 'DomainRecordList',
            'uses' => 'DomainController@RecordFormatedList',
            'where' => [
                'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
            ],
            'middleware' => 'permissions:api.domain.record.formated.list'
        ]);

        Route::get('domain/{domain}/record', [
            'as' => 'DomainRecordList',
            'uses' => 'DomainController@RecordList',
            'where' => [
                'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
            ],
            'middleware' => 'permissions:api.domain.record.list'
        ]);

        Route::post('domain', [
            'as' => 'DomainAdd',
            'uses' => 'DomainController@Add',
            'middleware' => 'permissions:api.domain.add'
        ]);

        Route::post('domain/{domain}/record', [
            'as' => 'DomainRecordAdd',
            'uses' => 'DomainController@RecordAdd',
            'where' => [
                'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
            ],
            'middleware' => 'permissions:api.domain.record.add'
        ]);

        Route::delete('domain/{domain}/record', [
            'as' => 'DomainRecordAdd',
            'uses' => 'DomainController@RecordDelete',
            'where' => [
                'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
            ],
            'middleware' => 'permissions:api.domain.record.delete'
        ]);

        Route::delete('domain/{domain}', [
            'as' => 'DomainDelete',
            'uses' => 'DomainController@Delete',
            'where' => [
                'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
            ],
            'middleware' => 'permissions:api.domain.delete'
        ]);

        //////////////////////////////////////////////////////////////////////

        ///////////////ВЗАИМОДЕЙСТВИЕ С ВИРТУАЛЬНЫМИ СЕРВЕРАМИ////////////////
        Route::post('/teamspeak/instance/{server_id}/virtualserver/create', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerCreate',
            'uses' => 'Api\TeamSpeak\InstanceQuery@VirtualServerCreate',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.create'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/log/{last_pos}', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerLog',
            'uses' => 'Api\TeamSpeak\InstanceQuery@GetVirtualServerLog',
            'where' => [
                'server_id' => '[0-9]+',
                'last_pos' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.log'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/stop', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerStop',
            'uses' => 'Api\TeamSpeak\InstanceQuery@VirtualServerStop',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.stop'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/start', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerStart',
            'uses' => 'Api\TeamSpeak\InstanceQuery@VirtualServerStart',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.start'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/serverinfo', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerInfo',
            'uses' => 'Api\TeamSpeak\InstanceQuery@VirtualServerInfo',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.serverinfo'
        ]);
        ///////////////////////////////////ИКОНКИ//////////////////////////////////
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon', [
            'as' => 'TeamSpeakIconControllerList',
            'uses' => 'Api\TeamSpeak\IconController@List',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.icon.list'
        ]);
        Route::post('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon', [
            'as' => 'TeamSpeakIconControllerUpload',
            'uses' => 'Api\TeamSpeak\IconController@Upload',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.icon.upload'
        ]);
        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon/{icon_id}', [
            'as' => 'TeamSpeakIconControllerDelete',
            'uses' => 'Api\TeamSpeak\IconController@Delete',
            'where' => [
                'server_id' => '[0-9]+',
                'icon_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.icon.delete'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon/{icon_id}', [
            'as' => 'TeamSpeakIconControllerDownload',
            'uses' => 'Api\TeamSpeak\IconController@Download',
            'where' => [
                'server_id' => '[0-9]+',
                'icon_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.icon.download'
        ]);
        ///////////////////////////////////БАНЫ//////////////////////////////////
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerBanList',
            'uses' => 'Api\TeamSpeak\InstanceQuery@VirtualServerBanList',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.ban.list'
        ]);

        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban/clear', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerBanListClear',
            'uses' => 'Api\TeamSpeak\InstanceQuery@VirtualServerBanListClear',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.ban.clear'
        ]);

        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban/{banid}', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerBanDelete',
            'uses' => 'Api\TeamSpeak\InstanceQuery@VirtualServerBanDelete',
            'where' => [
                'server_id' => '[0-9]+',
                'banid' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.ban.delete'
        ]);

        Route::post('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban', [
            'as' => 'TeamSpeakInstanceQueryVirtualServerBanCreate',
            'uses' => 'Api\TeamSpeak\InstanceQuery@VirtualServerBanCreate',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.ban.create'
        ]);

        //////////////////////////////////////////////////////////////////////

        /////////////////////////////ТОКЕНЫ/////////////////////////////////////
        Route::delete('/token/{token}', [
            'as' => 'TokenDelete',
            'uses' => 'Api\Token\TokenController@Delete',
            'where' => [
                'id' => '[0-9]+',
            ],
            'middleware' => ['permissions:api.token.delete']
        ]);
        Route::get('/token/list', [
            'as' => 'AllTokenList',
            'uses' => 'Api\Token\TokenController@AllTokenList',
            'where' => [
                'id' => '[0-9]+',
            ],
            'middleware' => ['permissions:api.token.list.all']
        ]);
        Route::get('/token', [
            'as' => 'TokenList',
            'uses' => 'Api\Token\TokenController@UserTokenList',
            'where' => [
                'id' => '[0-9]+',
            ],
            'middleware' => ['permissions:api.token.list']
        ]);
        Route::post('/token', [
            'as' => 'TokenCreate',
            'uses' => 'Api\Token\TokenController@Create',
            'where' => [
                'id' => '[0-9]+',
            ],
            'middleware' => ['permissions:api.token.create']
        ]);
        ////////////////////////////////////////////////////////////////////////

        /////////////////////////////Группы серверов/////////////////////////////////////
        Route::delete('/group/{group}', [
            'as' => 'GroupDelete',
            'uses' => 'Api\Group\GroupController@Delete',
            'where' => [
                'group' => '^[A-Za-z]+$',
            ],
            'middleware' => ['permissions:api.group.delete']
        ]);
        Route::get('/group', [
            'as' => 'GroupList',
            'uses' => 'Api\Group\GroupController@List',
            'middleware' => ['permissions:api.group.list']
        ]);
        Route::post('/group', [
            'as' => 'GroupCreate',
            'uses' => 'Api\Group\GroupController@Create',
            'middleware' => ['permissions:api.group.create']
        ]);
        Route::get('/group/{group}', [
            'as' => 'ServerGroupList',
            'uses' => 'Api\Group\GroupController@ServerGroupList',
            'middleware' => ['permissions:api.group.server.list']
        ]);
        Route::post('/group/{group}/{server_id}', [
            'as' => 'ServerAddGroup',
            'uses' => 'Api\Group\GroupController@ServerAddGroup',
            'where' => [
                'group' => '^[A-Za-z]+$',
                'server_id' => '[0-9]+',
            ],
            'middleware' => ['permissions:api.group.server.add']
        ]);
        Route::delete('/group/{group}/{server_id}', [
            'as' => 'ServerRemoveGroup',
            'uses' => 'Api\Group\GroupController@ServerRemoveGroup',
            'where' => [
                'group' => '^[A-Za-z]+$',
                'server_id' => '[0-9]+',
            ],
            'middleware' => ['permissions:api.group.server.remove']
        ]);

        ////////////////////////////////////////////////////////////////////////

        //////////////////////ВЗАИМОДЕЙСТВИЕ С ИНСТАНСОМ//////////////////////
        Route::get('/teamspeak/instance/{server_id}/hostinfo', [
            'as' => 'TeamSpeakInstanceQueryHostinfo',
            'uses' => 'Api\TeamSpeak\InstanceQuery@hostinfo',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.hostinfo'
        ]);

        Route::get('/teamspeak/instance/{server_id}/instanceinfo', [
            'as' => 'TeamSpeakInstanceQueryInstanceinfo',
            'uses' => 'Api\TeamSpeak\InstanceQuery@instanceinfo',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.instanceinfo'
        ]);

        Route::get('/teamspeak/instance/{server_id}/version', [
            'as' => 'TeamSpeakInstanceQueryVersion',
            'uses' => 'Api\TeamSpeak\InstanceQuery@version',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.version'
        ]);

        Route::get('/teamspeak/instance/{server_id}/serverlist', [
            'as' => 'TeamSpeakInstanceQueryServerlist',
            'uses' => 'Api\TeamSpeak\InstanceQuery@serverlist',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.serverlist'
        ]);

        Route::get('/teamspeak/instance/{server_id}/log/{last_pos}', [
            'as' => 'TeamSpeakInstanceQueryInstanceLog',
            'uses' => 'Api\TeamSpeak\InstanceQuery@GetInstanceLog',
            'where' => [
                'server_id' => '[0-9]+',
                'last_pos' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.log'
        ]);
        //////////////////////////////////////////////////////////////////////

        ////////////////////////////////Бекапы////////////////////////////////

        //////////////////////////////////////////////////////////////////////
    });
});

