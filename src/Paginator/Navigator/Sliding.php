<?php
namespace ViewHelper\Paginator\Navigator;


class Sliding
    extends Jumping
{
    /**
     * Get Scrolling Navigation Range
     * exp. [1] [2] [3] .. [5]
     *
     * @return array
     */
    function getScrolling()
    {
        $pageRange = $this->getPageRange();

        $pageNumber = $this->getCurrentPage();
        $pageCount  = $this->getLast();

        if ($pageRange > $pageCount)
            $pageRange = $pageCount;


        $delta = ceil($pageRange / 2);

        if ($pageNumber - $delta > $pageCount - $pageRange) {
            $lowerBound = $pageCount - $pageRange + 1;
            $upperBound = $pageCount;
        } else {
            if ($pageNumber - $delta < 0)
                $delta = $pageNumber;

            $offset     = $pageNumber - $delta;
            $lowerBound = $offset + 1;
            $upperBound = $offset + $pageRange;
        }

        return $this->getScrollingRange($lowerBound, $upperBound);
    }
}