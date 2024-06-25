<?php
namespace Shibaji\Core;

class Pagination
{
    protected $currentPage;
    protected $perPage;
    protected $totalItems;
    protected $baseUrl;

    /**
     * Pagination constructor.
     *
     * @param int $currentPage The current page number.
     * @param int $perPage Number of items per page.
     * @param int $totalItems Total number of items to paginate.
     * @param string $baseUrl Base URL for pagination links.
     */
    public function __construct($currentPage, $perPage, $totalItems, $baseUrl)
    {
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->totalItems = $totalItems;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Generate HTML for pagination links.
     *
     * @return string HTML for pagination links.
     */
    public function render()
    {
        $totalPages = ceil($this->totalItems / $this->perPage);

        if ($totalPages < 2) {
            return ''; // No pagination needed if only one page
        }

        $html = '<ul class="pagination">';

        // Previous page link
        if ($this->currentPage > 1) {
            $html .= '<li><a href="' . $this->buildUrl($this->currentPage - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
            $html .= '<li class="disabled"><span aria-hidden="true">&laquo;</span></li>';
        }

        // Page links
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $this->currentPage) {
                $html .= '<li class="active"><span>' . $i . '</span></li>';
            } else {
                $html .= '<li><a href="' . $this->buildUrl($i) . '">' . $i . '</a></li>';
            }
        }

        // Next page link
        if ($this->currentPage < $totalPages) {
            $html .= '<li><a href="' . $this->buildUrl($this->currentPage + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        } else {
            $html .= '<li class="disabled"><span aria-hidden="true">&raquo;</span></li>';
        }

        $html .= '</ul>';

        return $html;
    }

    /**
     * Build URL for pagination link with page number.
     *
     * @param int $page Page number.
     * @return string Pagination URL.
     */
    protected function buildUrl($page)
    {
        $query = $_GET;
        $query['page'] = $page;

        return $this->baseUrl . '?' . http_build_query($query);
    }

    /**
     * Get the current page number.
     *
     * @return int Current page number.
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Get the number of items per page.
     *
     * @return int Items per page.
     */
    public function getPerPage()
    {
        return $this->perPage;
    }
}
