<?php
namespace ViewHelper;

use Poirot\Std\ConfigurableSetter;
use ViewHelper\Paginator\Interfaces\iPaginationDataProvider;
use ViewHelper\Paginator\Page;


class Paginator
    extends ConfigurableSetter
{
    /** @var iPaginationDataProvider */
    protected $data;

    protected $currentPageNumber  = 1;
    protected $limitPerPage = 20;


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
            $pageNum = $this->getCurrentPageNumber();

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
    function setLimitPerPage($num)
    {
        $this->limitPerPage = (int) $num;
        return $this;
    }

    /**
     * Get Limit Per Page
     *
     * @return int
     */
    function getLimitPerPage()
    {
        return $this->limitPerPage;
    }

    /**
     * Set Current Page Number
     *
     * @param int $num
     *
     * @return $this
     */
    function setCurrentPageNumber($num)
    {
        $this->currentPageNumber = (int) $num;
        return $this;
    }

    /**
     * Get Current Page
     *
     * @return int
     */
    function getCurrentPageNumber()
    {
        return $this->_normalizePage($this->currentPageNumber);
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

        $offset     = ($pageNumber - 1) * $this->getLimitPerPage();
        $items      = $this->data->getItems( $offset, $this->getLimitPerPage() );

        return $items;
    }

    /**
     * Calculates the page count.
     * @return int
     */
    private function _calculatePageCount()
    {
        return \ViewHelper\Paginator\calculatePageCount( count($this->data), $this->getLimitPerPage() );
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
