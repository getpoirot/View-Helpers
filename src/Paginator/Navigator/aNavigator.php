<?php
namespace ViewHelper\Paginator\Navigator;

use ViewHelper\Paginator;


abstract class aNavigator
{
    protected $pageCount;
    protected $currentPage;


    /**
     * aNavigator constructor.
     *
     * @param $pagesCount
     * @param $currentPage
     */
    function __construct($pagesCount, $currentPage)
    {
        $this->pageCount   = $pagesCount;
        $this->currentPage = $currentPage;
    }


    /**
     * Get Scrolling Navigation Range
     * exp. [1] [2] [3] .. [5]
     *
     * @return array
     */
    abstract function getScrolling();



    function getCurrentPage()
    {
        return $this->currentPage;
    }

    function getPrevious()
    {
        $previous = $this->getCurrentPage() - 1;

        if ($previous <= 0)
            return null;

        return $previous;
    }

    function getNext()
    {
        $next = $this->getCurrentPage() + 1;

        if ($next > $this->getLast())
            return null;

        return $next;
    }

    function getFirst()
    {
        return 1;
    }

    function getLast()
    {
        return $this->pageCount;
    }


    // ..

    protected function getScrollingRange($fromPageNum, $toPageNum)
    {
        $fromPageNum = $this->_normalizePageNumber($fromPageNum);
        $toPageNum   = $this->_normalizePageNumber($toPageNum);

        return range($fromPageNum, $toPageNum);
    }

    private function _normalizePageNumber($pageNum)
    {
        $pageNumber = (int) $pageNum;

        if ($pageNum <= 0)
            $pageNum = 1;

        if ($pageNumber > $this->pageCount)
            $pageNum = $this->pageCount;

        return $pageNum;
    }
}