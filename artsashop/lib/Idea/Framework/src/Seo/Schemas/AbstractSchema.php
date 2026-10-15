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
namespace Idea\Framework\Seo\Schemas;

use Idea\Framework\Seo\Contracts\SeoSchemaContract;

abstract class AbstractSchema implements SeoSchemaContract
{

    abstract public function toArray(): array;

    public function render(): string
    {
        return sprintf(
            '<script type="application/ld+json">%s</script>',
            json_encode(
                $this->toArray(),
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            )
        );
    }

}
