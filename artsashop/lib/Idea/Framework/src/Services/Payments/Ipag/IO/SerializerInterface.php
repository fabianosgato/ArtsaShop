<?php

namespace Idea\Framework\Services\Payments\Ipag\IO;

interface SerializerInterface
{
    function serialize(array $data): string;

    function unserialize(string $data): array;

    function getContentType(): ?string;
}
