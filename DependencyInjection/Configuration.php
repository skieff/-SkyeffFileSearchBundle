<?php

namespace Skyeff\FileSearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('skyeff_file_search');

        $rootNode
            ->children()
                ->scalarNode('default_engine')->isRequired()->cannotBeEmpty()->defaultValue('basic')->end()
                ->arrayNode('lookup_dir_list')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()
                ->end()
                ->integerNode('max_allowed_file_size')->isRequired()->min(1)->defaultValue(1000000)->end()
                ->arrayNode('search_engine')
                    ->children()
                        ->arrayNode('grep')
                            ->children()
                                ->scalarNode('binary')->isRequired()->cannotBeEmpty()->defaultValue('/bin/grep')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
