<?php

namespace Idea\Framework\Services\Payments\Ipag\Model\Collection;

use Idea\Framework\Services\Payments\Ipag\Model\Model;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\Schema;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\SchemaBuilder;

/**
 * CollectionMeta class
 *
 * @codeCoverageIgnore
 */
final class CollectionMeta extends Model
{
    protected function schema(SchemaBuilder $schema): Schema
    {
        $schema->int("current_page")->nullable();
        $schema->int("last_page")->nullable();
        $schema->int("from")->nullable();
        $schema->int("to")->nullable();
        $schema->int("per_page")->nullable();
        $schema->int("total")->nullable();

        return $schema->build();
    }
}
