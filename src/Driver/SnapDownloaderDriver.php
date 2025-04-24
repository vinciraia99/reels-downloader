<?php

namespace Instagram\Driver;

use Instagram\Driver\DriverInterface;
use Instagram\Concern\Crawlable;
use Instagram\Model\Media;
use Instagram\Model\MediaType;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @package Instagram\Driver
 * @implements DriverInterface<string|false>
 * @author Baptiste C <bexet.ms@gmail.com>
 * @copyright 2025 Baptiste C
 */
class SnapDownloaderDriver implements DriverInterface
{
    use Crawlable;

    /**
     * @var string
     */
    public const BASE_URL  = 'https://snapdownloader.com/tools/instagram-reels-downloader/download';

    /**
     * @var int
     */
    private const HTTP_OK = 200;

    /**
     * @param string $url
     * @return array|bool
     */
    public function handle(string $url): array|bool
    {
        try {
            $url = self::BASE_URL . "?url=$url";
            $response = $this->getCurl()->request('GET', $url);

            if ($response->getStatusCode() != self::HTTP_OK) {
                return false;
            }

            $crawler = new Crawler($response->getContent());

            return $crawler->filter('#dlsection .download-item')->each(fn($item) => new Media(
                MediaType::from(strtolower($item->filter('.type div')->text())),
                $item->filter('a')->first()->attr('href'),
            ));
        } catch (\Throwable $_) {
            return false;
        }
    }
}
