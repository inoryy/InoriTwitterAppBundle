<?php

namespace Inori\TwitterAppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class InoriTwitterAppExtension extends Extension
{
    protected $resources = array(
        'twitter_app' => 'twitter_app.xml',
    );

    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $this->loadDefaults($container);
        
        if (isset($config['alias'])) {
            $container->setAlias($config['alias'], 'inori_twitter_app');
        }        

        foreach (array('file', 'consumer_key', 'consumer_secret', 'oauth_token', 'oauth_token_secret') as $attribute) {
            if (isset($config[$attribute])) {
                $container->setParameter('inori_twitter_app.'.$attribute, $config[$attribute]);
            }
        }
    }
    
    protected function loadDefaults($container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(array(__DIR__.'/../Resources/config', __DIR__.'/Resources/config')));

        foreach ($this->resources as $resource) {
            $loader->load($resource);
        }
    }
}
