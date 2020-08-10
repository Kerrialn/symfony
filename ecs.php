<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\DisallowLongArraySyntaxSniff;
use PhpCsFixer\Fixer\ArrayNotation\TrailingCommaInMultilineArrayFixer;
use SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\ReferenceUsedNamesOnlySniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Configuration\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(DisallowLongArraySyntaxSniff::class);

    $services->set(TrailingCommaInMultilineArrayFixer::class);

    $services->set(LineLengthFixer::class);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/config', __DIR__ . '/ecs.php']);

    $parameters->set(Option::SETS, [
        SetList::COMMON,
        SetList::CLEAN_CODE,
        SetList::DEAD_CODE,
        SetList::PSR_12,
        SetList::PHP_71,
        SetList::PHP_70,
        SetList::SYMPLIFY,
    ]);

    $parameters->set(Option::SKIP, [
        UnusedPrivateElementsSniff::class . '.' . UnusedPrivateElementsSniff::CODE_UNUSED_PROPERTY => [
            __DIR__ . '/src/Entity/ProjectCheckbox.php',
        ],
        ReferenceUsedNamesOnlySniff::class . '.' . ReferenceUsedNamesOnlySniff::CODE_PARTIAL_USE => [
            __DIR__ . '/config/bundles.php',
        ],
    ]);
};
