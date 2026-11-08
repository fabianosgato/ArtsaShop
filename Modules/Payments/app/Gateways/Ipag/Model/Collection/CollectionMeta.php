<?php

namespace Modules\Payments\Gateways\Ipag\Model\Collection;

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;

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
