<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 21.10.2017
 * Time: 21:32
 */

namespace Api\Http\Controllers;

use Cache;
use Api\Group;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Api\StatisticsTeamspeakInstances;
use Api\Traits\RestSuccessResponseTrait;


class TeamSpeakInstanceStatisticsGroupController {

	use RestSuccessResponseTrait;

	/**
	 * @api {get} /v1/teamspeak/instance/group/:group/statistics/year За год
	 * @apiName Get Instanse Group Statistics Year
	 * @apiGroup Instance Group Statistics
	 * @apiVersion 1.0.0
	 * @apiDescription Получить статистику по группе teamspeak3 инстансов (серверов) за год по таким параметрам как: <br/>
	 * Использовано слотов<br/>
	 * Запушено виртуальных серверов<br/>
	 * Пользователей онлайн<br/>
	 * <br/>
	 * При этом данные усредняются за сутки.
	 * @apiSampleRequest /v1/teamspeak/instance/group/:group/statistics/year
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instanse.group.statistics.year
	 * @apiUse INVALID_SERVER_ID
	 * @apiUse SOURCE_NOT_AVAILABLE
	 * @apiUse FIELD_NOT_SPECIFIED
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *    "data": [
	 *        {
	 *            "slot_usage": "4000.0000",
	 *            "server_runing": "150.0000",
	 *            "user_online": "3000.0000",
	 *            "created_at": "2017-01-05 20:01:46"
	 *        },
	 *        {
	 *            "slot_usage": "5000.0000",
	 *            "server_runing": "200.0000",
	 *            "user_online": "1000.0000",
	 *            "created_at": "2017-01-06 20:01:46"
	 *        }
	 *    ]
	 *}
	 */
	/**
	 * @param string $group
	 *
	 * @return JsonResponse
	 */
	function Year( string $group ): JsonResponse {
		$statistics = Cache::remember( 'InstanseStatisticsYearGroup-' . $group, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Group.Year' ) ), function () use ( $group ) {
			$ServerGroupList = Group::Group( $group )->firstOrFail();

			$Instances = $ServerGroupList->TeamspeakInstances->toArray();

			for ( $i = 0; $i < count( $Instances ); $i ++ ) {
				$Instance = $Instances[ $i ]['instance_id'];
				$data[]   = Cache::remember( 'InstanseStatisticsYearServerID-' . $Instance, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Instanse.Year' ) ), function () use ( $Instance ) {
					return StatisticsTeamspeakInstances::InstanceId( $Instance )->StatYear()->DayAvage()->get();
				} )->toArray();
			}

			return $this->MergeStat( $data );
		} );

		return $this->jsonResponse( $statistics );
	}

	/**
	 * @api {get} /v1/teamspeak/instance/group/:group/statistics/month За месяц
	 * @apiName Get Instanse Group Statistics Month
	 * @apiGroup Instance Group Statistics
	 * @apiVersion 1.0.0
	 * @apiDescription Получить статистику по группе teamspeak3 инстансов (серверов) за месяц по таким параметрам как: <br/>
	 * Использовано слотов<br/>
	 * Запушено виртуальных серверов<br/>
	 * Пользователей онлайн<br/>
	 * <br/>
	 * При этом данные усредняются за час.
	 * @apiSampleRequest /v1/teamspeak/instance/group/:group/statistics/month
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instanse.group.statistics.month
	 * @apiUse INVALID_SERVER_ID
	 * @apiUse SOURCE_NOT_AVAILABLE
	 * @apiUse FIELD_NOT_SPECIFIED
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *    "data": [
	 *        {
	 *            "slot_usage": "4000.0000",
	 *            "server_runing": "150.0000",
	 *            "user_online": "3000.0000",
	 *            "created_at": "2017-01-05 20:01:46"
	 *        },
	 *        {
	 *            "slot_usage": "5000.0000",
	 *            "server_runing": "200.0000",
	 *            "user_online": "1000.0000",
	 *            "created_at": "2017-01-05 21:01:46"
	 *        }
	 *    ]
	 *}
	 */
	/**
	 * @param string $group
	 *
	 * @return JsonResponse
	 */
	function Month( string $group ): JsonResponse {
		$statistics = Cache::remember( 'InstanseStatisticsMonthGroup-' . $group, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Group.Month' ) ), function () use ( $group ) {
			$ServerGroupList = Group::Group( $group )->firstOrFail();

			$Instances = $ServerGroupList->TeamspeakInstances->toArray();

			for ( $i = 0; $i < count( $Instances ); $i ++ ) {
				$Instance = $Instances[ $i ]['instance_id'];
				$data[]   = Cache::remember( 'InstanseStatisticsMonthServerID-' . $Instance, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Instanse.Month' ) ), function () use ( $Instance ) {
					return StatisticsTeamspeakInstances::InstanceId( $Instance )->StatMonth()->HourAvage()->get();
				} )->toArray();
			}

			return $this->MergeStat( $data );
		} );

		return $this->jsonResponse( $statistics );
	}

	/**
	 * @api {get} /v1/teamspeak/instance/group/:group/statistics/week За неделю
	 * @apiName Get Instanse Group Statistics Veek
	 * @apiGroup Instance Group Statistics
	 * @apiVersion 1.0.0
	 * @apiDescription Получить статистику по группе teamspeak3 инстансов (серверов) за неделю по таким параметрам как: <br/>
	 * Использовано слотов<br/>
	 * Запушено виртуальных серверов<br/>
	 * Пользователей онлайн<br/>
	 * <br/>
	 * При этом данные усредняются за 30 минут.
	 * @apiSampleRequest /v1/teamspeak/instance/group/:group/statistics/week
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instanse.group.statistics.week
	 * @apiUse INVALID_SERVER_ID
	 * @apiUse SOURCE_NOT_AVAILABLE
	 * @apiUse FIELD_NOT_SPECIFIED
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *    "data": [
	 *        {
	 *            "slot_usage": "4000.0000",
	 *            "server_runing": "150.0000",
	 *            "user_online": "3000.0000",
	 *            "created_at": "2017-01-05 20:00:00"
	 *        },
	 *        {
	 *            "slot_usage": "5000.0000",
	 *            "server_runing": "200.0000",
	 *            "user_online": "1000.0000",
	 *            "created_at": "2017-01-05 20:30:00"
	 *        }
	 *    ]
	 *}
	 */
	/**
	 * @param string $group
	 *
	 * @return JsonResponse
	 */
	function Week( string $group ): JsonResponse {
		$statistics = Cache::remember( 'InstanseStatisticsWeekGroup-' . $group, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Group.Week' ) ), function () use ( $group ) {
			$ServerGroupList = Group::Group( $group )->firstOrFail();

			$Instances = $ServerGroupList->TeamspeakInstances->toArray();

			for ( $i = 0; $i < count( $Instances ); $i ++ ) {
				$Instance = $Instances[ $i ]['instance_id'];
				$data[]   = Cache::remember( 'InstanseStatisticsWeekServerID-' . $Instance, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Instanse.Week' ) ), function () use ( $Instance ) {
					return StatisticsTeamspeakInstances::InstanceId( $Instance )->StatWeek()->HalfHourAvage()->get();
				} )->toArray();
			}

			return $this->MergeStat( $data );
		} );

		return $this->jsonResponse( $statistics );
	}

	/**
	 * @api {get} /v1/teamspeak/instance/group/:group/statistics/day За сутки
	 * @apiName Get Instanse Group Statistics Day
	 * @apiGroup Instance Group Statistics
	 * @apiVersion 1.0.0
	 * @apiDescription Получить статистику по группе teamspeak3 инстансов (серверов) за сутки по таким параметрам как: <br/>
	 * Использовано слотов<br/>
	 * Запушено виртуальных серверов<br/>
	 * Пользователей онлайн<br/>
	 * <br/>
	 * При этом данные усредняются за 5 минут.
	 * @apiSampleRequest /v1/teamspeak/instance/group/:group/statistics/day
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instanse.group.statistics.day
	 * @apiUse INVALID_SERVER_ID
	 * @apiUse SOURCE_NOT_AVAILABLE
	 * @apiUse FIELD_NOT_SPECIFIED
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *    "data": [
	 *        {
	 *            "slot_usage": "4000.0000",
	 *            "server_runing": "150.0000",
	 *            "user_online": "3000.0000",
	 *            "created_at": "2017-01-05 20:00:00"
	 *        },
	 *        {
	 *            "slot_usage": "5000.0000",
	 *            "server_runing": "200.0000",
	 *            "user_online": "1000.0000",
	 *            "created_at": "2017-01-05 20:05:00"
	 *        }
	 *    ]
	 *}
	 */
	/**
	 * @param string $group
	 *
	 * @return JsonResponse
	 */
	function Day( string $group ): JsonResponse {
		$statistics = Cache::remember( 'InstanseStatisticsDayGroup-' . $group, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Group.Day' ) ), function () use ( $group ) {
			$ServerGroupList = Group::Group( $group )->firstOrFail();

			$Instances = $ServerGroupList->TeamspeakInstances->toArray();

			for ( $i = 0; $i < count( $Instances ); $i ++ ) {
				$Instance = $Instances[ $i ]['instance_id'];
				$data[]   = Cache::remember( 'InstanseStatisticsDayServerID-' . $Instance, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Instanse.Day' ) ), function () use ( $Instance ) {
					return StatisticsTeamspeakInstances::InstanceId( $Instance )->StatDay()->FiveMinutesAvage()->get();
				} )->toArray();
			}

			return $this->MergeStat( $data );
		} );

		return $this->jsonResponse( $statistics );
	}

	/**
	 * @api {get} /v1/teamspeak/instance/group/:group/statistics/realtime В реальном времени
	 * @apiName Get Instanse Group Statistics Realtime
	 * @apiGroup Instance Group Statistics
	 * @apiVersion 1.0.0
	 * @apiDescription Получить статистику по группе teamspeak3 инстансов (серверов) в реальном времени по таким параметрам как: <br/>
	 * Использовано слотов <br/>
	 * Запушено виртуальных серверов <br/>
	 * Пользователей онлайн<br/>
	 * <br/>
	 * При этом данные не усредняются, но сбор статистики происходит с интервалом в 1 минуту. <br/><br/>
	 * Возврашается вся собраная информация за последний час.
	 * @apiSampleRequest /v1/teamspeak/instance/group/:group/statistics/realtime
	 * @apiParam {Number} server_id Уникальный ID TeamSpeak3 инстанса в API.
	 * @apiHeader {String} X-token Ваш токен для работы с API.
	 * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
	 * @apiPermission api.teamspeak.instanse.group.statistics.realtime
	 * @apiUse INVALID_SERVER_ID
	 * @apiUse SOURCE_NOT_AVAILABLE
	 * @apiUse FIELD_NOT_SPECIFIED
	 * @apiUse INVALID_IP_ADDRESS
	 * @apiUse INVALID_TOKEN
	 * @apiUse REQUEST_LIMIT_EXCEEDED
	 * @apiUse TOKEN_IS_BLOCKED
	 * @apiSuccessExample {json} Успешно выполненный запрос:
	 *     HTTP/1.1 200 OK
	 *{
	 *    "status": "success",
	 *    "data": [
	 *        {
	 *            "slot_usage": "4000.0000",
	 *            "server_runing": "150.0000",
	 *            "user_online": "3000.0000",
	 *            "created_at": "2017-01-05 20:00:00"
	 *        },
	 *        {
	 *            "slot_usage": "5000.0000",
	 *            "server_runing": "200.0000",
	 *            "user_online": "1000.0000",
	 *            "created_at": "2017-01-05 20:01:00"
	 *        }
	 *    ]
	 *}
	 */
	/**
	 * @param string $group
	 *
	 * @return JsonResponse
	 */
	function Realtime( string $group ): JsonResponse {

		$statistics = Cache::remember( 'InstanseStatisticsRealtimeGroup-' . $group, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Group.Realtime' ) ), function () use ( $group ) {
			$ServerGroupList = Group::Group( $group )->firstOrFail();

			$Instances = $ServerGroupList->TeamspeakInstances->toArray();

			for ( $i = 0; $i < count( $Instances ); $i ++ ) {
				$Instance = $Instances[ $i ]['instance_id'];
				$data[]   = Cache::remember( 'InstanseStatisticsRealtimeServerID-' . $Instance, Carbon::now()->addMinutes( config( 'ApiCache.TeamSpeak.Statistics.Instanse.Realtime' ) ), function () use ( $Instance ) {
					return StatisticsTeamspeakInstances::InstanceId( $Instance )->StatRealtime()->get();
				} )->toArray();
			}

			return $this->MergeStat( $data );
		} );

		return $this->jsonResponse( $statistics );
	}

	function MergeStat( array $data ): array {
		for ( $i = 0, $MaxItem = 0; $i < count( $data ); $i ++ ) {
			if ( count( $data[ $i ] ) > count( $data[ $MaxItem ] ) ) {
				$MaxItem = $i;
			}
		}

		$statistics = $data[ $MaxItem ];
		array_splice( $data, $MaxItem, 1 );

		for ( $i = 0; $i < count( $data ); $i ++ ) {
			for ( $j = 0; $j < count( $statistics ); $j ++ ) {
				for ( $b = 0; $b < count( $data[ $i ] ); $b ++ ) {
					if ( date( "Y-m-d H:i", strtotime( $statistics[ $j ]['created_at'] ) ) === date( "Y-m-d H:i", strtotime( $data[ $i ][ $b ]['created_at'] ) ) ) {
						$statistics[ $j ]['slot_usage']    += $data[ $i ][ $b ]['slot_usage'];
						$statistics[ $j ]['server_runing'] += $data[ $i ][ $b ]['server_runing'];
						$statistics[ $j ]['user_online']   += $data[ $i ][ $b ]['user_online'];
					}
				}
			}
		}

		return $statistics;
	}
}