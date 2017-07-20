<?php

use Illuminate\Database\Seeder;

class TasksStatusTableSeeder extends Seeder
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
            'task_id' => 1,
            'in_progress' => 0,
            'last_run' => date("Y-m-d H:i:s"),
            'next_due' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        User::create([
            'id' => 2,
            'task_id' => 2,
            'in_progress' => 0,
            'last_run' => date("Y-m-d H:i:s"),
            'next_due' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        User::create([
            'id' => 3,
            'task_id' => 3,
            'in_progress' => 0,
            'last_run' => date("Y-m-d H:i:s"),
            'next_due' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
