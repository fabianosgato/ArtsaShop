<?php

namespace Modules\Payments\Gateways\Ipag\Model\Schema;

use Closure;

/**
 * @codeCoverageIgnore
 */
final class Mutator
{
    public ?Closure $getter;
    public ?Closure $setter;

    public function __construct(?Closure $getter = null, ?Closure $setter = null)
    {
        $this->getter = $getter;
        $this->setter = $setter;
    }
}
