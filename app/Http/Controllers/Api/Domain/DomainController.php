<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 11.07.2017
 * Time: 22:47
 */

namespace Api\Http\Controllers;

use Api\Services\Domain\PowerDNS;
use Api\Traits\RestSuccessResponseTrait;
use Api\Traits\RestHelperTrait;
use Request;

/**
 * Class DomainController
 * @package Api\Http\Controllers
 */
class DomainController
{
    use RestSuccessResponseTrait;
    use RestHelperTrait;

    /**
     * @api {get} /domain Список доменов
     * @apiName Domain list
     * @apiGroup Domain
     * @apiVersion 1.0.0
     * @apiDescription Возвращает список доменов с которыми можно взаимодействовать.
     * @apiSampleRequest /domain
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.domain.list
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *    "status": "success",
     *    "data": [
     *        "example.com",
     *        "example2.com"
     *    ]
     *}
     */

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function DomainList()
    {
        $PowerDNS = new PowerDNS();
        $DomainList = $PowerDNS->DomainList();

        return $this->jsonResponse($DomainList);
    }
    /**
     * @api {get} /domain/{domain}/record/formated Отформатированный список записей домена
     * @apiName Domain record formated list
     * @apiGroup Domain
     * @apiVersion 1.0.0
     * @apiDescription Возвращает отформатированный список DNS записей домена
     * @apiSampleRequest /domain/{domain}/record/formated
     * @apiParam {String} domain Доменное имя.
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.domain.record.formated.list
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *    "status": "success",
     *    "data": {
     *        "MX": [
     *            {
     *                "name": "mx.example.com.",
     *                "records": [
     *                    {
     *                        "Priority": "10",
     *                        "MailRelay": "mail.example.com.",
     *                        "disabled": false
     *                    }
     *                ],
     *                "ttl": 60,
     *                "comments": []
     *            }
     *        ],
     *        "TXT": [
     *            {
     *                "name": "text.example.com.",
     *                "records": [
     *                    {
     *                        "Text": "\"text\"",
     *                        "disabled": false
     *                    }
     *                ],
     *                "ttl": 60,
     *                "comments": []
     *            }
     *        ],
     *        "CNAME": [
     *            {
     *                "name": "cname.example.com.",
     *                "records": [
     *                    {
     *                        "CanonicalName": "v4.example.com.",
     *                        "disabled": false
     *                    }
     *                ],
     *                "ttl": 60,
     *                "comments": []
     *            }
     *        ],
     *        "AAAA": [
     *            {
     *                "name": "v6.example.com.",
     *                "records": [
     *                    {
     *                        "ipv6": "fd32:4810:8cae:71d9:71d9:71d9:71d9:71d9",
     *                        "disabled": false
     *                    }
     *                ],
     *                "ttl": 60,
     *                "comments": []
     *            }
     *        ],
     *        "PTR": [
     *            {
     *                "name": "103.0.3.26.example.com.",
     *                "records": [
     *                    {
     *                        "HostName": "mail.example.com.",
     *                        "disabled": false
     *                    }
     *                ],
     *                "ttl": 60,
     *                "comments": []
     *            }
     *        ],
     *        "SRV": [
     *            {
     *                "name": "_ts3._udp.v4.example.com.",
     *                "records": [
     *                    {
     *                        "Priority": "0",
     *                        "Weight": "0",
     *                        "Port": "9987",
     *                        "Target": "v4.example.com.",
     *                        "disabled": false
     *                    },
     *                    {
     *                        "Priority": "0",
     *                        "Weight": "0",
     *                        "Port": "9987",
     *                        "Target": "v4.example.com.",
     *                        "disabled": false
     *                    }
     *                ],
     *                "ttl": 300,
     *                "comments": []
     *            }
     *        ],
     *        "A": [
     *            {
     *                "name": "v4.example.com.",
     *                "records": [
     *                    {
     *                       "ipv4": "127.0.0.1",
     *                        "disabled": false
     *                    },
     *                    {
     *                        "ipv4": "127.0.0.1",
     *                        "disabled": false
     *                    }
     *                ],
     *                "ttl": 60,
     *                "comments": []
     *            }
     *        ],
     *        "SOA": [
     *            {
     *                "name": "example.com.",
     *                "records": [
     *                    {
     *                        "content": "ns01.service-voice.com. info.service-voice.com. 2017071382 10800 3600 604800 3600",
     *                       "disabled": false
     *                    }
     *                ],
     *                "ttl": 60,
     *                "comments": []
     *            }
     *        ],
     *        "NS": [
     *            {
     *                "name": "example.com.",
     *                "records": [
     *                    {
     *                        "NameServer": "ns01.example.com.",
     *                        "disabled": false
     *                    }
     *                ],
     *                "ttl": 60,
     *                "comments": []
     *            }
     *        ]
     *    }
     *}
     */

