<?php

namespace Instagram\Concern;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\CurlHttpClient;

trait Crawlable
{
    public function getBrowser(): HttpBrowser
    {
        static $browser = null;
        if (null === $browser) {
            $browser = new HttpBrowser();
        }

        return $browser;
    }

    /**
     * @return CurlHttpClient
     */
    public function getCurl(): CurlHttpClient
    {
        static $curl = null;
        $curl ??= new CurlHttpClient();
        return $curl;
    }
}
