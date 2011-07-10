<?php

namespace Inori\TwitterAppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder,
    Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for the bundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('inori_twitter_app');

        $rootNode
            ->children()
                ->scalarNode('file')->defaultValue('%kernel.root_dir%/../vendor/twitteroauth/twitteroauth/twitteroauth.php')->end()
                ->scalarNode('consumer_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('consumer_secret')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('oauth_token')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('oauth_token_secret')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('alias')->defaultNull()->end()
            ->end()
        ;

        return $treeBuilder;
    }

}