    /**
     * @param $domain
     * @return \Illuminate\Http\JsonResponse
     */
    function DomainRecordFormatedList($domain)
    {
        $PowerDNS = new PowerDNS();
        $DomainRecordList = $PowerDNS->DomainRecordFormatedList($domain);

        return $this->jsonResponse($DomainRecordList);
    }
    /**
     * @api {get} /domain/:domain/record Cписок записей домена
     * @apiName Domain record list
     * @apiGroup Domain
     * @apiVersion 1.0.0
     * @apiDescription Возвращает список DNS записей домена
     * @apiSampleRequest /domain/:domain/record
     * @apiParam {String} domain Доменное имя.
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.domain.record.list
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *  "status":"success",
     *  "data":[
     *    {
     *      "type":"MX",
     *      "name":"mx.example.com.",
     *      "records":[
     *        {
     *          "content":"10 mail.example.com.",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":60,
     *      "comments":[
     *
     *      ]
     *    },
     *    {
     *      "type":"TXT",
     *      "name":"text.example.com.",
     *      "records":[
     *        {
     *          "content":"\"text\"",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":60,
     *      "comments":[
     *
     *      ]
     *    },
     *    {
     *      "type":"CNAME",
     *      "name":"cname.example.com.",
     *      "records":[
     *        {
     *          "content":"v4.example.com.",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":60,
     *      "comments":[
     *
     *      ]
     *    },
     *    {
     *      "type":"AAAA",
     *      "name":"v6.example.com.",
     *      "records":[
     *        {
     *          "content":"fd32:4810:8cae:71d9:71d9:71d9:71d9:71d9",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":60,
     *      "comments":[
     *
     *      ]
     *    },
     *    {
     *      "type":"PTR",
     *      "name":"103.0.3.26.example.com.",
     *      "records":[
     *        {
     *          "content":"mail.example.com.",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":60,
     *      "comments":[
     *
     *      ]
     *    },
     *    {
     *      "type":"SRV",
     *      "name":"_ts3._udp.v4.example.com.",
     *      "records":[
     *        {
     *          "content":"0 0 9987 v4.example.com.",
     *          "disabled":false
     *        },
     *        {
     *          "content":"0 0 9987 v4.example.com.",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":300,
     *      "comments":[
     *
     *      ]
     *    },
     *    {
     *      "type":"A",
     *      "name":"v4.example.com.",
     *      "records":[
     *        {
     *          "content":"127.0.0.1",
     *          "disabled":false
     *        },
     *        {
     *          "content":"127.0.0.1",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":60,
     *      "comments":[
     *
     *      ]
     *    },
     *    {
     *      "type":"SOA",
     *      "name":"example.com.",
     *      "records":[
     *        {
     *          "content":"ns01.service-voice.com. info.service-voice.com. 2017071382 10800 3600 604800 3600",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":60,
     *      "comments":[
     *
     *      ]
     *    },
     *    {
     *      "type":"NS",
     *      "name":"example.com.",
     *      "records":[
     *        {
     *          "content":"ns01.example.com.",
     *          "disabled":false
     *        }
     *      ],
     *      "ttl":60,
     *      "comments":[
     *
     *      ]
     *    }
     *  ]
     *}
     */
    /**
     * @param $domain
     * @return \Illuminate\Http\JsonResponse
     */
    function DomainRecordList($domain)
    {
        $PowerDNS = new PowerDNS();
        $DomainRecordList = $PowerDNS->DomainRecordList($domain);

        return $this->jsonResponse($DomainRecordList);

    }
    /**
     * @api {post} /domain Создать домен
     * @apiName Domain Add
     * @apiGroup Domain
     * @apiVersion 1.0.0
     * @apiDescription Создает домен. <br/><br/>
     * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
     * {<br/>
     * &nbsp; "domain":"example04.org.",<br/>
     * &nbsp; "kind":"master",<br/>
     * &nbsp; "nameservers":[<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp; "ns01.example04.org.",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp; "ns03.example04.org."<br/>
     * &nbsp;&nbsp;]<br/>
     *}
     * @apiSampleRequest /domain
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.domain.add
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *    "status": "success",
     *}
     */
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    function DomainAdd()
    {
        $json = $this->JsonDecodeAndValidate(Request::getContent(), true);

        $PowerDNS = new PowerDNS();
        $Response = $PowerDNS->DomainCreate($json);

        return $this->jsonResponse($Response);
    }

