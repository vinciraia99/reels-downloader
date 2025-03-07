<?php

namespace Instagram\Driver;

use Instagram\Concern\Crawlable;
use Instagram\Util\Token;

/**
 * @implements DriverInterface<string|false>
 */
class SnaptikDriver implements DriverInterface
{
    use Crawlable;

    public const CDN_URL = 'https://d.rapidcdn.app';

    public function handle(string $url)
    {
        $browser = $this->getBrowser();

        $crawler = $browser
            ->request('GET', 'https://snapinsta.app/')
            ->filter('form')
            ->first();

        /** @var \DOMElement */
        $el = $crawler->getNode(0);
        $el->setAttribute('action', '/get-data.php');
        $el->setAttribute('method', 'POST');

        $form = $crawler->form()->setValues(['url' => $url]);

        $browser->submit($form);

        /** @var \Symfony\Component\BrowserKit\Response */
        $response = $browser->getResponse();

        //$token = Token::extract($response->getContent());

        //return $token ? sprintf('%s/?token=%s&dl=1', self::CDN_URL, $token) : false;

        $json = json_decode($response->getContent(),true);
        return $json["files"][0]["video_url"];
    }

}
