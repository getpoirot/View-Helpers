<?php
use Poirot\Ioc\Container\BuildContainer;

/**
 * Registered Actions For ViewHelpers
 * @see \Poirot\Ioc\Container\BuildContainer
 */
return array(
    'services' => array(
        'RenderPagination' => \Module\ViewHelpers\Actions\RenderPagination::class
    ),
);