    /**
     * @api {post} domain/{domain}/record Создать запись
     * @apiName Domain Record Add
     * @apiGroup Domain
     * @apiVersion 1.0.0
     * @apiDescription Создает запись для домена. <br/><br/>
     * Возможно создание нескольких записей за 1 запрос <br/><br/>
     * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
     *{<br/>
     * &nbsp;&nbsp;"0":{ <br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;"name":"ts1",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;"type":"A",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;"ttl":"60",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;"records":[<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content":"127.0.0.1",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"disabled":false<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content":"127.0.0.2",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"disabled":false<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;]<br/>
     * &nbsp;&nbsp;}<br/>
     *}<br/>
     * @apiSampleRequest off
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.domain.record.add
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *    "status": "success",
     *}
     */
    function DomainRecordAdd($domain)
    {
        $json = $this->JsonDecodeAndValidate(Request::getContent(), true);

        $PowerDNS = new PowerDNS();
        $Response = $PowerDNS->DomainRecordCreate($domain, $json);

        return $this->jsonResponse($Response);
    }

    /**
     * @api {DELETE} domain/{domain}/record Удалить запись
     * @apiName Domain Record Delete
     * @apiGroup Domain
     * @apiVersion 1.0.0
     * @apiDescription Удаляет запись домена. <br/><br/>
     * Возможно создание нескольких записей за 1 запрос <br/><br/>
     * <b>При запросе обязательно необходимо передать RAW данные, пример данных</b>:<br/><br/>
     *{<br/>
     * &nbsp;&nbsp;"0":{ <br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;"name":"ts1",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;"type":"A",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;"ttl":"60",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;"records":[<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content":"127.0.0.1",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"disabled":false<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;},<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content":"127.0.0.2",<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"disabled":false<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br/>
     * &nbsp;&nbsp;&nbsp;&nbsp;]<br/>
     * &nbsp;&nbsp;}<br/>
     *}<br/>
     * @apiSampleRequest off
     * @apiHeader {String} X-token Ваш токен для работы с API.
     * @apiSuccess (Success code 200) {String} status  Всегда содержит значение "success".
     * @apiPermission api.domain.record.delete
     * @apiUse INVALID_IP_ADDRESS
     * @apiUse INVALID_TOKEN
     * @apiUse REQUEST_LIMIT_EXCEEDED
     * @apiUse TOKEN_IS_BLOCKED
     * @apiSuccessExample {json} Успешно выполненный запрос:
     *     HTTP/1.1 200 OK
     *{
     *    "status": "success",
     *}
     */
    function DomainRecordDelete($domain)
    {
        $json = $this->JsonDecodeAndValidate(Request::getContent(), true);

        $PowerDNS = new PowerDNS();
        $Response = $PowerDNS->DomainRecordDelete($domain, $json);

        return $this->jsonResponse($Response);
    }
}
