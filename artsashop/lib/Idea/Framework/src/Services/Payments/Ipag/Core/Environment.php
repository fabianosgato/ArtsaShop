<?php

namespace Idea\Framework\Services\Payments\Ipag\Core;

use Idea\Framework\Services\Payments\Ipag\Path\CompositePathInterface;
use Idea\Framework\Services\Payments\Ipag\Util\PathUtil;
use UnexpectedValueException;

abstract class Environment implements CompositePathInterface
{
    protected string $url;

    protected function __construct(string $url)
    {
        $this->url = rtrim($url, PathUtil::PATH_SEPARATOR);
    }

    public function setParent(?CompositePathInterface $parent): void
    {
        throw new UnexpectedValueException("An environment is not supposed to have a parent path");
    }

    public function getParent(): ?CompositePathInterface
    {
        return null;
    }

    //

    public function joinPath(string $relative): string
    {
        return $this->getUrlPath($relative);
    }

    protected function getUrlPath(string $path): string
    {
        return implode(PathUtil::PATH_SEPARATOR, [$this->getBaseUrl(), ltrim($path, PathUtil::PATH_SEPARATOR)]);
    }

    protected function getBaseUrl(): string
    {
        return $this->url;
    }

    public function getPath(): string
    {
        return $this->getUrlPath('');
    }
}
