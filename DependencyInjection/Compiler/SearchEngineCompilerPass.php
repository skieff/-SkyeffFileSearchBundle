<?php

namespace Skyeff\FileSearchBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SearchEngineCompilerPass implements CompilerPassInterface {

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('skyeff_file_search.search_engine_registry')) {
            return;
        }

        $definition = $container->findDefinition('skyeff_file_search.search_engine_registry');

        foreach ($container->findTaggedServiceIds('skyeff_file_search.search_engine') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'addSearchEngine',
                    array(new Reference($id), $attributes['alias'])
                );

            }
        }
    }
}