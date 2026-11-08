<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Payments\Gateways\Ipag\Core;

use Modules\Payments\Gateways\Ipag\Path\CompositePathInterface;
use Modules\Payments\Gateways\Ipag\Util\PathUtil;
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
        throw new UnexpectedValueException("Não se espera que um ambiente tenha um caminho pai.");
    }

    public function getParent(): ?CompositePathInterface
    {
        return null;
    }

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
