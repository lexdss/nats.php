<?php

declare(strict_types=1);

namespace Basis\Nats\KeyValue;

class Entry
{
    public function __construct(
        public string $bucket,
        public string $key,
        public mixed $value,
        public int $revision,
    ) {
    }
}
