<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 14:15
 */

return [
    'group' => [
        'Create' => [
            'rules' => [
                'slug' => 'required|unique:groups|max:190',
                'name' => 'required|max:190',
            ],
            'messages' => [
                'required' => 'Поле :attribute обязательно к заполнению.',
                'slug.unique' => 'Группа с таким идентификатором уже сушествует',
                'max' => 'В поле :attribute допустимо максимум :max символов',
            ]
        ]
    ]
];