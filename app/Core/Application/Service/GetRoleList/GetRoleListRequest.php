<?php

namespace App\Core\Application\Service\GetRoleList;

class GetRoleListRequest
{
    private int $page;
    private int $per_page;

    /**
     * @param int $page
     * @param int $per_page
     */
    public function __construct(int $page, int $per_page)
    {
        $this->page = $page;
        $this->per_page = $per_page;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->per_page;
    }
}