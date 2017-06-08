<?php
namespace Module\ViewHelpers\Actions;

use Poirot\Ioc\Container\aContainerCapped;
use ViewHelper\Paginator;


class RenderPagination
{
    protected $defaultNavigator = 'elastic';


    /**
     * Construct
     *
     * @param aContainerCapped $navigatorPlugins @IoC /module/viewHelpers/services/PluginsNavigator
     */
    function __construct(aContainerCapped $navigatorPlugins)
    {
        $this->plugins = $navigatorPlugins;
    }

    /**
     * Render Pagination
     *
     * @param Paginator $paginator
     * @param null $navigatorName
     *
     * @return string
     */
    function __invoke(Paginator $paginator, $navigatorName = null)
    {
        if ($navigatorName === null)
            $navigatorName = $this->defaultNavigator;

        if (! $this->plugins->has($navigatorName))
            throw new \RuntimeException(sprintf(
                'Navigator Plugins (%s) For Pagination Not Found.'
                , $navigatorName
            ));


        $pageCount   = $paginator->countPages();
        $currentPage = $paginator->getCurrPageNum();

        $navigator   = $this->plugins->fresh(
            $navigatorName
            , [ 'options' => [
                'pagesCount'  => $pageCount,
                'currentPage' => $currentPage
            ]]
        );

        kd($navigator);
    }
}
