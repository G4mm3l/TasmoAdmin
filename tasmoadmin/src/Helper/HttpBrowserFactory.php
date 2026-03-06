<?php

namespace TasmoAdmin\Helper;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use TasmoAdmin\Config;

class HttpBrowserFactory
{
    private const MIN_CONNECT_TIMEOUT = 10;

    private const MIN_TIMEOUT = 30;

    public static function getClient(Config $config): HttpBrowser
    {
        $connectTimeout = max($config->getConnectTimeout(), self::MIN_CONNECT_TIMEOUT);
        $timeout = max($config->getTimeout(), self::MIN_TIMEOUT);

        $options = [
            'timeout' => $timeout,
            'max_duration' => $connectTimeout + $timeout,
            'headers' => [
                'User-Agent' => "TasmoAdmin/{$config->read('current_git_tag')}",
            ],
            // Prefer IPv4 to avoid environments with broken outbound IPv6 paths.
            'bindto' => '0.0.0.0:0',
        ];

        return new HttpBrowser(HttpClient::create($options));
    }
}
