<?php
namespace ViewHelper\Paginator\Navigator;

class All
    extends aNavigator
{
    /**
     * Get Scrolling Navigation Range
     * exp. [1] [2] [3] .. [5]
     *
     * @return array
     */
    function getScrolling()
    {
        return $this->getScrollingRange($this->getFirst(), $this->getLast() );
    }
}
