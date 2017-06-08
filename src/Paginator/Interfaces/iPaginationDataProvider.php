<?php
namespace ViewHelper\Paginator\Interfaces;


interface iPaginationDataProvider
    extends \Countable # We can count total items in data source
{
    /**
     * Get Items Slice From Data Source
     *
     * @param int|string $offset
     * @param int        $limit  Limit count of returned items
     *
     * @return \Traversable
     */
    function getItems($offset, $limit);
}
