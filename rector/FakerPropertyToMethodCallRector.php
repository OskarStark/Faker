<?php

declare(strict_types=1);

/*
 * This file is part of the Faker package.
 *
 * (c) Oskar Stark <oskarstark@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Faker\Rector;

use Faker\Generator;
use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PHPStan\Type\ObjectType;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class FakerPropertyToMethodCallRector extends AbstractRector implements ConfigurableRectorInterface
{
    /**
     * @var list<string>
     */
    private array $propertyNames = [];

    /**
     * @param array<mixed> $configuration
     */
    public function configure(array $configuration): void
    {
        $this->propertyNames = array_values(array_filter($configuration, 'is_string'));
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replaces deprecated Faker property access with method calls',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
$faker->name;
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
$faker->name();
CODE_SAMPLE
                    ,
                    ['name', 'email', 'address'],
                ),
            ],
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [PropertyFetch::class];
    }

    /**
     * @param PropertyFetch $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$node->name instanceof Identifier) {
            return null;
        }

        $propertyName = $node->name->toString();

        if (!\in_array($propertyName, $this->propertyNames, true)) {
            return null;
        }

        if (!$this->isObjectType($node->var, new ObjectType(Generator::class))) {
            return null;
        }

        return $this->nodeFactory->createMethodCall($node->var, $propertyName);
    }
}
