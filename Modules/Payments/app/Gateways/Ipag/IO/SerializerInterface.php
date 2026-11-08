<?php

namespace Modules\Payments\Gateways\Ipag\IO;

interface SerializerInterface
{
    function serialize(array $data): string;

    function unserialize(string $data): array;

    function getContentType(): ?string;
}
