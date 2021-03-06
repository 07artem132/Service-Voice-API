<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 20.07.2017
 * Time: 14:15
 */

return [
	'group'     => [
		'Create' => [
			'rules'    => [
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
				'required'    => 'Поле :attribute обязательно к заполнению.',
				'slug.unique' => 'Группа с таким идентификатором уже сушествует',
				'max'         => 'В поле :attribute допустимо максимум :max символов (string)',
			]
		]
	],
	'Domain'    => [
		'Create' => [
			'rules'    => [
				'name'          => [
					'required',
					'string',
					"regex:/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])\.$/",
					'max:255'
				],
				'kind'          => [
					'required',
					'string',
					'in:Master,Native,Slave',
				],
				'nameservers'   => [
					'required',
					'array',
					'min:2'
				],
				'nameservers.*' => [
					"regex:/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])\.$/",
				]
			],
			'messages' => [
				'name.regex'        => 'Ошибка при валидации поля :attribute, проверьте что содержимое поля соответствует RFC (возможно вы забыли точку в конце домена)',
				'kind.in'           => 'В поле :attribute допустимы только сдедуюшие значения: masters,native,slave (string)',
				'nameservers.array' => 'В поле nameservers вам необходимо передать массив (array)',
				'nameservers.min'   => 'Вам необходимо передать массив содержаший по крайней мере 2 NS сервера (array)',
				'nameservers.*'     => 'Ошибка при валидации поля :attribute, проверьте что содержимое поля соответствует RFC (возможно вы забыли точку в конце домена)',
				'required'          => 'Поле :attribute обязательно к заполнению.',

			]
		],
		'Record' => [
			'Create' => [
				'rules'    => [
					'name'               => [
						'required',
						'string',
//						"regex:/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])\.$/",
					],
					'type'               => [
						'required',
						'string',
						'in:SRV,A,AAAA,CNAME,NS,MX,PTR,TXT',
					],
					'ttl'                => [
						'required',
						'integer',
						'min:59',
						'max:86400'
					],
					'records'            => [
						'required',
						'array',
					],
					'records.*.content'  => [
						'required',
						'string',
//						'ip'
					],
					'records.*.disabled' => [
						'required',
						'boolean',
					],
				],
				'messages' => [
					'name.string'                => 'Ожидалось что поле :attribute будет строкой (string)',
					'name.regex'                 => 'Ошибка при валидации поля :attribute, проверьте что содержимое поля соответствует RFC (возможно вы забыли точку в конце домена)',
					'type.in'                    => 'В поле :attribute допустимы только сдедуюшие значения: SRV,A,AAAA,CNAME,NS,MX,PTR,TXT (string)',
					'type.string'                => 'Ожидалось что поле :attribute будет строкой (string)',
					'ttl.integer'                => 'Ожидалось что в поле :attribute будет передано время жизни записи (int)',
					'ttl.min'                    => 'Минимальное значение поля :attribute составляет :min (int)',
					'ttl.max'                    => 'Максимальное значение поля :attribute составляет :max (int)',
					'records.*.disabled.boolean' => 'Ожидалось что в поле :attribute будет передано true или false (boolean)',
					'records.*.content.ip'       => 'Ожидалось что в поле :attribute будет передан IP адрес (IPv4 или IPv6)',
					'records.array'              => 'В поле :attribute вам необходимо передать массив (array)',

					'required' => 'Поле :attribute обязательно к заполнению.',
				],
			],
			'Delete' => [
				'rules'    => [
					'name'               => [
						'required',
						'string',
//						"regex:/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])\.$/",
					],
					'type'               => [
						'required',
						'string',
						'in:SRV,A,AAAA,CNAME,NS,MX,PTR,TXT',
					],
					'ttl'                => [
						'required',
						'integer',
						'min:59',
						'max:86400'
					],
					'records'            => [
						'required',
						'array',
					],
					'records.*.content'  => [
						'required',
						'string',
//						'ip'
					],
					'records.*.disabled' => [
						'required',
						'boolean',
					],
				],
				'messages' => [
					'name.string'                => 'Ожидалось что поле :attribute будет строкой (string)',
					'name.regex'                 => 'Ошибка при валидации поля :attribute, проверьте что содержимое поля соответствует RFC (возможно вы забыли точку в конце домена)',
					'type.in'                    => 'В поле :attribute допустимы только сдедуюшие значения: SRV,A,AAAA,CNAME,NS,MX,PTR,TXT (string)',
					'type.string'                => 'Ожидалось что поле :attribute будет строкой (string)',
					'ttl.integer'                => 'Ожидалось что в поле :attribute будет передано время жизни записи (int)',
					'ttl.min'                    => 'Минимальное значение поля :attribute составляет :min (int)',
					'ttl.max'                    => 'Максимальное значение поля :attribute составляет :max (int)',
					'records.*.disabled.boolean' => 'Ожидалось что в поле :attribute будет передано true или false (boolean)',
					'records.*.content.ip'       => 'Ожидалось что в поле :attribute будет передан IP адрес (IPv4 или IPv6)',
					'records.array'              => 'В поле :attribute вам необходимо передать массив (array)',

					'required' => 'Поле :attribute обязательно к заполнению.',
				],
			]

		]
	],
	'TeamSpeak' => [
		'Instance'      => [
			'Edit' => [
				'rules'    => [
					'serverinstance_guest_serverquery_group'       => [
						'integer',
						'filled'
					],
					'serverinstance_template_serveradmin_group'    => [
						'integer',
						'filled'
					],
					'serverinstance_filetransfer_port'             => [
						'integer',
						'filled'
					],
					'serverinstance_max_download_total_bandwitdh'  => [
						'integer',
						'filled'
					],
					'serverinstance_max_upload_total_bandwitdh'    => [
						'integer',
						'filled'
					],
					'serverinstance_template_serverdefault_group'  => [
						'integer',
						'filled'
					],
					'serverinstance_template_channeldefault_group' => [
						'integer',
						'filled'
					],
					'serverinstance_template_channeladmin_group'   => [
						'integer',
						'filled'
					],
					'serverinstance_serverquery_flood_commands'    => [
						'integer',
						'filled'
					],
					'serverinstance_serverquery_flood_time'        => [
						'integer',
						'filled'
					],
					'serverinstance_serverquery_flood_ban_time'    => [
						'integer',
						'filled'
					],
				],
				'messages' => [
					'integer' => 'Ожидалось что в поле :attribute будет передано число (int)',
				],
			]
		],
		'VirtualServer' => [
			'Create'  => [
				'rules'    => [
					'virtualserver_name'                                         => [
						'required',
						'string',
						'max:64',
					],
					'virtualserver_welcomemessage'                               => [
						'string'
					],
					'virtualserver_maxclients'                                   => [
						'required',
						'integer'
					],
					'virtualserver_password'                                     => [
						'string'

					],
					'virtualserver_hostmessage'                                  => [
						'string'

					],
					'virtualserver_hostmessage_mode'                             => [
						'integer',
						'in:1,2,3'
					],
					'virtualserver_default_server_group'                         => [
						'integer'

					],
					'virtualserver_default_channel_group'                        => [
						'integer'

					],
					'virtualserver_default_channel_admin_group'                  => [
						'integer'

					],
					'virtualserver_max_download_total_bandwidth'                 => [
						'integer'

					],
					'virtualserver_max_upload_total_bandwidth'                   => [
						'integer'

					],
					'virtualserver_hostbanner_url'                               => [
						'string'

					],
					'virtualserver_hostbanner_gfx_url'                           => [
						'string'

					],
					'virtualserver_hostbanner_gfx_interval'                      => [
						'integer'

					],
					'virtualserver_complain_autoban_count'                       => [
						'integer'

					],
					'virtualserver_complain_autoban_time'                        => [
						'integer'

					],
					'virtualserver_complain_remove_time'                         => [
						'integer'

					],
					'virtualserver_min_clients_in_channel_before_forced_silence' => [
						'integer'

					],
					'virtualserver_priority_speaker_dimm_modificator'            => [
						'integer'

					],
					'virtualserver_antiflood_points_tick_reduce'                 => [
						'integer'

					],
					'virtualserver_antiflood_points_needed_command_block'        => [
						'integer'

					],
					'virtualserver_antiflood_points_needed_ip_block'             => [
						'integer'

					],
					'virtualserver_hostbanner_mode'                              => [
						'integer'

					],
					'virtualserver_hostbutton_tooltip'                           => [
						'string'

					],
					'virtualserver_hostbutton_gfx_url'                           => [
						'string'

					],
					'virtualserver_hostbutton_url'                               => [
						'string'
					],
					'virtualserver_download_quota'                               => [
						'integer'
					],
					'virtualserver_upload_quota'                                 => [
						'integer'
					],
					'virtualserver_machine_id'                                   => [
						'integer'
					],
					'virtualserver_port'                                         => [
						'integer'
					],
					'virtualserver_autostart'                                    => [
						'integer'
					],
					'virtualserver_log_client'                                   => [
						'integer'
					],
					'virtualserver_log_query'                                    => [
						'integer'
					],
					'virtualserver_log_channel'                                  => [
						'integer'
					],
					'virtualserver_log_permissions'                              => [
						'integer'
					],
					'virtualserver_log_server'                                   => [
						'integer'
					],
					'virtualserver_log_filetransfer'                             => [
						'integer'
					],
					'virtualserver_min_client_version'                           => [
						'integer'
					],
					'virtualserver_needed_identity_security_level'               => [
						'integer'
					],
					'virtualserver_name_phonetic'                                => [
						'string'
					],
					'virtualserver_icon_id'                                      => [
						'integer'
					],
					'virtualserver_reserved_slots'                               => [
						'integer'
					],
					'virtualserver_weblist_enabled'                              => [
						'integer'
					],
					'virtualserver_codec_encryption_mode'                        => [
						'integer'
					],
				],
				'messages' => [
					'max'     => 'Максимальное значение поля :attribute составляет :max (int)',
					'integer' => 'Ожидалось что в поле :attribute будет передано число (int)',
				],
			],
			'Ban'     => [
				'rules'    => [
					'rules'       => [
						'required',
						'array',
						'min:1'
					],
					'rules.name'  => [
						'string',
					],
					'rules.ip'    => [
						'string',
					],
					'rules.uid'   => [
						'string',
					],
					'timeseconds' => [
						'required',
						'integer',
					],
					'reason'      => [
						'required',
						'string',
					]
				],
				'messages' => [
					'array'               => 'В поле :attribute вам необходимо передать массив (array)',
					'rules.min'           => 'Вам необходимо передать массив содержаший по крайней мере 1 правило для бана (array)',
					'required'            => 'Поле :attribute обязательно к заполнению.',
					'timeseconds.integer' => 'Ожидалось что в поле :attribute будет передана длительность бана в секундах (int)',
					'string'              => 'Ожидалось что поле :attribute будет строкой (string)',

				]
			],
			'channel' => [
				'create' => [
					'rules'    => [
						'cpid'                   => [
							'integer',
						],
						'channel_flag_permanent' => [
							'boolean',
						],
						'channel_name'           => [
							'required',
							'string',
						],
						'*'                      => [
							'in_array:' . implode( ',', [
								"channel_name",
								"channel_topic",
								"channel_description",
								"channel_password",
								"channel_codec",
								"channel_codec_quality",
								"channel_maxclients",
								"channel_maxfamilyclients",
								"channel_order",
								"channel_flag_permanent",
								"channel_flag_semi_permanent",
								"channel_flag_temporary",
								"channel_flag_default",
								"channel_flag_maxclients_unlimited",
								"channel_flag_maxfamilyclients_unlimited",
								"channel_flag_maxfamilyclients_inherited",
								"channel_needed_talk_power",
								"channel_name_phonetic",
								"channel_icon_id",
								"channel_codec_is_unencrypted",
								"cpid",
							] ),
						]
					],
					'messages' => [
						'string'     => 'Ожидалось что поле :attribute будет строкой (string)',
						'*.in_array' => 'Не ожидалось что будет передано поле :attribute, просьба проверить документацию.',
						'integer'    => 'Ожидалось что в поле :attribute будет передано число (int)',
					],
				],
				'edit'   => [
					'rules'    => [
						'cpid'                   => [
							'integer',
						],
						'channel_flag_permanent' => [
							'boolean',
						],
						'channel_name'           => [
							'string',
						]
						/*               '*' => [
										   'in_array:' . implode(',', [
											   "channel_name",
											   "channel_topic",
											   "channel_description",
											   "channel_password",
											   "channel_codec",
											   "channel_codec_quality",
											   "channel_maxclients",
											   "channel_maxfamilyclients",
											   "channel_order",
											   "channel_flag_permanent",
											   "channel_flag_semi_permanent",
											   "channel_flag_temporary",
											   "channel_flag_default",
											   "channel_flag_maxclients_unlimited",
											   "channel_flag_maxfamilyclients_unlimited",
											   "channel_flag_maxfamilyclients_inherited",
											   "channel_needed_talk_power",
											   "channel_name_phonetic",
											   "channel_icon_id",
											   "channel_codec_is_unencrypted",
											   "cpid",
										   ]),
										 ]*/
					],
					'messages' => [
						'string'  => 'Ожидалось что поле :attribute будет строкой (string)',
						'integer' => 'Ожидалось что в поле :attribute будет передано число (int)',
					],
				],
				'move'   => [
					'rules'    => [
						'channel_parent_id'  => [
							'required',
							'integer',
						],
						'channel_sort_order' => [
							'required',
							'integer',
						]
					],
					'messages' => [
						'string'  => 'Ожидалось что поле :attribute будет строкой (string)',
						'integer' => 'Ожидалось что в поле :attribute будет передано число (int)',
					],
				],

			],
			'Token'   => [
				'Create' => [
					'rules'    => [
						'groupID'     => [
							'required',
							'integer',
						],
						'description' => [
							'string',
						]
					],
					'messages' => [
						'string'  => 'Ожидалось что поле :attribute будет строкой (string)',
						'integer' => 'Ожидалось что в поле :attribute будет передано число (int)',
					],
				]
			],
		],
	],
	'User'      => [
		'Registration' => [
			'rules'    => [
				'email' => [
					'required',
					"regex:/.+@.+\..+/i",
				],
				'password' => [
					'required',
					'max:30'
				],
			],
			'messages' => [
				'required'    => 'Поле :attribute обязательно к заполнению.',
			]
		]
	]
];