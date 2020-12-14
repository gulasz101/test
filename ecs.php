<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/config', __DIR__ . '/ecs.php']);

    $parameters->set(
        Option::SETS,
        [
            SetList::SPACES,
            SetList::CLEAN_CODE,
            SetList::DEAD_CODE,
            SetList::ARRAY,
            SetList::COMMENTS,
            SetList::STRICT,
            SetList::NAMESPACES,
            SetList::CONTROL_STRUCTURES,
            SetList::PSR_12,
            SetList::PHP_70,
            SetList::PHP_71,
        ]
    );
};