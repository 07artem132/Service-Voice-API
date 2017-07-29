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

        //region Домены (PowerDNS)
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
        //endregion

        //region TeamSpeak 3
        //region TeamSpeak 3 инстансы
        //////////////////////ВЗАИМОДЕЙСТВИЕ С ИНСТАНСОМ//////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
        Route::get('/teamspeak/instance/{server_id}/hostinfo', [
            'as' => 'TeamSpeakInstanseControllerHostInfo',
            'uses' => 'TeamSpeakInstanseController@HostInfo',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.hostinfo'
        ]);

        Route::get('/teamspeak/instance/{server_id}/instanceinfo', [
            'as' => 'TeamSpeakInstanseControllerInstanceInfo',
            'uses' => 'TeamSpeakInstanseController@InstanceInfo',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.instanceinfo'
        ]);

        Route::get('/teamspeak/instance/{server_id}/version', [
            'as' => 'TeamSpeakInstanseControllerVersion',
            'uses' => 'TeamSpeakInstanseController@Version',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.version'
        ]);

        Route::get('/teamspeak/instance/{server_id}/serverlist', [
            'as' => 'TeamSpeakInstanseControllerServerList',
            'uses' => 'TeamSpeakInstanseController@ServerList',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.serverlist'
        ]);

        Route::get('/teamspeak/instance/{server_id}/bindinglist', [
            'as' => 'TeamSpeakInstanseControllerBindList',
            'uses' => 'TeamSpeakInstanseController@BindList',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.bindinglist'
        ]);

        Route::get('/teamspeak/instance/{server_id}/log/{last_pos}', [
            'as' => 'TeamSpeakInstanseControllerGetLog',
            'uses' => 'TeamSpeakInstanseController@GetLog',
            'where' => [
                'server_id' => '^\d+$',
                'last_pos' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.log'
        ]);

        Route::put('/teamspeak/instance/{server_id}/edit', [
            'as' => 'TeamSpeakInstanseControllerEdit',
            'uses' => 'TeamSpeakInstanseController@Edit',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.instance.edit'
        ]);

        //////////////////////////////////////////////////////////////////////
        //endregion

        //region Виртуальные TeamSpeak 3 сервера
        ///////////////ВЗАИМОДЕЙСТВИЕ С ВИРТУАЛЬНЫМИ СЕРВЕРАМИ////////////////
        //region Базовое
        /////////////////////////////Базовое/////////////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
        Route::post('/teamspeak/instance/{server_id}/virtualserver/create', [
            'as' => 'TeamSpeakVirtualServerControllerCreate',
            'uses' => 'TeamSpeakVirtualServerController@Create',
            'where' => [
                'server_id' => '^\d+$',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.create'
        ]);
        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/delete', [
            'as' => 'TeamSpeakVirtualServerControllerDelete',
            'uses' => 'TeamSpeakVirtualServerController@Delete',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.delete'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/stop', [
            'as' => 'TeamSpeakVirtualServerControllerStop',
            'uses' => 'TeamSpeakVirtualServerController@Stop',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.stop'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/start', [
            'as' => 'TeamSpeakVirtualServerControllerStart',
            'uses' => 'TeamSpeakVirtualServerController@Start',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.start'
        ]);

        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/log/{last_pos}', [
            'as' => 'TeamSpeakVirtualServerControllerGetLog',
            'uses' => 'TeamSpeakVirtualServerController@GetLog',
            'where' => [
                'server_id' => '^\d+$',
                'last_pos' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.log'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/serverinfo', [
            'as' => 'TeamSpeakVirtualServerControllerServerInfo',
            'uses' => 'TeamSpeakVirtualServerController@ServerInfo',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.serverinfo'
        ]);
        //////////////////////////////////////////////////////////////////////
        //endregion
        //region Снапшоты
        /////////////////////////////СНАПШОТЫ/////////////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
        Route::post('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot', [
            'as' => 'SnapshotControllerCreate',
            'uses' => 'TeamSpeakVirtualServerSnapshotController@Create',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.snapshot.create'
        ]); // создать
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot/{snapshot_id}', [
            'as' => 'SnapshotControllerGet',
            'uses' => 'TeamSpeakVirtualServerSnapshotController@Get',
            'where' => [
                'server_id' => '^\d+$',
                'snapshot_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.snapshot.get'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot', [
            'as' => 'SnapshotControllerGetList',
            'uses' => 'TeamSpeakVirtualServerSnapshotController@GetList',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.snapshot.list'
        ]);
        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot/{snapshot_id}', [
            'as' => 'SnapshotControllerDelete',
            'uses' => 'TeamSpeakVirtualServerSnapshotController@Delete',
            'where' => [
                'server_id' => '^\d+$',
                'snapshot_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.snapshot.delete'
        ]);
        //////////////////////////////////////////////////////////////////////
        //endregion
        //region Иконки
        ///////////////////////////////////ИКОНКИ//////////////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО//////////////////////////////////
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon', [
            'as' => 'TeamSpeakIconControllerList',
            'uses' => 'TeamSpeakVirtualServerIconController@List',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.icon.list'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon/{icon_id}', [
            'as' => 'TeamSpeakIconControllerDownload',
            'uses' => 'TeamSpeakVirtualServerIconController@Download',
            'where' => [
                'server_id' => '^\d+$',
                'icon_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.icon.download'
        ]);
        Route::post('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon', [
            'as' => 'TeamSpeakIconControllerUpload',
            'uses' => 'TeamSpeakVirtualServerIconController@Upload',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.icon.upload'
        ]);
        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon/{icon_id}', [
            'as' => 'TeamSpeakIconControllerDelete',
            'uses' => 'TeamSpeakVirtualServerIconController@Delete',
            'where' => [
                'server_id' => '^\d+$',
                'icon_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.icon.delete'
        ]);
        //////////////////////////////////////////////////////////////////////
        //endregion
        //region Баны
        ///////////////////////////////////БАНЫ//////////////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////////
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban', [
            'as' => 'VirtualServerBanControllersList',
            'uses' => 'TeamSpeakVirtualServerBanControllers@List',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.ban.list'
        ]);
        Route::post('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban', [
            'as' => 'VirtualServerBanControllersCreate',
            'uses' => 'TeamSpeakVirtualServerBanControllers@Create',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.ban.create'
        ]);
        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban/clear', [
            'as' => 'VirtualServerBanControllersListClear',
            'uses' => 'TeamSpeakVirtualServerBanControllers@ListClear',
            'where' => [
                'server_id' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.ban.clear'
        ]);
        Route::delete('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban/{banid}', [
            'as' => 'VirtualServerBanControllersDelete',
            'uses' => 'TeamSpeakVirtualServerBanControllers@Delete',
            'where' => [
                'server_id' => '[0-9]+',
                'banid' => '[0-9]+',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.ban.delete'
        ]);
        //////////////////////////////////////////////////////////////////////
        //endregion
        //////////////////////////////////////////////////////////////////////
        //endregion

        //region Статистика
        ///////////////////////////СТАТИСТИКА/////////////////////////////////
        //region Инстансы
        ////////////////////////////Инстансы///////////////////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО///////////////////////////////
        Route::get('/teamspeak/instance/{server_id}/statistics/realtime', [
            'as' => 'InstanceStatisticsControllerRealtime',
            'uses' => 'TeamSpeakInstanceStatisticsController@Realtime',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.realtime'
        ]);
        Route::get('/teamspeak/instance/{server_id}/statistics/day', [
            'as' => 'InstanceStatisticsControllerDay',
            'uses' => 'TeamSpeakInstanceStatisticsController@Day',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.day'
        ]);
        Route::get('/teamspeak/instance/{server_id}/statistics/week', [
            'as' => 'InstanceStatisticsControllerWeek',
            'uses' => 'TeamSpeakInstanceStatisticsController@Week',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.week'
        ]);
        Route::get('/teamspeak/instance/{server_id}/statistics/month', [
            'as' => 'InstanceStatisticsControllerMonth',
            'uses' => 'TeamSpeakInstanceStatisticsController@Month',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.month'
        ]);
        Route::get('/teamspeak/instance/{server_id}/statistics/year', [
            'as' => 'InstanceStatisticsControllerYear',
            'uses' => 'TeamSpeakInstanceStatisticsController@Year',
            'where' => [
                'server_id' => '[0-9]+',
            ],
            'middleware' => 'permissions:api.teamspeak.instanse.statistics.year'
        ]);
        /////////////////////////////////////////////////////////////////////////
        //endregion
        //region Виртуальные TeamSpeak 3 сервера
        //////////////////Виртуальные TeamSpeak 3 сервера///////////////////////
        /////////////////////////ДОКУМЕНТИРОВАНО///////////////////////////////
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/realtime', [
            'as' => 'VirtualServerStatisticsControllerRealtime',
            'uses' => 'TeamSpeakVirtualServerStatisticsController@Realtime',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.realtime'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/day', [
            'as' => 'VirtualServerStatisticsControllerDay',
            'uses' => 'TeamSpeakVirtualServerStatisticsController@Day',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.day'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/week', [
            'as' => 'VirtualServerStatisticsControllerWeek',
            'uses' => 'TeamSpeakVirtualServerStatisticsController@Week',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.week'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/month', [
            'as' => 'VirtualServerStatisticsControllerMonth',
            'uses' => 'TeamSpeakVirtualServerStatisticsController@Month',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.month'
        ]);
        Route::get('/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/year', [
            'as' => 'VirtualServerStatisticsControllerYear',
            'uses' => 'TeamSpeakVirtualServerStatisticsController@Year',
            'where' => [
                'server_id' => '^\d+$',
                'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
            ],
            'middleware' => 'permissions:api.teamspeak.virtualserver.statistics.year'
        ]);
        //////////////////////////////////////////////////////////////////////
        //endregion
        //////////////////////////////////////////////////////////////////////
        //endregion

        //region Хелперы
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
        //endregion
        //endregion

        //region Токены (По ним идентифицируется пользователь)
        /////////////////////////////ТОКЕНЫ/////////////////////////////////////
        Route::delete('/token/{token}', [
            'as' => 'TokenControllerDelete',
            'uses' => 'TokenController@Delete',
            'where' => [
                'id' => '^\d+$',
            ],
            'middleware' => [
                'permissions:api.token.delete'
            ]
        ]);
        Route::get('/token', [
            'as' => 'TokenControllerList',
            'uses' => 'TokenController@List',
            'where' => [
                'id' => '^\d+$',
            ],
            'middleware' => [
                'permissions:api.token.list'
            ]
        ]);
        Route::post('/token', [
            'as' => 'TokenControllerCreate',
            'uses' => 'TokenController@Create',
            'where' => [
                'id' => '^\d+$',
            ],
            'middleware' => [
                'permissions:api.token.create'
            ]
        ]);
        ////////////////////////////////////////////////////////////////////////
        //endregion

        //region Группы серверов
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
        //endregion

    });
});

