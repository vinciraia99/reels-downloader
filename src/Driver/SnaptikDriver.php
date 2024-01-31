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

    public const CDN_URL = 'https://cdn.snaptik.app/v2';

    public function handle(string $url)
    {
        $browser = $this->getBrowser();

        $crawler = $browser
            ->request('GET', 'https://snapinsta.app/')
            ->filter('form')
            ->first();

        /** @var \DOMElement */
        $el = $crawler->getNode(0);
        $el->setAttribute('action', '/action2.php');
        $el->setAttribute('method', 'POST');

        $form = $crawler->form()->setValues(['url' => $url]);

        $browser->submit($form);

        /** @var \Symfony\Component\BrowserKit\Response */
        $response = $browser->getResponse();

        $tokens = Token::extract($response->getContent());
        $tokenselect = false;
        for ($i = count($tokens) - 1; $i >= 0; $i--) {
            $token = $tokens[$i];
            if ($this->isMp4(sprintf('%s/?token=%s&dl=1', self::CDN_URL, $token))) {
                $tokenselect = $token;
                break;
            }
        }

        return $tokenselect ? sprintf('%s/?token=%s&dl=1', self::CDN_URL, $tokenselect) : false;
    }

    private function isMp4($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        if(curl_errno($ch)) {
            curl_close($ch);
            return false;
        }
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        return $contentType === 'video/mp4';
    }

}
