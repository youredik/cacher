<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Aws\S3\S3Client;

function handler($event, $context): array
{
    $objectId = $event['messages'][0]['details']['object_id'];
    $cacheFile = getenv('PRICES_FOLDER') . '/' . dirname($objectId) . '/cache.json';

    if (file_exists($cacheFile)) {
        $content = file_get_contents($cacheFile);
        $content = json_decode($content, true);
        $content[] = $objectId;
    } else {
        $content = [$objectId];
    }

    $s3 = new S3Client([
        'version' => 'latest',
        'endpoint' => 'https://storage.yandexcloud.net',
        'region' => 'ru-central1',
    ]);

    $s3->upload('parts', $cacheFile, json_encode($content), 'public-read');

    return [
        'statusCode' => 200,
        'body' => '',
    ];
}