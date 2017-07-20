<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('TasksTableSeeder');
        $this->command->info('Таблица с задачами успешно заполнена!');

        $this->call('TasksStatusTableSeeder');
        $this->command->info('Таблица со статусом задач успешно заполнена!');
    }
}
