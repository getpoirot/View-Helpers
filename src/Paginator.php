<?php
namespace ViewHelper;

use Poirot\Std\ConfigurableSetter;
use ViewHelper\Paginator\Interfaces\iPaginationDataProvider;
use ViewHelper\Paginator\Page;


/*
$paginator = new \ViewHelper\Paginator(
    new ProviderCallback(
        function($offset, $perPage) {
            return $this->repoPosts->find([], $offset, $perPage);
        },
        function() {
            return $this->repoPosts->count([]);
        }
    ),
    [
        'page_size'     => 20,
        'curr_page_num' => $page,
    ]
);
*/

class Paginator
    extends ConfigurableSetter
{
    /** @var iPaginationDataProvider */
    protected $data;

    protected $currPageNum  = 1;
    protected $pageSize = 20;


    /**
     * Paginator constructor.
     *
     * @param iPaginationDataProvider $dataProvider
     * @param array|\Traversable      $options
     */
    function __construct($dataProvider, $options = null)
    {
        parent::__construct($options);

        if ($dataProvider !== null)
            $this->setDataProvider($dataProvider);

    }


    /**
     * Get Page Instance By Number
     *
     * - if number not given use current page number
     *
     * @param int|null $pageNum
     *
     * @return Page
     */
    function page($pageNum = null)
    {
        if ($pageNum === null)
            $pageNum = $this->getCurrPageNum();

        $items = $this->_getItemsOfPage($pageNum);
        $page  = new Page($pageNum, $items);

        return $page;
    }


    // Implement Countable

    /**
     * Count The Number Of Pages
     *
     * @return int
     */
    function countPages()
    {
        return $this->_calculatePageCount();
    }

    /**
     * Count Total Items That Must Be Paginated
     *
     * @return int
     */
    function countItems()
    {
        return count($this->data);
    }


    /**
     * Set Data Provider
     *
     * @param iPaginationDataProvider $data
     *
     * @return $this
     */
    protected function setDataProvider(iPaginationDataProvider $data)
    {
        $this->data = $data;
        return $this;
    }


    // Options

    /**
     * Set Items Count Limitation Per Page
     *
     * @param int $num
     *
     * @return $this
     */
    function setPageSize($num)
    {
        $this->pageSize = (int) $num;
        return $this;
    }

    /**
     * Get Limit Per Page
     *
     * @return int
     */
    function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Set Current Page Number
     *
     * @param int $num
     *
     * @return $this
     */
    function setCurrPageNum($num)
    {
        $this->currPageNum = (int) $num;
        return $this;
    }

    /**
     * Get Current Page
     *
     * @return int
     */
    function getCurrPageNum()
    {
        return $this->_normalizePage($this->currPageNum);
    }


    // ..

    /**
     * Returns the items for a given page.
     *
     * @param int $pageNumber
     *
     * @return \Traversable
     */
    private function _getItemsOfPage($pageNumber)
    {
        $pageNumber = $this->_normalizePage($pageNumber);

        $offset     = ($pageNumber - 1) * $this->getPageSize();
        $items      = $this->data->getItems( $offset, $this->getPageSize() );

        return $items;
    }

    /**
     * Calculates the page count.
     * @return int
     */
    private function _calculatePageCount()
    {
        return \ViewHelper\Paginator\calculatePageCount( count($this->data), $this->getPageSize() );
    }

    private function _normalizePage($currentPage)
    {
        if ($currentPage < 1)
            $currentPage = 1;
        elseif ( $currentPage > $total = $this->countPages() )
            $currentPage = $total;

        return $currentPage;
    }
}
