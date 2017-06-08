<?php
namespace ViewHelper\Paginator\DataProvider;

use ViewHelper\Paginator\Interfaces\iPaginationDataProvider;


class ProviderCallback
    implements iPaginationDataProvider
{
    protected $dataCallable;
    protected $countCallable;


    /**
     * ProviderCallback constructor.
     *
     * @param callable $dataCallable
     * @param callable $countCallable
     */
    function __construct(callable $dataCallable, callable $countCallable)
    {
        $this->dataCallable  = $dataCallable;
        $this->countCallable = $countCallable;

    }


    /**
     * Get Items Slice From Data Source
     *
     * @param int|string $offset
     * @param int $limit Limit count of returned items
     *
     * @return \Traversable
     */
    function getItems($offset, $limit)
    {
        return call_user_func($this->dataCallable, $offset, $limit);
    }

    /**
     * Count elements of an object
     * @return int The custom count as an integer.
     */
    function count()
    {
        return call_user_func($this->countCallable);
    }
}
