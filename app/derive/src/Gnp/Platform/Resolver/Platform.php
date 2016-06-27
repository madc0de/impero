<?php namespace Gnp\Platform\Resolver;

use Gnp\Platform\Entity\Platforms;
use Pckg\Framework\Provider\RouteResolver;

class Platform implements RouteResolver
{

    public function resolve($value) {
        return (new Platforms())->where('id', $value)->oneOrFail();
    }

    public function parametrize($record) {
        return $record->id;
    }

}