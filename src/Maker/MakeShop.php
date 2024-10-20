<?php

namespace Devway\GenericShop\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use function Symfony\Component\String\u;

final class MakeShop extends AbstractMaker
{
    private array $shopClasses = [
        'entities' => [
            'Category',
            'BaseProduct',
            'UnitOfMeasure',
            'Property',
            'BaseProductProperty',
            'Product',
            'AdditionnalOption',
            'ProductAdditionnalOption'
        ],
        'repositories' => [
            'CategoryRepository',
            'BaseProductRepository',
            'UnitOfMeasureRepository',
            'PropertyRepository',
            'BaseProductPropertyRepository',
            'ProductRepository',
            'AdditionnalOptionRepository',
            'ProductAdditionnalOptionRepository'
        ],
        'controllers' => [
            'ShopController'
        ],
        'templates' => [
            'shop/public/shop_base',
            'shop/public/index',
            'shop/public/category',
            'shop/public/product',
            'shop/public/cart',
            'shop/public/checkout',
            'shop/user/order_placed',
            'shop/user/order_error',
            'shop/components/public/product_preview',
            'shop/components/public/category_preview',
        ]
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
        $io->title('Devway\'s Shop Maker');

        $shopType = $io->choice(
            'What kind of shop do you want ?',
            [
                'Full Shop',
                'Shop with delivery only',
                'Shop click & collect only',
                'Catalogue',
            ],
            'Full Shop'
        );

        $useBundleShopTemplates = $io->choice(
            'Do you want to use our twig templates ? (designed with Tailwind)',
            [
                'no',
                'yes'
            ],
            'yes'
        );

        $shopManagment = $io->choice(
            'How do you want to administrate the shop ?',
            [
                'By myself',
                'With EasyAdmin'
            ],
            'With EasyAdmin'
        );

        $io->note('The entities "Category", "Product", "UnitOfMeasure", "Attribute", "Option" and related repositories will be generated. We also generate ShopController and shop templates. If you have to or already use one of these names, you MUST prefix shop entities.');

        $entityPrefix = $io->ask(
            'Wich prefix to use for shop entities ? ( press return to use no prefix )',
            '',
            fn (string $prefix): string => u($prefix)->camel()->trim()->toString()
        );

        foreach ( $this->shopClasses['entities'] as $entity )
        {
            if( file_exists( __DIR__ . '/resources/entity/' .$entity.'.tpl.php' ) )
            {
                $generator->generateClass(
                    'App\\Entity\\'.$entity,
                    __DIR__ . '/resources/entity/' .$entity.'.tpl.php'
                );

                $generator->writeChanges();
            }
        }

        foreach ( $this->shopClasses['repositories'] as $repository )
        {
            if( file_exists(__DIR__ . '/resources/repository/' .$repository.'.tpl.php') )
            {
                $generator->generateClass(
                    'App\\Repository\\'.$repository,
                    __DIR__ . '/resources/repository/' .$repository.'.tpl.php'
                );

                $generator->writeChanges();
            }
        }

        foreach ( $this->shopClasses['controllers'] as $controller )
        {
            if( file_exists(__DIR__ . '/resources/controller/' .$controller.'.tpl.php') )
            {
                $generator->generateClass(
                    'App\\Controller\\'.$controller,
                    __DIR__ . '/resources/controller/'.$controller.'.tpl.php'
                );

                $generator->writeChanges();
            }
        }

        $this->writeSuccessMessage($io);
        $io->info("What's next ?");
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }
}
