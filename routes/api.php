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

Route::domain( env( 'APP_DOMAIN' ) )->prefix( 'v1/' )->group( function () {

	Route::group( [ 'middleware' => [ 'permissions:api.usage' ] ], function () {

		//region Домены (PowerDNS)
		///////////////////ВЗАИМОДЕЙСТВИЕ С ДОМЕНАМИ//////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////

		Route::get( 'domain', [
			'as'         => 'DomainControllerList',
			'uses'       => 'DomainController@List',
			'middleware' => [
				'permissions:api.domain.list',
			]
		] );

		Route::get( 'domain/{domain}/record/formated', [
			'as'         => 'DomainRecordList',
			'uses'       => 'DomainController@RecordFormatedList',
			'where'      => [
				'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
			],
			'middleware' => 'permissions:api.{domain}.record.formated.list'
		] );

		Route::get( 'domain/{domain}/record', [
			'as'         => 'DomainRecordList',
			'uses'       => 'DomainController@RecordList',
			'where'      => [
				'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
			],
			'middleware' => 'permissions:api.{domain}.record.list'
		] );

		Route::post( 'domain', [
			'as'         => 'DomainAdd',
			'uses'       => 'DomainController@Add',
			'middleware' => 'permissions:api.domain.add'
		] );

		Route::post( 'domain/{domain}/record', [
			'as'         => 'DomainRecordAdd',
			'uses'       => 'DomainController@RecordAdd',
			'where'      => [
				'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
			],
			'middleware' => 'permissions:api.{domain}.record.add'
		] );

		Route::delete( 'domain/{domain}/record', [
			'as'         => 'DomainRecordAdd',
			'uses'       => 'DomainController@RecordDelete',
			'where'      => [
				'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
			],
			'middleware' => 'permissions:api.{domain}.record.delete'
		] );

		Route::delete( 'domain/{domain}', [
			'as'         => 'DomainDelete',
			'uses'       => 'DomainController@Delete',
			'where'      => [
				'domain' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$',
			],
			'middleware' => 'permissions:api.{domain}.delete'
		] );

		//////////////////////////////////////////////////////////////////////
		//endregion



		//region TeamSpeak 3
		//region Инстансы
		//////////////////////ВЗАИМОДЕЙСТВИЕ С ИНСТАНСОМ//////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/hostinfo', [
			'as'         => 'TeamSpeakInstanseControllerHostInfo',
			'uses'       => 'TeamSpeakInstanseController@HostInfo',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => 'permissions:api.teamspeak.instance.hostinfo'
		] );

		Route::get( '/teamspeak/instance/{server_id}/instanceinfo', [
			'as'         => 'TeamSpeakInstanseControllerInstanceInfo',
			'uses'       => 'TeamSpeakInstanseController@InstanceInfo',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => 'permissions:api.teamspeak.instance.instanceinfo'
		] );

		Route::get( '/teamspeak/instance/{server_id}/version', [
			'as'         => 'TeamSpeakInstanseControllerVersion',
			'uses'       => 'TeamSpeakInstanseController@Version',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => 'permissions:api.teamspeak.instance.version'
		] );

		Route::get( '/teamspeak/instance/{server_id}/serverlist', [
			'as'         => 'TeamSpeakInstanseControllerServerList',
			'uses'       => 'TeamSpeakInstanseController@ServerList',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => 'permissions:api.teamspeak.instance.serverlist'
		] );

		Route::get( '/teamspeak/instance/{server_id}/bindinglist', [
			'as'         => 'TeamSpeakInstanseControllerBindList',
			'uses'       => 'TeamSpeakInstanseController@BindList',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => 'permissions:api.teamspeak.instance.bindinglist'
		] );

		Route::get( '/teamspeak/instance/{server_id}/log/{last_pos}', [
			'as'         => 'TeamSpeakInstanseControllerGetLog',
			'uses'       => 'TeamSpeakInstanseController@GetLog',
			'where'      => [
				'server_id' => '^\d+$',
				'last_pos'  => '^\d+$',
			],
			'middleware' => 'permissions:api.teamspeak.instance.log'
		] );

		Route::put( '/teamspeak/instance/{server_id}/edit', [
			'as'         => 'TeamSpeakInstanseControllerEdit',
			'uses'       => 'TeamSpeakInstanseController@Edit',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => 'permissions:api.teamspeak.instance.edit'
		] );

		//////////////////////////////////////////////////////////////////////
		//endregion

		//region Виртуальные сервера
		///////////////ВЗАИМОДЕЙСТВИЕ С ВИРТУАЛЬНЫМИ СЕРВЕРАМИ////////////////
		//region Базовое
		/////////////////////////////Базовое/////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
		Route::post( '/teamspeak/instance/{server_id}/virtualserver/create', [
			'as'         => 'TeamSpeakVirtualServerControllerCreate',
			'uses'       => 'TeamSpeakVirtualServerController@Create',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.create',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::delete( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/delete', [
			'as'         => 'TeamSpeakVirtualServerControllerDelete',
			'uses'       => 'TeamSpeakVirtualServerController@Delete',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.delete',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/stop', [
			'as'         => 'TeamSpeakVirtualServerControllerStop',
			'uses'       => 'TeamSpeakVirtualServerController@Stop',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.stop',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/start', [
			'as'         => 'TeamSpeakVirtualServerControllerStart',
			'uses'       => 'TeamSpeakVirtualServerController@Start',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.start',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/log/{last_pos}', [
			'as'         => 'TeamSpeakVirtualServerControllerGetLog',
			'uses'       => 'TeamSpeakVirtualServerController@GetLog',
			'where'      => [
				'server_id'  => '^\d+$',
				'last_pos'   => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.log',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/serverinfo', [
			'as'         => 'TeamSpeakVirtualServerControllerServerInfo',
			'uses'       => 'TeamSpeakVirtualServerController@ServerInfo',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.serverinfo',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );
		//////////////////////////////////////////////////////////////////////
		//endregion
		//region Снапшоты
		/////////////////////////////СНАПШОТЫ/////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
		Route::post( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot', [
			'as'         => 'SnapshotControllerCreate',
			'uses'       => 'TeamSpeakVirtualServerSnapshotController@Create',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.snapshot.create',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] ); // создать

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot/{snapshot_id}', [
			'as'         => 'SnapshotControllerGet',
			'uses'       => 'TeamSpeakVirtualServerSnapshotController@Get',
			'where'      => [
				'server_id'   => '^\d+$',
				'snapshot_id' => '^\d+$',
				'bashe64uid'  => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.snapshot.get',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot/{snapshot_id}/download', [
			'as'         => 'SnapshotControllerDownload',
			'uses'       => 'TeamSpeakVirtualServerSnapshotController@Download',
			'where'      => [
				'server_id'   => '^\d+$',
				'snapshot_id' => '^\d+$',
				'bashe64uid'  => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.snapshot.download',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot/{snapshot_id}/restore', [
			'as'         => 'SnapshotControllerRestore',
			'uses'       => 'TeamSpeakVirtualServerSnapshotController@Restore',
			'where'      => [
				'server_id'   => '^\d+$',
				'snapshot_id' => '^\d+$',
				'bashe64uid'  => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.snapshot.restore',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot', [
			'as'         => 'SnapshotControllerGetList',
			'uses'       => 'TeamSpeakVirtualServerSnapshotController@GetList',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.snapshot.list',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::delete( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/snapshot/{snapshot_id}', [
			'as'         => 'SnapshotControllerDelete',
			'uses'       => 'TeamSpeakVirtualServerSnapshotController@Delete',
			'where'      => [
				'server_id'   => '^\d+$',
				'snapshot_id' => '^\d+$',
				'bashe64uid'  => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.snapshot.delete',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		//////////////////////////////////////////////////////////////////////
		//endregion
		//region Иконки
		///////////////////////////////////ИКОНКИ//////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО//////////////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon', [
			'as'         => 'TeamSpeakIconControllerList',
			'uses'       => 'TeamSpeakVirtualServerIconController@List',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.icon.list',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon/{icon_id}', [
			'as'         => 'TeamSpeakIconControllerDownload',
			'uses'       => 'TeamSpeakVirtualServerIconController@Download',
			'where'      => [
				'server_id'  => '^\d+$',
				'icon_id'    => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.icon.download',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::post( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon', [
			'as'         => 'TeamSpeakIconControllerUpload',
			'uses'       => 'TeamSpeakVirtualServerIconController@Upload',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.icon.upload',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::delete( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/icon/{icon_id}', [
			'as'         => 'TeamSpeakIconControllerDelete',
			'uses'       => 'TeamSpeakVirtualServerIconController@Delete',
			'where'      => [
				'server_id'  => '^\d+$',
				'icon_id'    => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.icon.delete',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );
		//////////////////////////////////////////////////////////////////////
		//endregion
		//region Файлы
		///////////////////////////////////ФАЙЛЫ//////////////////////////////////
		///////////////////////////////ДОКУМЕНТИРОВАНО///////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/file', [
			'as'         => 'TeamSpeakVirtualServerFileControllerList',
			'uses'       => 'TeamSpeakVirtualServerFileController@List',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.file.list',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/file/{cid}/{bashe64src}', [
			'as'         => 'TeamSpeakVirtualServerFileControllerDownload',
			'uses'       => 'TeamSpeakVirtualServerFileController@Download',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
				'bashe64src' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
				'cid'        => '^\d+$',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.file.download',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::delete( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/file/{cid}/{bashe64src}', [
			'as'         => 'TeamSpeakVirtualServerFileControllerDelete',
			'uses'       => 'TeamSpeakVirtualServerFileController@Delete',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
				'bashe64src' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
				'cid'        => '^\d+$',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.file.delete',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );
		//////////////////////////////////////////////////////////////////////
		//endregion
		//region Баны
		///////////////////////////////////БАНЫ//////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban', [
			'as'         => 'VirtualServerBanControllersList',
			'uses'       => 'TeamSpeakVirtualServerBanControllers@List',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.ban.list',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::post( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban', [
			'as'         => 'VirtualServerBanControllersCreate',
			'uses'       => 'TeamSpeakVirtualServerBanControllers@Create',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.ban.create',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::delete( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban/clear', [
			'as'         => 'VirtualServerBanControllersListClear',
			'uses'       => 'TeamSpeakVirtualServerBanControllers@ListClear',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.ban.clear',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::delete( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/ban/{banid}', [
			'as'         => 'VirtualServerBanControllersDelete',
			'uses'       => 'TeamSpeakVirtualServerBanControllers@Delete',
			'where'      => [
				'server_id'  => '^\d+$',
				'banid'      => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.ban.delete',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );
		//////////////////////////////////////////////////////////////////////
		//endregion
		//region Каналы
		///////////////////////////////////КАНАЛЫ//////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/channel', [
			'as'         => 'TeamSpeakVirtualServerChannelControllerList',
			'uses'       => 'TeamSpeakVirtualServerChannelController@List',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.channel.list',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::post( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/channel', [
			'as'         => 'TeamSpeakVirtualServerChannelControllerCreate',
			'uses'       => 'TeamSpeakVirtualServerChannelController@Create',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.channel.create',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::delete( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/channel/{channelid}', [
			'as'         => 'TeamSpeakVirtualServerChannelControllerDelete',
			'uses'       => 'TeamSpeakVirtualServerChannelController@Delete',
			'where'      => [
				'server_id'  => '^\d+$',
				'channelid'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.channel.delete',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/channel/{channelid}/info', [
			'as'         => 'TeamSpeakVirtualServerChannelControllerInfo',
			'uses'       => 'TeamSpeakVirtualServerChannelController@Info',
			'where'      => [
				'server_id'  => '^\d+$',
				'channelid'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.channel.info',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::put( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/channel/{channelid}/move', [
			'as'         => 'TeamSpeakVirtualServerChannelControllerMove',
			'uses'       => 'TeamSpeakVirtualServerChannelController@Move',
			'where'      => [
				'server_id'  => '^\d+$',
				'channelid'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.channel.move',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::put( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/channel/{channelid}', [
			'as'         => 'TeamSpeakVirtualServerChannelControllerEdit',
			'uses'       => 'TeamSpeakVirtualServerChannelController@Edit',
			'where'      => [
				'server_id'  => '^\d+$',
				'channelid'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.channel.edit',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );
		//////////////////////////////////////////////////////////////////////
		//endregion
		//region Токены
		//////////////////////////////Токены//////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/token', [
			'as'         => 'TeamSpeakVirtualServerTokenControllerList',
			'uses'       => 'TeamSpeakVirtualServerTokenController@List',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.token.list',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::post( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/token', [
			'as'         => 'TeamSpeakVirtualServerTokenControllerCreate',
			'uses'       => 'TeamSpeakVirtualServerTokenController@Create',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.token.create',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::delete( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/token/{bashe64token}', [
			'as'         => 'TeamSpeakVirtualServerTokenControllerDelete',
			'uses'       => 'TeamSpeakVirtualServerTokenController@Delete',
			'where'      => [
				'server_id'    => '^\d+$',
				'bashe64token' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
				'bashe64uid'   => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.token.delete',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );
		//////////////////////////////////////////////////////////////////////
		//endregion

		//////////////////////////////////////////////////////////////////////
		//endregion

		//region Статистика
		///////////////////////////СТАТИСТИКА/////////////////////////////////
		//region Инстансы
		////////////////////////////Инстансы///////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО///////////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/statistics/realtime', [
			'as'         => 'InstanceStatisticsControllerRealtime',
			'uses'       => 'TeamSpeakInstanceStatisticsController@Realtime',
			'where'      => [
				'server_id' => '[0-9]+',
			],
			'middleware' => 'permissions:api.teamspeak.instanse.statistics.realtime'
		] );
		Route::get( '/teamspeak/instance/{server_id}/statistics/day', [
			'as'         => 'InstanceStatisticsControllerDay',
			'uses'       => 'TeamSpeakInstanceStatisticsController@Day',
			'where'      => [
				'server_id' => '[0-9]+',
			],
			'middleware' => 'permissions:api.teamspeak.instanse.statistics.day'
		] );
		Route::get( '/teamspeak/instance/{server_id}/statistics/week', [
			'as'         => 'InstanceStatisticsControllerWeek',
			'uses'       => 'TeamSpeakInstanceStatisticsController@Week',
			'where'      => [
				'server_id' => '[0-9]+',
			],
			'middleware' => 'permissions:api.teamspeak.instanse.statistics.week'
		] );
		Route::get( '/teamspeak/instance/{server_id}/statistics/month', [
			'as'         => 'InstanceStatisticsControllerMonth',
			'uses'       => 'TeamSpeakInstanceStatisticsController@Month',
			'where'      => [
				'server_id' => '[0-9]+',
			],
			'middleware' => 'permissions:api.teamspeak.instanse.statistics.month'
		] );
		Route::get( '/teamspeak/instance/{server_id}/statistics/year', [
			'as'         => 'InstanceStatisticsControllerYear',
			'uses'       => 'TeamSpeakInstanceStatisticsController@Year',
			'where'      => [
				'server_id' => '[0-9]+',
			],
			'middleware' => 'permissions:api.teamspeak.instanse.statistics.year'
		] );
		/////////////////////////////////////////////////////////////////////////
		//endregion
		//region Виртуальные TeamSpeak 3 сервера
		//////////////////Виртуальные TeamSpeak 3 сервера///////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО///////////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/realtime', [
			'as'         => 'VirtualServerStatisticsControllerRealtime',
			'uses'       => 'TeamSpeakVirtualServerStatisticsController@Realtime',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.statistics.realtime',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/day', [
			'as'         => 'VirtualServerStatisticsControllerDay',
			'uses'       => 'TeamSpeakVirtualServerStatisticsController@Day',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.statistics.day',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/week', [
			'as'         => 'VirtualServerStatisticsControllerWeek',
			'uses'       => 'TeamSpeakVirtualServerStatisticsController@Week',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.statistics.week',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/month', [
			'as'         => 'VirtualServerStatisticsControllerMonth',
			'uses'       => 'TeamSpeakVirtualServerStatisticsController@Month',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.statistics.month',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/virtualserver/{bashe64uid}/statistics/year', [
			'as'         => 'VirtualServerStatisticsControllerYear',
			'uses'       => 'TeamSpeakVirtualServerStatisticsController@Year',
			'where'      => [
				'server_id'  => '^\d+$',
				'bashe64uid' => '(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?',
			],
			'middleware' => [
				'permissions:api.teamspeak.virtualserver.statistics.year',
				'TokenVerifiTeamspeakVirtualServersAllow'
			]
		] );
		//////////////////////////////////////////////////////////////////////
		//endregion
		//region Групп инстансов
		//////////////////Статистика групп инстансов///////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО///////////////////////////////
		Route::get( '/teamspeak/instance/group/{group}/statistics/realtime', [
			'as'    => 'TeamSpeakInstanceStatisticsGroupControllerRealtime',
			'uses'  => 'TeamSpeakInstanceStatisticsGroupController@Realtime',
			'where' => [
				'group' => '^[a-zA-Z0-9]+$',
			],
			//'middleware' => 'permissions:api.teamspeak.instanse.statistics.realtime'
		] );
		Route::get( '/teamspeak/instance/group/{group}/statistics/day', [
			'as'    => 'TeamSpeakInstanceStatisticsGroupControllerDay',
			'uses'  => 'TeamSpeakInstanceStatisticsGroupController@Day',
			'where' => [
				'group' => '^[a-zA-Z0-9]+$',
			],
			//'middleware' => 'permissions:api.teamspeak.instanse.statistics.realtime'
		] );
		Route::get( '/teamspeak/instance/group/{group}/statistics/week', [
			'as'    => 'TeamSpeakInstanceStatisticsGroupControllerWeek',
			'uses'  => 'TeamSpeakInstanceStatisticsGroupController@Week',
			'where' => [
				'group' => '^[a-zA-Z0-9]+$',
			],
			//'middleware' => 'permissions:api.teamspeak.instanse.statistics.realtime'
		] );
		Route::get( '/teamspeak/instance/group/{group}/statistics/month', [
			'as'    => 'TeamSpeakInstanceStatisticsGroupControllerMonth',
			'uses'  => 'TeamSpeakInstanceStatisticsGroupController@Month',
			'where' => [
				'group' => '^[a-zA-Z0-9]+$',
			],
			//'middleware' => 'permissions:api.teamspeak.instanse.statistics.realtime'
		] );
		Route::get( '/teamspeak/instance/group/{group}/statistics/year', [
			'as'    => 'TeamSpeakInstanceStatisticsGroupControllerYear',
			'uses'  => 'TeamSpeakInstanceStatisticsGroupController@Year',
			'where' => [
				'group' => '^[a-zA-Z0-9]+$',
			],
			//'middleware' => 'permissions:api.teamspeak.instanse.statistics.realtime'
		] );

		//endregion
		//////////////////////////////////////////////////////////////////////
		//endregion

		//region Хелперы
		///////////////////////TEAMSPEAK 3 ХЕЛПЕРЫ///////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
		Route::get( '/teamspeak/instance/{server_id}/blacklisted', [
			'as'         => 'TeamSpeakHelpersControllerInstanceIsBlacklisted',
			'uses'       => 'TeamSpeakHelpersController@InstanceIsBlacklisted',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => [
				'permissions:api.teamspeak.instance.blacklisted'
			]
		] );

		Route::get( '/teamspeak/helpers/{ip}/blacklisted', [
			'as'         => 'TeamSpeakHelpersControllerIPv4IsBlacklisted',
			'uses'       => 'TeamSpeakHelpersController@IPv4IsBlacklisted',
			'where'      => [
				'ip' => '^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$',
			],
			'middleware' => [
				'permissions:api.teamspeak.helpers.blacklisted'
			]
		] );

		Route::get( '/teamspeak/helpers/server/update/mirror/list', [
			'as'         => 'TeamSpeakHelpersControllerUpdateServerMirrorList',
			'uses'       => 'TeamSpeakHelpersController@UpdateServerMirrorList',
			'middleware' => [
				'permissions:api.teamspeak.helpers.UpdateMirrorList'
			]
		] );

		Route::get( '/teamspeak/instance/{server_id}/outdated', [
			'as'         => 'TeamSpeakHelpersControllerInstanceOutdatedCheck',
			'uses'       => 'TeamSpeakHelpersController@InstanceOutdatedCheck',
			'where'      => [
				'server_id' => '^\d+$',
			],
			'middleware' => [
				'permissions:api.teamspeak.instance.outdated'
			]
		] );

		//////////////////////////////////////////////////////////////////////
		//endregion

		//region Группы серверов
		/////////////////////////////Группы серверов/////////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
		Route::delete( '/teamspeak/instance/group/{group}', [
			'as'         => 'GroupDelete',
			'uses'       => 'TeamSpeakInstancesGroupController@Delete',
			'where'      => [
				'group' => '^[A-Za-z]+$',
			],
			'middleware' => [ 'permissions:api.teamspeak.instance.group.delete' ]
		] );

		Route::get( '/teamspeak/instance/group', [
			'as'         => 'GroupList',
			'uses'       => 'TeamSpeakInstancesGroupController@List',
			'middleware' => [ 'permissions:api.teamspeak.instance.group.list' ]
		] );

		Route::post( '/teamspeak/instance/group', [
			'as'         => 'GroupCreate',
			'uses'       => 'TeamSpeakInstancesGroupController@Create',
			'middleware' => [ 'permissions:api.teamspeak.instance.group.create' ]
		] );

		Route::get( '/teamspeak/instance/group/{group}', [
			'as'         => 'ServerGroupList',
			'uses'       => 'TeamSpeakInstancesGroupController@ServerGroupList',
			'middleware' => [ 'permissions:api.teamspeak.instance.group.instance.list' ]
		] );

		Route::post( '/teamspeak/instance/group/{group}/{server_id}', [
			'as'         => 'ServerAddGroup',
			'uses'       => 'TeamSpeakInstancesGroupController@ServerAddGroup',
			'where'      => [
				'group'     => '^[A-Za-z]+$',
				'server_id' => '^[0-9]+$',
			],
			'middleware' => [ 'permissions:api.teamspeak.instance.group.instance.add' ]
		] );

		Route::delete( '/teamspeak/instance/group/{group}/{server_id}', [
			'as'         => 'ServerRemoveGroup',
			'uses'       => 'TeamSpeakInstancesGroupController@ServerRemoveGroup',
			'where'      => [
				'group'     => '^[A-Za-z]+$',
				'server_id' => '^[0-9]+$',
			],
			'middleware' => [ 'permissions:api.teamspeak.instance.group.instance.remove' ]
		] );
		////////////////////////////////////////////////////////////////////////
		//endregion

		//endregion

		//region Токены (По ним идентифицируется пользователь)
		/////////////////////////////ТОКЕНЫ/////////////////////////////////////
		/////////////////////////ДОКУМЕНТИРОВАНО/////////////////////////////
		Route::delete( '/token/{token}', [
			'as'         => 'TokenControllerDelete',
			'uses'       => 'TokenController@Delete',
			'where'      => [
				'id' => '^\d+$',
			],
			'middleware' => [
				'permissions:api.token.delete'
			]
		] );
		Route::get( '/token', [
			'as'         => 'TokenControllerList',
			'uses'       => 'TokenController@List',
			'where'      => [
				'id' => '^\d+$',
			],
			'middleware' => [
				'permissions:api.token.list'
			]
		] );
		Route::post( '/token', [
			'as'         => 'TokenControllerCreate',
			'uses'       => 'TokenController@Create',
			'where'      => [
				'id' => '^\d+$',
			],
			'middleware' => [
				'permissions:api.token.create'
			]
		] );
		////////////////////////////////////////////////////////////////////////
		//endregion

		//region Работы с пользователями (локальными)

		Route::delete( '/userid/{user_id}', [
			'as'         => 'TokenControllerDelete',
			'uses'       => 'TokenController@Delete',
			'where'      => [
				'id' => '^\d+$',
			],
			'middleware' => [
				'permissions:api.token.delete'
			]
		] );

		//endregion


	} );
} );

