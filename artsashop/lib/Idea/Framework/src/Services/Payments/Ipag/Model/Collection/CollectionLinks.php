<?php

namespace Idea\Framework\Services\Payments\Ipag\Model\Collection;

use Idea\Framework\Services\Payments\Ipag\Model\Model;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\Schema;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\SchemaBuilder;

/**
 * CollectionLinks class
 *
 * @codeCoverageIgnore
 */
final class CollectionLinks extends Model
{
    protected function schema(SchemaBuilder $schema): Schema
    {
        $schema->string("first")->nullable();
        $schema->string("last")->nullable();
        $schema->string("prev")->nullable();
        $schema->string("next")->nullable();

        return $schema->build();
    }
}
