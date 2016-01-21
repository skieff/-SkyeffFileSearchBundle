<?php

namespace Skyeff\FileSearchBundle;

use Skyeff\FileSearchBundle\DependencyInjection\Compiler\SearchEngineCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SkyeffFileSearchBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SearchEngineCompilerPass());
    }
}
