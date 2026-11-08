<?php

namespace Modules\Payments\Gateways\Ipag\Model\Collection;

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;

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
