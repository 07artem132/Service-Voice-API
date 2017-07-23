<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'priority' => 1000,
            'class_name' => 'Api\Task\TeamSpeakStatisticsInstances',
            'is_enabled' => 1,
            'is_periodic' => 1,
            'frequency' => '* * * * *',
            'name' => 'Сбор статистики с teamspeak инстансов',
            'description' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        User::create([
            'id' => 2,
            'task_id' => 1001,
            'class_name' => 'Api\Task\TeamSpeakStatisticsVirtualServersInstance',
            'is_enabled' => 1,
            'is_periodic' => 1,
            'frequency' => '* * * * *',
            'name' => 'Сбор статистики с виртуальных серверов teamspeak',
            'description' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        User::create([
            'id' => 3,
            'task_id' => 1002,
            'class_name' => 'Api\Task\TeamSpeakSnapshotsVirtualServers',
            'is_enabled' => 1,
            'is_periodic' => 1,
            'frequency' => '* */12 * * *',
            'name' => 'Создание снапшотов всех виртуальных серверов на TeamSpeak 3 инстансах',
            'description' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}
