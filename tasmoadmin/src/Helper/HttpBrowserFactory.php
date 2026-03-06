<?php

namespace TasmoAdmin\Helper;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use TasmoAdmin\Config;

class HttpBrowserFactory
{
    public static function getClient(Config $config): HttpBrowser
    {
        $options = [
            'timeout' => $config->getTimeout(),
            'max_duration' => $config->getConnectTimeout() + $config->getTimeout(),
            'headers' => [
                'User-Agent' => "TasmoAdmin/{$config->read('current_git_tag')}",
            ],
            // Prefer IPv4 to avoid environments with broken outbound IPv6 paths.
            'bindto' => '0.0.0.0:0',
        ];

        return new HttpBrowser(HttpClient::create($options));
    }
}
