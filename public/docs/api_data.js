define({ "api": [
  {
    "type": "post",
    "url": "/domain",
    "title": "Создать домен",
    "name": "Domain_Add",
    "group": "Domain",
    "version": "1.0.0",
    "description": "<p>Создает домен. <br/><br/> <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/> {<br/>   &quot;domain&quot;:&quot;example04.org.&quot;,<br/>   &quot;kind&quot;:&quot;master&quot;,<br/>   &quot;nameservers&quot;:[<br/>      &quot;ns01.example04.org.&quot;,<br/>      &quot;ns03.example04.org.&quot;<br/>   ]<br/> }</p>",
    "sampleRequest": [
      {
        "url": "/domain"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.domain.add"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/Domain/DomainController.php",
    "groupTitle": "Domain",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "domain/{domain}/record",
    "title": "Создать запись",
    "name": "Domain_Record_Add",
    "group": "Domain",
    "version": "1.0.0",
    "description": "<p>Создает запись для домена. <br/><br/> Возможно создание нескольких записей за 1 запрос <br/><br/> <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/> {<br/>   &quot;0&quot;:{ <br/>     &quot;name&quot;:&quot;ts1&quot;,<br/>     &quot;type&quot;:&quot;A&quot;,<br/>     &quot;ttl&quot;:&quot;60&quot;,<br/>     &quot;records&quot;:[<br/>       {<br/>         &quot;content&quot;:&quot;127.0.0.1&quot;,<br/>         &quot;disabled&quot;:false<br/>       },<br/>       {<br/>         &quot;content&quot;:&quot;127.0.0.2&quot;,<br/>         &quot;disabled&quot;:false<br/>       }<br/>     ]<br/>   }<br/> }<br/></p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.domain.record.add"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/Domain/DomainController.php",
    "groupTitle": "Domain",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "DELETE",
    "url": "domain/{domain}/record",
    "title": "Удалить запись",
    "name": "Domain_Record_Delete",
    "group": "Domain",
    "version": "1.0.0",
    "description": "<p>Удаляет запись домена. <br/><br/> Возможно создание нескольких записей за 1 запрос <br/><br/> <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/> {<br/>   &quot;0&quot;:{ <br/>     &quot;name&quot;:&quot;ts1&quot;,<br/>     &quot;type&quot;:&quot;A&quot;,<br/>     &quot;ttl&quot;:&quot;60&quot;,<br/>     &quot;records&quot;:[<br/>       {<br/>         &quot;content&quot;:&quot;127.0.0.1&quot;,<br/>         &quot;disabled&quot;:false<br/>       },<br/>       {<br/>         &quot;content&quot;:&quot;127.0.0.2&quot;,<br/>         &quot;disabled&quot;:false<br/>       }<br/>     ]<br/>   }<br/> }<br/></p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.domain.record.delete"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/Domain/DomainController.php",
    "groupTitle": "Domain",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/domain",
    "title": "Список доменов",
    "name": "Domain_list",
    "group": "Domain",
    "version": "1.0.0",
    "description": "<p>Возвращает список доменов с которыми можно взаимодействовать.</p>",
    "sampleRequest": [
      {
        "url": "/domain"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       \"example.com\",\n       \"example2.com\"\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.domain.list"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/Domain/DomainController.php",
    "groupTitle": "Domain",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/domain/{domain}/record/formated",
    "title": "Отформатированный список записей домена",
    "name": "Domain_record_formated_list",
    "group": "Domain",
    "version": "1.0.0",
    "description": "<p>Возвращает отформатированный список DNS записей домена</p>",
    "sampleRequest": [
      {
        "url": "/domain/{domain}/record/formated"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "domain",
            "description": "<p>Доменное имя.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": {\n       \"MX\": [\n           {\n               \"name\": \"mx.example.com.\",\n               \"records\": [\n                   {\n                       \"Priority\": \"10\",\n                       \"MailRelay\": \"mail.example.com.\",\n                       \"disabled\": false\n                   }\n               ],\n               \"ttl\": 60,\n               \"comments\": []\n           }\n       ],\n       \"TXT\": [\n           {\n               \"name\": \"text.example.com.\",\n               \"records\": [\n                   {\n                       \"Text\": \"\\\"text\\\"\",\n                       \"disabled\": false\n                   }\n               ],\n               \"ttl\": 60,\n               \"comments\": []\n           }\n       ],\n       \"CNAME\": [\n           {\n               \"name\": \"cname.example.com.\",\n               \"records\": [\n                   {\n                       \"CanonicalName\": \"v4.example.com.\",\n                       \"disabled\": false\n                   }\n               ],\n               \"ttl\": 60,\n               \"comments\": []\n           }\n       ],\n       \"AAAA\": [\n           {\n               \"name\": \"v6.example.com.\",\n               \"records\": [\n                   {\n                       \"ipv6\": \"fd32:4810:8cae:71d9:71d9:71d9:71d9:71d9\",\n                       \"disabled\": false\n                   }\n               ],\n               \"ttl\": 60,\n               \"comments\": []\n           }\n       ],\n       \"PTR\": [\n           {\n               \"name\": \"103.0.3.26.example.com.\",\n               \"records\": [\n                   {\n                       \"HostName\": \"mail.example.com.\",\n                       \"disabled\": false\n                   }\n               ],\n               \"ttl\": 60,\n               \"comments\": []\n           }\n       ],\n       \"SRV\": [\n           {\n               \"name\": \"_ts3._udp.v4.example.com.\",\n               \"records\": [\n                   {\n                       \"Priority\": \"0\",\n                       \"Weight\": \"0\",\n                       \"Port\": \"9987\",\n                       \"Target\": \"v4.example.com.\",\n                       \"disabled\": false\n                   },\n                   {\n                       \"Priority\": \"0\",\n                       \"Weight\": \"0\",\n                       \"Port\": \"9987\",\n                       \"Target\": \"v4.example.com.\",\n                       \"disabled\": false\n                   }\n               ],\n               \"ttl\": 300,\n               \"comments\": []\n           }\n       ],\n       \"A\": [\n           {\n               \"name\": \"v4.example.com.\",\n               \"records\": [\n                   {\n                      \"ipv4\": \"127.0.0.1\",\n                       \"disabled\": false\n                   },\n                   {\n                       \"ipv4\": \"127.0.0.1\",\n                       \"disabled\": false\n                   }\n               ],\n               \"ttl\": 60,\n               \"comments\": []\n           }\n       ],\n       \"SOA\": [\n           {\n               \"name\": \"example.com.\",\n               \"records\": [\n                   {\n                       \"content\": \"ns01.service-voice.com. info.service-voice.com. 2017071382 10800 3600 604800 3600\",\n                      \"disabled\": false\n                   }\n               ],\n               \"ttl\": 60,\n               \"comments\": []\n           }\n       ],\n       \"NS\": [\n           {\n               \"name\": \"example.com.\",\n               \"records\": [\n                   {\n                       \"NameServer\": \"ns01.example.com.\",\n                       \"disabled\": false\n                   }\n               ],\n               \"ttl\": 60,\n               \"comments\": []\n           }\n       ]\n   }\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.domain.record.formated.list"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/Domain/DomainController.php",
    "groupTitle": "Domain",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/domain/:domain/record",
    "title": "Cписок записей домена",
    "name": "Domain_record_list",
    "group": "Domain",
    "version": "1.0.0",
    "description": "<p>Возвращает список DNS записей домена</p>",
    "sampleRequest": [
      {
        "url": "/domain/:domain/record"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "domain",
            "description": "<p>Доменное имя.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n \"status\":\"success\",\n \"data\":[\n   {\n     \"type\":\"MX\",\n     \"name\":\"mx.example.com.\",\n     \"records\":[\n       {\n         \"content\":\"10 mail.example.com.\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":60,\n     \"comments\":[\n\n     ]\n   },\n   {\n     \"type\":\"TXT\",\n     \"name\":\"text.example.com.\",\n     \"records\":[\n       {\n         \"content\":\"\\\"text\\\"\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":60,\n     \"comments\":[\n\n     ]\n   },\n   {\n     \"type\":\"CNAME\",\n     \"name\":\"cname.example.com.\",\n     \"records\":[\n       {\n         \"content\":\"v4.example.com.\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":60,\n     \"comments\":[\n\n     ]\n   },\n   {\n     \"type\":\"AAAA\",\n     \"name\":\"v6.example.com.\",\n     \"records\":[\n       {\n         \"content\":\"fd32:4810:8cae:71d9:71d9:71d9:71d9:71d9\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":60,\n     \"comments\":[\n\n     ]\n   },\n   {\n     \"type\":\"PTR\",\n     \"name\":\"103.0.3.26.example.com.\",\n     \"records\":[\n       {\n         \"content\":\"mail.example.com.\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":60,\n     \"comments\":[\n\n     ]\n   },\n   {\n     \"type\":\"SRV\",\n     \"name\":\"_ts3._udp.v4.example.com.\",\n     \"records\":[\n       {\n         \"content\":\"0 0 9987 v4.example.com.\",\n         \"disabled\":false\n       },\n       {\n         \"content\":\"0 0 9987 v4.example.com.\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":300,\n     \"comments\":[\n\n     ]\n   },\n   {\n     \"type\":\"A\",\n     \"name\":\"v4.example.com.\",\n     \"records\":[\n       {\n         \"content\":\"127.0.0.1\",\n         \"disabled\":false\n       },\n       {\n         \"content\":\"127.0.0.1\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":60,\n     \"comments\":[\n\n     ]\n   },\n   {\n     \"type\":\"SOA\",\n     \"name\":\"example.com.\",\n     \"records\":[\n       {\n         \"content\":\"ns01.service-voice.com. info.service-voice.com. 2017071382 10800 3600 604800 3600\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":60,\n     \"comments\":[\n\n     ]\n   },\n   {\n     \"type\":\"NS\",\n     \"name\":\"example.com.\",\n     \"records\":[\n       {\n         \"content\":\"ns01.example.com.\",\n         \"disabled\":false\n       }\n     ],\n     \"ttl\":60,\n     \"comments\":[\n\n     ]\n   }\n ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.domain.record.list"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/Domain/DomainController.php",
    "groupTitle": "Domain",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/blacklisted",
    "title": "Проверка инстанса на блек/грей лист",
    "name": "Instance_Is_Blacklisted",
    "group": "Helpers",
    "version": "1.0.0",
    "description": "<p>Возврашает код статуса и сообщение.<br/> Возможные варианты:<br/> code - 0 Сервер находиться в blacklist списке. (Нельзя подключиться)<br/> code - 1 Сервер не находится в blacklist или greylist списке.<br/> code - 2 Сервер находиться в greylist списке. (Подключаться можно но будет высплываюшее окошко).<br/></p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/blacklisted"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n \"status\":\"success\",\n \"data\":{\n   \"code\":1,\n   \"message\":\"Сервер не находится в blacklist или greylist списке.\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.instance.blacklisted"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/TeamSpeakHelpers.php",
    "groupTitle": "Helpers",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/outdated",
    "title": "Актуальность инстанса(версия)",
    "name": "Instance_Outdated_Check",
    "group": "Helpers",
    "version": "1.0.0",
    "description": "<p>Сверяет текушую версию и доступную из репозитория (который указан в конфигурации)</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/outdated"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n \"status\":\"success\",\n \"data\":{\n   \"outdated\":false,\n   \"ServerVersion\":\"3.0.13.6\",\n   \"VersionUpdateServer\":\"3.0.13.6\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.instance.outdated"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/TeamSpeakHelpers.php",
    "groupTitle": "Helpers",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/helpers/server/update/mirror/list",
    "title": "Зеркала для обновления сервера",
    "name": "Update_Server_Mirror_List",
    "group": "Helpers",
    "version": "1.0.0",
    "description": "<p>Возврашает набор ссылок для скачивания того или инного варианта teamspeak3 сервера с сервера обновлений(может быть приватный репозиторий).<br/></p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/helpers/server/update/mirror/list"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n \"status\":\"success\",\n \"data\":{\n   \"windows\":{\n     \"x86\":{\n       \"version\":\"3.0.13.6\",\n       \"checksum\":\"f5acf2960685992258a6701ce0cd98aa223bab009321527042e54fd1543b7776\",\n       \"mirrors\":{\n         \"4Netplayers.de\":\"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_win32-3.0.13.6.zip\",\n         \"gamed!de\":\"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_win32-3.0.13.6.zip\"\n       }\n     },\n     \"x86_64\":{\n       \"version\":\"3.0.13.6\",\n       \"checksum\":\"c7eeb1937b0bce0b99e7c7e20de030a4b71adcaf09750481801cfa361433522f\",\n       \"mirrors\":{\n         \"4Netplayers.de\":\"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_win64-3.0.13.6.zip\",\n         \"gamed!de\":\"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_win64-3.0.13.6.zip\"\n       }\n     }\n   },\n   \"macos\":{\n     \"x86_64\":{\n       \"version\":\"3.0.13.6\",\n       \"checksum\":\"cca43b0a4275f6d4270abb2285e76021bc7ebb295be7ec8f2cbdabf4e9b91763\",\n       \"mirrors\":{\n         \"4Netplayers.de\":\"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_mac-3.0.13.6.zip\",\n         \"gamed!de\":\"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_mac-3.0.13.6.zip\"\n       }\n     }\n   },\n   \"linux\":{\n     \"x86\":{\n       \"version\":\"3.0.13.6\",\n       \"checksum\":\"2f70b3e70a3d9bf86106fab67a938922c8d27fec24e66e229913f78a0791b967\",\n       \"mirrors\":{\n         \"4Netplayers.de\":\"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_linux_x86-3.0.13.6.tar.bz2\",\n         \"gamed!de\":\"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_linux_x86-3.0.13.6.tar.bz2\"\n       }\n     },\n     \"x86_64\":{\n       \"version\":\"3.0.13.6\",\n       \"checksum\":\"19ccd8db5427758d972a864b70d4a1263ebb9628fcc42c3de75ba87de105d179\",\n       \"mirrors\":{\n         \"4Netplayers.de\":\"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_linux_amd64-3.0.13.6.tar.bz2\",\n         \"gamed!de\":\"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_linux_amd64-3.0.13.6.tar.bz2\"\n       }\n     }\n   },\n   \"freebsd\":{\n     \"x86\":{\n       \"version\":\"3.0.13.6\",\n       \"checksum\":\"bea0631115395337f1064746ee69cb720c3dd8c176886288b750739193a07e0b\",\n       \"mirrors\":{\n         \"4Netplayers.de\":\"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_freebsd_x86-3.0.13.6.tar.bz2\",\n         \"gamed!de\":\"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_freebsd_x86-3.0.13.6.tar.bz2\"\n       }\n     },\n     \"x86_64\":{\n       \"version\":\"3.0.13.6\",\n       \"checksum\":\"11d24d7d2c1197fec924d2a9fb480f6912f27d489f4a76f4382c5d06735acb53\",\n       \"mirrors\":{\n         \"4Netplayers.de\":\"http://dl.4players.de/ts/releases/3.0.13.6/teamspeak3-server_freebsd_amd64-3.0.13.6.tar.bz2\",\n         \"gamed!de\":\"http://teamspeak.gameserver.gamed.de/ts3/releases/3.0.13.6/teamspeak3-server_freebsd_amd64-3.0.13.6.tar.bz2\"\n       }\n     }\n   }\n }\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.helpers.UpdateMirrorList"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/TeamSpeakHelpers.php",
    "groupTitle": "Helpers",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/helpers/:ip/blacklisted",
    "title": "Проверка ipv4 на блек/грей лист",
    "name": "ipv4_Is_Blacklisted",
    "group": "Helpers",
    "version": "1.0.0",
    "description": "<p>Возврашает код статуса и сообщение.<br/> Возможные варианты:<br/> code - 0 Сервер находиться в blacklist списке. (Нельзя подключиться)<br/> code - 1 Сервер не находится в blacklist или greylist списке.<br/> code - 2 Сервер находиться в greylist списке. (Подключаться можно но будет высплываюшее окошко).<br/></p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/helpers/:ip/blacklisted"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n \"status\":\"success\",\n \"data\":{\n   \"code\":1,\n   \"message\":\"Сервер не находится в blacklist или greylist списке.\"\n }\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.helpers.blacklisted"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/TeamSpeakHelpers.php",
    "groupTitle": "Helpers",
    "error": {
      "fields": {
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/statistics/day",
    "title": "За сутки",
    "name": "Get_Instanse_Statistics_Day",
    "group": "Instance_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по teamspeak3 инстансу (серверу) за сутки по таким параметрам как: <br/> Использовано слотов<br/> Запушено виртуальных серверов<br/> Пользователей онлайн<br/> <br/> При этом данные усредняются за 5 минут.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/statistics/day"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"4000.0000\",\n           \"server_runing\": \"150.0000\",\n           \"user_online\": \"3000.0000\",\n           \"created_at\": \"2017-01-05 20:00:00\"\n       },\n       {\n           \"slot_usage\": \"5000.0000\",\n           \"server_runing\": \"200.0000\",\n           \"user_online\": \"1000.0000\",\n           \"created_at\": \"2017-01-05 20:05:00\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.instanse.statistics.day"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Instance_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/statistics/month",
    "title": "За месяц",
    "name": "Get_Instanse_Statistics_Month",
    "group": "Instance_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по teamspeak3 инстансу (серверу) за месяц по таким параметрам как: <br/> Использовано слотов<br/> Запушено виртуальных серверов<br/> Пользователей онлайн<br/> <br/> При этом данные усредняются за час.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/statistics/month"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"4000.0000\",\n           \"server_runing\": \"150.0000\",\n           \"user_online\": \"3000.0000\",\n           \"created_at\": \"2017-01-05 20:01:46\"\n       },\n       {\n           \"slot_usage\": \"5000.0000\",\n           \"server_runing\": \"200.0000\",\n           \"user_online\": \"1000.0000\",\n           \"created_at\": \"2017-01-05 21:01:46\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.instanse.statistics.month"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Instance_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/statistics/realtime",
    "title": "В реальном времени",
    "name": "Get_Instanse_Statistics_Realtime",
    "group": "Instance_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по teamspeak3 инстансу (серверу) в реальном времени по таким параметрам как: <br/> Использовано слотов<br/> Запушено виртуальных серверов<br/> Пользователей онлайн<br/> <br/> При этом данные не усредняются, но сбор статистики происходит с интервалом в 1 минуту. <br/><br/> Возврашается вся собраная информация за последний час.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/statistics/realtime"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"4000.0000\",\n           \"server_runing\": \"150.0000\",\n           \"user_online\": \"3000.0000\",\n           \"created_at\": \"2017-01-05 20:00:00\"\n       },\n       {\n           \"slot_usage\": \"5000.0000\",\n           \"server_runing\": \"200.0000\",\n           \"user_online\": \"1000.0000\",\n           \"created_at\": \"2017-01-05 20:01:00\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.instanse.statistics.realtime"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Instance_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/statistics/week",
    "title": "За неделю",
    "name": "Get_Instanse_Statistics_Veek",
    "group": "Instance_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по teamspeak3 инстансу (серверу) за неделю по таким параметрам как: <br/> Использовано слотов<br/> Запушено виртуальных серверов<br/> Пользователей онлайн<br/> <br/> При этом данные усредняются за 30 минут.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/statistics/week"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"4000.0000\",\n           \"server_runing\": \"150.0000\",\n           \"user_online\": \"3000.0000\",\n           \"created_at\": \"2017-01-05 20:00:00\"\n       },\n       {\n           \"slot_usage\": \"5000.0000\",\n           \"server_runing\": \"200.0000\",\n           \"user_online\": \"1000.0000\",\n           \"created_at\": \"2017-01-05 20:30:00\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.instanse.statistics.week"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Instance_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/statistics/year",
    "title": "За год",
    "name": "Get_Instanse_Statistics_Year",
    "group": "Instance_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по teamspeak3 инстансу (серверу) за год по таким параметрам как: <br/> Использовано слотов<br/> Запушено виртуальных серверов<br/> Пользователей онлайн<br/> <br/> При этом данные усредняются за сутки.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/statistics/year"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"4000.0000\",\n           \"server_runing\": \"150.0000\",\n           \"user_online\": \"3000.0000\",\n           \"created_at\": \"2017-01-05 20:01:46\"\n       },\n       {\n           \"slot_usage\": \"5000.0000\",\n           \"server_runing\": \"200.0000\",\n           \"user_online\": \"1000.0000\",\n           \"created_at\": \"2017-01-06 20:01:46\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.instanse.statistics.year"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Instance_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot",
    "title": "Создать snapshot",
    "name": "Create_virtual_server_snapshot",
    "group": "Snapshots",
    "version": "1.0.0",
    "description": "<p>Создает снимок (Snapshot) виртуального сервера и возврашает информацию о том была ли успешно выполнена операция</p>",
    "sampleRequest": [
      {
        "url": "/api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.snapshot.create"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Snapshot.php",
    "groupTitle": "Snapshots",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          },
          {
            "group": "Error code 400",
            "optional": false,
            "field": "INVALID_UID",
            "description": "<p>Виртуального сервера с таким UID не сушествует.</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный UID:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"INVALID_UID\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "delete",
    "url": "/api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/:snapshot_id",
    "title": "Удалить snapshot",
    "name": "Delete_virtual_server_snapshot",
    "group": "Snapshots",
    "version": "1.0.0",
    "description": "<p>Удаляет снимок (Snapshot) виртуального сервера и возврашает информацию о том была ли успешно выполнена операция</p>",
    "sampleRequest": [
      {
        "url": "/api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/:snapshot_id"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.snapshot.delete"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Snapshot.php",
    "groupTitle": "Snapshots",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/",
    "title": "Список всех snapshot",
    "name": "Get_list_all_snapshot_virtual_server",
    "group": "Snapshots",
    "version": "1.0.0",
    "description": "<p>Возврашает список снимоков (Snapshot) виртуального сервера</p>",
    "sampleRequest": [
      {
        "url": "/api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          },
          {
            "group": "Success code 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Содержит информацию полученную из базы данных.</p>"
          }
        ],
        "Поля обьекта data": [
          {
            "group": "Поля обьекта data",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>Уникальный идентификатор снимка (Snapshot) виртуального сервера.</p>"
          },
          {
            "group": "Поля обьекта data",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Дата и время создания снапшота.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"id\": 1,\n           \"created_at\": \"2017-07-05 17:48:16\"\n       },\n       {\n           \"id\": 2,\n           \"created_at\": \"2017-07-05 19:37:32\"\n       },\n       {\n           \"id\": 3,\n           \"created_at\": \"2017-07-05 19:38:07\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.snapshot.list"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Snapshot.php",
    "groupTitle": "Snapshots",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/:snapshot_id",
    "title": "Получить snapshot",
    "name": "Get_snapshot_virtual_server_from_id",
    "group": "Snapshots",
    "version": "1.0.0",
    "description": "<p>Возврашает снимок (Snapshot) виртуального сервера</p>",
    "sampleRequest": [
      {
        "url": "/api/teamspeak/instance/:server_id/virtualserver/:bashe64uid/snapshot/:snapshot_id"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "snapshot_id",
            "description": "<p>Уникальный ID снимка (snapshot) виртуального TeamSpeak3 сервера.</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          },
          {
            "group": "Success code 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Содержит информацию полученную из базы данных.</p>"
          }
        ],
        "Поля обьекта data": [
          {
            "group": "Поля обьекта data",
            "type": "String",
            "optional": false,
            "field": "snapshot",
            "description": "<p>Сам снапшот.</p>"
          },
          {
            "group": "Поля обьекта data",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>Дата и время создания снапшота.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n   {\n\"status\":\"success\",\n\"data\":{\n     \"snapshot\":\"hash=kjzIWH0YVgrFEe0sbtxVFHdItGU=|virtualserver_unique_identifier=zNyux21EbZojh3NTqAPXDSvKuYE=.....\",\n     \"created_at\":\"2017-07-05 17:48:16\"\n   }\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.snapshot.get"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Snapshot.php",
    "groupTitle": "Snapshots",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/day",
    "title": "За сутки",
    "name": "Get_VirtualServer_Statistics_Day",
    "group": "Virtual_Server_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по виртуальному серверу за сутки по таким параметрам как: <br/> Использовано слотов<br/> Пользователей онлайн<br/> Средний пинг<br/> Средняя потеря пакетов<br/> <br/> При этом данные усредняются за 5 минут.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/day"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"200.0000\",\n           \"user_online\": \"6000.0000\",\n           \"avg_ping\": 10,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 20:00:46\"\n       },\n       {\n           \"slot_usage\": \"100.0000\",\n           \"user_online\": \"5000.0000\",\n           \"avg_ping\": 20,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 20:05:46\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.statistics.day"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Virtual_Server_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/month",
    "title": "За месяц",
    "name": "Get_VirtualServer_Statistics_Month",
    "group": "Virtual_Server_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по виртуальному серверу за месяц по таким параметрам как: <br/> Использовано слотов<br/> Пользователей онлайн<br/> Средний пинг<br/> Средняя потеря пакетов<br/> <br/> При этом данные усредняются за час.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/month"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"200.0000\",\n           \"user_online\": \"6000.0000\",\n           \"avg_ping\": 10,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 20:01:46\"\n       },\n       {\n           \"slot_usage\": \"100.0000\",\n           \"user_online\": \"5000.0000\",\n           \"avg_ping\": 20,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 21:01:46\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.statistics.month"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Virtual_Server_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/realtime",
    "title": "В реальном времени",
    "name": "Get_VirtualServer_Statistics_Realtime",
    "group": "Virtual_Server_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по виртуальному серверу в реальном времени по таким параметрам как: <br/> Использовано слотов<br/> Пользователей онлайн<br/> Средний пинг<br/> Средняя потеря пакетов<br/> <br/> При этом данные не усредняются, но сбор статистики происходит с интервалом в 1 минуту.<br/><br/> Возврашается вся собраная информация за последний час.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/realtime"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"200.0000\",\n           \"user_online\": \"6000.0000\",\n           \"avg_ping\": 10,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 20:00:46\"\n       },\n       {\n           \"slot_usage\": \"100.0000\",\n           \"user_online\": \"5000.0000\",\n           \"avg_ping\": 20,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 20:01:46\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.statistics.realtime"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Virtual_Server_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/week",
    "title": "За неделю",
    "name": "Get_VirtualServer_Statistics_Week",
    "group": "Virtual_Server_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по виртуальному серверу за неделю по таким параметрам как: <br/> Использовано слотов<br/> Пользователей онлайн<br/> Средний пинг<br/> Средняя потеря пакетов<br/> <br/> При этом данные усредняются за 30 минут.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/week"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"200.0000\",\n           \"user_online\": \"6000.0000\",\n           \"avg_ping\": 10,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 20:01:46\"\n       },\n       {\n           \"slot_usage\": \"100.0000\",\n           \"user_online\": \"5000.0000\",\n           \"avg_ping\": 20,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 20:30:46\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.statistics.week"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Virtual_Server_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/year",
    "title": "За год",
    "name": "Get_VirtualServer_Statistics_Year",
    "group": "Virtual_Server_Statistics",
    "version": "1.0.0",
    "description": "<p>Получить статистику по виртуальному серверу за год по таким параметрам как: <br/> Использовано слотов<br/> Пользователей онлайн<br/> Средний пинг<br/> Средняя потеря пакетов<br/> <br/> При этом данные усредняются за сутки.</p>",
    "sampleRequest": [
      {
        "url": "/teamspeak/instance/:server_id/virtualserver/:bashe64uid/statistics/year"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "server_id",
            "description": "<p>Уникальный ID TeamSpeak3 инстанса в API.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bashe64uid",
            "description": "<p>Уникальный идентификатор виртуального сервера (virtualserver_unique_identifier) закодированный в bashe64</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "X-token",
            "description": "<p>Ваш токен для работы с API.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success code 200": [
          {
            "group": "Success code 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Всегда содержит значение &quot;success&quot;.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Успешно выполненный запрос:",
          "content": "    HTTP/1.1 200 OK\n{\n   \"status\": \"success\",\n   \"data\": [\n       {\n           \"slot_usage\": \"200.0000\",\n           \"user_online\": \"6000.0000\",\n           \"avg_ping\": 10,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-05 20:01:46\"\n       },\n       {\n           \"slot_usage\": \"100.0000\",\n           \"user_online\": \"5000.0000\",\n           \"avg_ping\": 20,\n           \"avg_packetloss\": 0,\n           \"created_at\": \"2017-01-06 20:01:46\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
    "permission": [
      {
        "name": "api.teamspeak.virtualserver.statistics.year"
      }
    ],
    "filename": "/var/www/html/app/Http/Controllers/Api/TeamSpeak/Statistics.php",
    "groupTitle": "Virtual_Server_Statistics",
    "error": {
      "fields": {
        "Error code 404": [
          {
            "group": "Error code 404",
            "optional": false,
            "field": "INVALID_SERVER_ID",
            "description": "<p>Не верный ID сервера (сервера с таким ID не сушествует).</p>"
          }
        ],
        "Error code 504": [
          {
            "group": "Error code 504",
            "optional": false,
            "field": "SOURCE_NOT_AVAILABLE",
            "description": "<p>Источник данных не доступен.</p>"
          }
        ],
        "Error code 400": [
          {
            "group": "Error code 400",
            "optional": false,
            "field": "FIELD_NOT_SPECIFIED",
            "description": "<p>Не заполнено обязательное поле %FIELD% (будет заменено на название поля).</p>"
          }
        ],
        "Error code 403": [
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_IP_ADDRESS",
            "description": "<p>Недопустимый IP-адрес для серверного приложения.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "INVALID_TOKEN",
            "description": "<p>Не верный токен.</p>"
          },
          {
            "group": "Error code 403",
            "optional": false,
            "field": "TOKEN_IS_BLOCKED",
            "description": "<p>Приложение заблокировано администрацией.</p>"
          }
        ],
        "Error code 429": [
          {
            "group": "Error code 429",
            "optional": false,
            "field": "REQUEST_LIMIT_EXCEEDED",
            "description": "<p>Превышен лимит запросов для переданного токена.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Не верный ID сервера:",
          "content": "    HTTP/1.1 404 Not Found\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 404,\n       \"message\": \"INVALID_SERVER_ID\",\n       \"instanse_id\": \"10\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Источник данных не доступен:",
          "content": "    HTTP/1.1 504 Gateway Timeout\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 504,\n       \"message\": \"SOURCE_NOT_AVAILABLE\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не заполнено обязательное поле:",
          "content": "    HTTP/1.1 400 Bad Request\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 400,\n       \"message\": \"X-TOKEN_NOT_SPECIFIED\",\n   }\n}",
          "type": "json"
        },
        {
          "title": "Недопустимый IP-адрес для серверного приложения:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_IP_ADDRESS\",\n       \"Your_IP_Address\": \"127.0.2.5\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Не верный токен:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"INVALID_TOKEN\",\n       \"X-token\": \"zaqqwefabbsdgwertwehsdfhgsfgsbsdghwertqwd\"\n   }\n}",
          "type": "json"
        },
        {
          "title": "Превышен лимит запросов:",
          "content": "    HTTP/1.1 429 Too Many Requests\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 429,\n       \"message\": \"REQUEST_LIMIT_EXCEEDED\",\n       \"retry_after_through\": 14\n   }\n}",
          "type": "json"
        },
        {
          "title": "Приложение заблокировано администрацией:",
          "content": "    HTTP/1.1 403 Forbidden\n{\n   \"status\": \"error\",\n   \"error\": {\n       \"code\": 403,\n       \"message\": \"TOKEN_IS_BLOCKED\",\n   }\n}",
          "type": "json"
        }
      ]
    }
  }
] });
