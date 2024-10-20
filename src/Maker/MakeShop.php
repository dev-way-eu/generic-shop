<?php

namespace Devway\GenericShop\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\MakerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

final class MakeShop extends AbstractMaker implements MakerInterface
{
    private array $shopClasses = [
        'entities' => [ 'Category', 'Product', 'UnitOfMeasure' ,'Attribute', 'ProductAttribute', 'Variant', 'Option', 'ProductOption' ],
        'repositories' => [ 'CategoryRepository', 'ProductRepository', 'UnitOfMeasureRepository' ,'AttributeRepository', 'ProductAttributeRepository', 'VariantRepository', 'OptionRepository', 'ProductOptionRepository' ],
        'controllers' => [ 'ShopController' ]
    ];

    public static function getCommandName(): string
    {
        return 'make:shop';
    }

    public static function getCommandDescription(): string
    {
        return 'Create shop entities, repositories, and controller';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command->setHelp(file_get_contents(__DIR__ . '/MakeShop.txt'));
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        foreach ( $this->shopClasses['entities'] as $entity )
        {
            if( file_exists( __DIR__ . 'MakeShop.php/' .$entity.'.tpl.php' ) )
            {
                $generator->generateClass(
                    'App\Entity\\'.$entity,
                    __DIR__ . 'MakeShop.php/' .$entity.'.tpl.php'
                );

                $generator->writeChanges();
            }
        }

        foreach ( $this->shopClasses['repositories'] as $repository )
        {
            if( file_exists(__DIR__ . 'MakeShop.php/' .$repository.'.tpl.php') )
            {
                $generator->generateClass(
                    'App\Entity\\'.$repository,
                    __DIR__ . 'MakeShop.php/' .$repository.'.tpl.php'
                );

                $generator->writeChanges();
            }
        }

        foreach ( $this->shopClasses['controllers'] as $controller )
        {
            if( file_exists(__DIR__ . 'MakeShop.php/' .$controller.'.tpl.php') )
            {
                $generator->generateClass(
                    'App\Entity\\'.$controller,
                    __DIR__ . 'MakeShop.php/' .$controller.'.tpl.php'
                );

                $generator->writeChanges();
            }
        }

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }
}
