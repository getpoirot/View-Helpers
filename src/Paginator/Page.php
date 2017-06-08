<?php
namespace ViewHelper\Paginator;

use Traversable;


class Page
    implements \Countable
    , \IteratorAggregate
{
    /** @var Traversable */
    protected $items;
    protected $pageNum;


    /**
     * Page constructor.
     *
     * @param int         $pageNum
     * @param Traversable $items
     */
    function __construct($pageNum, \Traversable $items)
    {
        $this->pageNum = (int) $pageNum;
        $this->items   = $items;
    }


    /**
     * Get Page Number
     *
     * @return int
     */
    function getPageNumber()
    {
        return $this->pageNum;
    }


    // Implement Iterator

    /**
     * Retrieve an items for current page
     * @return Traversable
     */
    function getIterator()
    {
        return $this->items;
    }


    // Implement Countable

    /**
     * Count elements on dataSet
     * @return int
     */
    function count()
    {
        $items = $this->items;

        $itemCount = 0;
        if ($items instanceof \Countable)
            $itemCount = count($items);
        elseif ($items instanceof Traversable)
            $itemCount = iterator_count(clone $items);

        return $itemCount;
    }
}
