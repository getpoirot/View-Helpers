<?php
namespace Module\ViewHelpers\Actions;

use Poirot\Ioc\Container\aContainerCapped;
use ViewHelper\Paginator;


class RenderPagination
{
    protected $navigator;
    protected $defaultNavigator = 'sliding';


    /**
     * Construct
     *
     * @param aContainerCapped $navigatorPlugins @IoC /module/viewHelpers/services/PluginsNavigator
     */
    function __construct(aContainerCapped $navigatorPlugins)
    {
        $this->plugins = $navigatorPlugins;
    }


    function __invoke()
    {
        return $this;
    }

    /**
     * Retrieve Navigator
     *
     * @param Paginator $paginator
     * @param null $navigatorName
     *
     * @return RenderPagination
     */
    function withPaginator(Paginator $paginator, $navigatorName = null)
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
            , [
                'pagesCount'  => $pageCount,
                'currentPage' => $currentPage
            ]
        );

        $new = clone $this;
        $new->navigator = $navigator;
        return $new;
    }

    /**
     * Render
     *
     * @param string $template
     *
     * @return string
     * @throws \Exception
     */
    function render($template)
    {
        if (! $this->navigator)
            throw new \Exception('No Navigator.');

        $view = \Module\Foundation\Actions::view($template, ['navigator' => $this->navigator]);
        return $view->render();
    }
}
