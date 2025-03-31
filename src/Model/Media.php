<?php

namespace Instagram\Model;

/**
 * @package Instagram\Driver
 * @author Baptiste C <bexet.ms@gmail.com>
 * @copyright 2025 Baptiste C
 */
class Media
{
    /**
     * @param \Instagram\Model\MediaType $mediaType
     * @param string $url
     */
    public function __construct(
        private MediaType   $mediaType  = MediaType::IMAGE,
        private string      $url        = '',
    ) {
    }

    /**
     * @return MediaType
     */
    public function getMediaType(): MediaType
    {
        return $this->mediaType;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param \Instagram\Model\MediaType $mediaType
     * @return void
     */
    public function setMediaType(MediaType $mediaType): void
    {
        $this->mediaType = $mediaType;
    }

    /**
     * @param string $url
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
