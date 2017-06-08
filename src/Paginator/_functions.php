<?php
namespace ViewHelper\Paginator;

/**
 * Calculates the page count.
 *
 * @param $itemsCount
 * @param $pageSize
 *
 * @return int
 */
function calculatePageCount($itemsCount, $pageSize)
{
    return (int) ceil( $itemsCount / $pageSize );
}

