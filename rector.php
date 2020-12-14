<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        SetList::DEAD_CODE,
    ]);

    // get services (needed for register a single rule)
     $services = $containerConfigurator->services();

     // SOLID
     $services->set(\Rector\SOLID\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector::class);
//     $services->set();
    // 7.2
    $services->set(\Rector\Php72\Rector\FuncCall\StringifyDefineRector::class);
//     $services->set();
    // 7.3
    $services->set(\Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector::class);
    $services->set(\Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector::class);
    // 7.4
    $services->set(TypedPropertyRector::class);
    $services->set(\Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector::class);
    $services->set(\Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector::class);
//     $services->set();
};
