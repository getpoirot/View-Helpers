<?php
namespace Module\ViewHelpers\Services;

use Module\ViewHelpers\Plugins\PluginsNavigator;
use Poirot\Ioc\Container\Service\aServiceContainer;


class ServicePluginsNavigator
    extends aServiceContainer
{

    /**
     * Create Service
     *
     * @return mixed
     */
    function newService()
    {
        return new PluginsNavigator();
    }
}
