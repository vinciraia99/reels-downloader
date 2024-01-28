# Instgram Reels Downloader

## Installation

```bash
composer require vinciraia99/instagramreels:dev-main
```


## Usage

```php
<?php

use Instagram\Driver\SnaptikDriver;
use Instagram\VideoDownloader;

require __DIR__.'/vendor/autoload.php';

$reels = new VideoDownloader(new SnaptikDriver());

echo $reels->get('https://www.instagram.com/reel/.......');
```
