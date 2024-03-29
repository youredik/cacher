<?php

declare(strict_types=1);

require './handler.php';

$event = '{
  "messages": [
    {
      "details": {
        "object_id": "prices/price@ixora-auto.ru/ixora_price.csv"
      }
    }
  ]
}';

$event = json_decode($event, true);

try {
    handler($event, []);
} catch (Exception $e) {
    echo $e->getMessage();
}
