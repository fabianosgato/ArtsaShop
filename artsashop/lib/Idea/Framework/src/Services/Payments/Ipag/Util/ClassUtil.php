<?php

namespace Idea\Framework\Services\Payments\Ipag\Util;

abstract class ClassUtil
{
    public static function basename(string $class): string
    {
        return basename(str_replace('\\', '/', $class));
    }
}
