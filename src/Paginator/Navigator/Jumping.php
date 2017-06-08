<?php
namespace ViewHelper\Paginator\Navigator;

class Jumping
    extends aNavigator
{
    protected $pageRange = 10;


    /**
     * Sliding constructor.
     *
     * @param $pagesCount
     * @param $currentPage
     * @param null $pageRange
     */
    function __construct($pagesCount, $currentPage, $pageRange = null)
    {
        if ($pageRange !== null)
            $this->setPageRange($pageRange);

        parent::__construct($pagesCount, $currentPage);

    }

    /**
     * Get Scrolling Navigation Range
     * exp. [1] [2] [3] .. [5]
     *
     * @return array
     */
    function getScrolling()
    {
        $pageRange  = $this->getPageRange();
        $pageNumber = $this->getCurrentPage();

        $delta = $pageNumber % $pageRange;

        if ($delta == 0)
            $delta = $pageRange;

        $offset     = $pageNumber - $delta;
        $lowerBound = $offset + 1;
        $upperBound = $offset + $pageRange;

        return $this->getScrollingRange($lowerBound, $upperBound);
    }


    // Options

    /**
     * The number of discrete page numbers
     * that will be displayed, including the current page number
     *
     * @param $num
     *
     * @return $this
     */
    function setPageRange($num)
    {
        if ($num = (int) $num < 3)
            throw new \InvalidArgumentException('PageRange cannot be less than 3.');

        $this->pageRange = $num;
        return $this;
    }

    /**
     * Get Total Pages Displayed in Range
     *
     * @return int
     */
    function getPageRange()
    {
        return $this->pageRange;
    }
}