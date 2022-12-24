<?php

namespace TikTok\Driver;

use Goutte\Client;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use TikTok\Util\Token;

class SnaptikDriver implements DriverInterface
{
    public const CDN_URL = 'https://cdn.snaptik.app/v2';

    private Client $client;

    public function __construct(HttpClientInterface $client = null)
    {
        $this->client = new Client($client);
    }

    public function handle(string $url): string
    {
        $form = $this->client
            ->request('GET', 'https://snaptik.app/vn')
            ->filter('form')
            ->form()
            ->setValues(['url' => $url]);

        $this->client->submit($form);

        /** @var \Symfony\Component\BrowserKit\Response */
        $response = $this->client->getResponse();

        $token = Token::extract($response->getContent());

        if (!$token) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        return sprintf('%s/?token=%s&dl=1', self::CDN_URL, $token);
    }
}
