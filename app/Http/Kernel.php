<?php

namespace Api\Http;

use GuzzleHttp\Middleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Api\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Api\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Api\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'TokenVerifi',
            'CheckBlockedToken',
            'TokenVerifiAllowIP',
            'LimitRequestAPP',
            'ApiLog',
            'bindings',
            // 'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        /**
         * Логируем запрос к API
         */
        'ApiLog' => \Api\Http\Middleware\ApiLog::class,
        /**
         * Возвращает пользователя на предыдущую страницу
         */
        'guest.redirect.back' => \Api\Http\Middleware\RedirectIfNotAuthenticated::class,
        /**
         * Подтверждаем что пользователь гость
         */
        'guest.true' => \Api\Http\Middleware\NotAuthenticated::class,
        /**
         * Проверяем есть ли у пользователя необходимые привелегии
         */
        'permissions' => \Api\Http\Middleware\CheckPermissions::class,
        /**
         * Проверяем есть ли токен в базе данных
         */
        'TokenVerifi' => \Api\Http\Middleware\TokenVerifi::class,
        /**
         * Проверяем есть ли у токена права на работу с переданным в url сервером или виртуальным teamspeak 3 сервером
         */
        'TokenVerifiTeamspeakVirtualServersAllow' => \Api\Http\Middleware\TokenVerifiTeamSpeakVitrualServerAllow::class,
        /**
         * Проверяем есть ли у токена права на работу с переданным в url сервером или виртуальным teamspeak 3 сервером
         */
        'TokenVerifiTeamSpeakServerAllow' => \Api\Http\Middleware\TokenVerifiTeamSpeakServerAllow::class,
        /**
         * Проверяем разрешено ли использование токена с этого IP адреса
         */
        'TokenVerifiAllowIP' => \Api\Http\Middleware\TokenVerifiAllowIP::class,
        /**
         * Ограничиваем кол-во запросов в минуту для приложения
         */
        'LimitRequestAPP' => \Api\Http\Middleware\LimitRequestAPP::class,
        /**
         * Проверяем не заблокировано ли приложение
         */
        'CheckBlockedToken' => \Api\Http\Middleware\CheckBlockedToken::class,
    ];
}
