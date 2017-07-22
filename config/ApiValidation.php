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
                'slug' => [
                    'required',
                    'unique:groups',
                    'max:190'
                ],
                'name' => [
                    'required',
                    'max:190'
                ],
            ],
            'messages' => [
                'required' => 'Поле :attribute обязательно к заполнению.',
                'slug.unique' => 'Группа с таким идентификатором уже сушествует',
                'max' => 'В поле :attribute допустимо максимум :max символов (string)',
            ]
        ]
    ],
    'Domain' => [
        'Create' => [
            'rules' => [
                'name' => [
                    'required',
                    'string',
                    "regex:/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])\.$/",
                    'max:255'
                ],
                'kind' => [
                    'required',
                    'string',
                    'in:Master,Native,Slave',
                ],
                'nameservers' => [
                    'required',
                    'array',
                    'min:2'
                ],
                'nameservers.*' => [
                    "regex:/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])\.$/",
                ]
            ],
            'messages' => [
                'name.regex' => 'Ошибка при валидации поля :attribute, проверьте что содержимое поля соответствует RFC (возможно вы забыли точку в конце домена)',
                'kind.in' => 'В поле :attribute допустимы только сдедуюшие значения: masters,native,slave (string)',
                'nameservers.array' => 'В поле nameservers вам необходимо передать массив (array)',
                'nameservers.min' => 'Вам необходимо передать массив содержаший по крайней мере 2 NS сервера (array)',
                'nameservers.*' => 'Ошибка при валидации поля :attribute, проверьте что содержимое поля соответствует RFC (возможно вы забыли точку в конце домена)',
                'required' => 'Поле :attribute обязательно к заполнению.',

            ]
        ],
        'Record' => [
            'Create' => [
                'rules' => [
                    'name' => [
                        'required',
                        'string',
                        "regex:/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])\.$/",
                    ],
                    'type' => [
                        'required',
                        'string',
                        'in:SRV,A,AAAA,CNAME,NS,MX,PTR,TXT',
                    ],
                    'ttl' => [
                        'required',
                        'integer',
                        'min:59',
                        'max:86400'
                    ],
                    'records' => [
                        'required',
                        'array',
                    ],
                    'records.*.content' => [
                        'required',
                        'string',
                        'ip'
                    ],
                    'records.*.disabled' => [
                        'required',
                        'boolean',
                    ],
                ],
                'messages' => [
                    'name.string' => 'Ожидалось что поле :attribute будет строкой (string)',
                    'name.regex' => 'Ошибка при валидации поля :attribute, проверьте что содержимое поля соответствует RFC (возможно вы забыли точку в конце домена)',
                    'type.in' => 'В поле :attribute допустимы только сдедуюшие значения: SRV,A,AAAA,CNAME,NS,MX,PTR,TXT (string)',
                    'type.string' => 'Ожидалось что поле :attribute будет строкой (string)',
                    'ttl.integer' => 'Ожидалось что в поле :attribute будет передано время жизни записи (int)',
                    'ttl.min' => 'Минимальное значение поля :attribute составляет :min (int)',
                    'ttl.max' => 'Максимальное значение поля :attribute составляет :max (int)',
                    'records.*.disabled.boolean' => 'Ожидалось что в поле :attribute будет передано true или false (boolean)',
                    'records.*.content.ip' => 'Ожидалось что в поле :attribute будет передан IP адрес (IPv4 или IPv6)',
                    'records.array' => 'В поле :attribute вам необходимо передать массив (array)',

                    'required' => 'Поле :attribute обязательно к заполнению.',
                ],
            ],
            'Delete' => [
                'rules' => [
                    'name' => [
                        'required',
                        'string',
                        "regex:/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])\.$/",
                    ],
                    'type' => [
                        'required',
                        'string',
                        'in:SRV,A,AAAA,CNAME,NS,MX,PTR,TXT',
                    ],
                    'ttl' => [
                        'required',
                        'integer',
                        'min:59',
                        'max:86400'
                    ],
                    'records' => [
                        'required',
                        'array',
                    ],
                    'records.*.content' => [
                        'required',
                        'string',
                        'ip'
                    ],
                    'records.*.disabled' => [
                        'required',
                        'boolean',
                    ],
                ],
                'messages' => [
                    'name.string' => 'Ожидалось что поле :attribute будет строкой (string)',
                    'name.regex' => 'Ошибка при валидации поля :attribute, проверьте что содержимое поля соответствует RFC (возможно вы забыли точку в конце домена)',
                    'type.in' => 'В поле :attribute допустимы только сдедуюшие значения: SRV,A,AAAA,CNAME,NS,MX,PTR,TXT (string)',
                    'type.string' => 'Ожидалось что поле :attribute будет строкой (string)',
                    'ttl.integer' => 'Ожидалось что в поле :attribute будет передано время жизни записи (int)',
                    'ttl.min' => 'Минимальное значение поля :attribute составляет :min (int)',
                    'ttl.max' => 'Максимальное значение поля :attribute составляет :max (int)',
                    'records.*.disabled.boolean' => 'Ожидалось что в поле :attribute будет передано true или false (boolean)',
                    'records.*.content.ip' => 'Ожидалось что в поле :attribute будет передан IP адрес (IPv4 или IPv6)',
                    'records.array' => 'В поле :attribute вам необходимо передать массив (array)',

                    'required' => 'Поле :attribute обязательно к заполнению.',
                ],
            ]

        ]
    ]

];