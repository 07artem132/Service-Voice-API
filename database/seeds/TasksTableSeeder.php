<?php

use Illuminate\Database\Seeder;
use Api\Task;

class TasksTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Task::create( [
			'id'          => 1,
			'priority'    => 1000,
			'class_name'  => 'Api\Task\TeamSpeakInstanceStatisticsCollectionsTask',
			'is_enabled'  => 1,
			'is_periodic' => 1,
			'frequency'   => '* * * * *',
			'name'        => 'Сбор статистики с teamspeak инстансов',
			'description' => '',
			'created_at'  => date( "Y-m-d H:i:s" ),
			'updated_at'  => date( "Y-m-d H:i:s" ),
		] );
		Task::create( [
			'id'          => 2,
			'priority'     => 1001,
			'class_name'  => 'Api\Task\TeamSpeakVirtualServersStatisticsCollectionsTask',
			'is_enabled'  => 1,
			'is_periodic' => 1,
			'frequency'   => '* * * * *',
			'name'        => 'Сбор статистики с виртуальных серверов teamspeak',
			'description' => '',
			'created_at'  => date( "Y-m-d H:i:s" ),
			'updated_at'  => date( "Y-m-d H:i:s" ),
		] );
		Task::create( [
			'id'          => 3,
			'priority'     => 1002,
			'class_name'  => 'Api\Task\TeamSpeakVirtualServerCreateSnapshotTask',
			'is_enabled'  => 1,
			'is_periodic' => 1,
			'frequency'   => '0 */12 * * *',
			'name'        => 'Создание снапшотов всех виртуальных серверов на TeamSpeak 3 инстансах',
			'description' => '',
			'created_at'  => date( "Y-m-d H:i:s" ),
			'updated_at'  => date( "Y-m-d H:i:s" ),
		] );
		Task::create( [
			'id'          => 4,
			'priority'     => 1003,
			'class_name'  => 'Api\Task\TeamSpeakStatisticsInstancesCacheUpdateTask',
			'is_enabled'  => 1,
			'is_periodic' => 1,
			'frequency'   => '* * * * *',
			'name'        => 'Обновление кеша для teamspeak 3 инстансов (статистика)',
			'description' => '',
			'created_at'  => date( "Y-m-d H:i:s" ),
			'updated_at'  => date( "Y-m-d H:i:s" ),
		] );
		Task::create( [
			'id'          => 5,
			'priority'     => 1004,
			'class_name'  => 'Api\Task\TeamSpeakVirtualServerRemoveOldSnapshotTask',
			'is_enabled'  => 1,
			'is_periodic' => 1,
			'frequency'   => '* * * * *',
			'name'        => 'Удаление старых снапшотов',
			'description' => '',
			'created_at'  => date( "Y-m-d H:i:s" ),
			'updated_at'  => date( "Y-m-d H:i:s" ),
		] );
	}
}
