<?php

namespace App\Core\Application\Service\GetUserList;

class GetUserListRequest
{
    private int $page;
    private int $per_page;
    private ?string $sort;
    private ?string $type;
    private ?array $filter;
    private ?string $search;


    /**
     * @param int $page
     * @param int $per_page
     * @param string|null $sort
     * @param string|null $type
     * @param string|null $filter
     * @param string|null $search
     */
    public function __construct(int $page, int $per_page, ?string $sort, ?string $type, ?array $filter, ?string $search)
    {
        $this->page = $page;
        $this->per_page = $per_page;
        $this->sort = $sort;
        $this->type = $type;
        $this->filter = $filter;
        $this->search = $search;
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

    /**
     * @return string
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getFilter(): ?array
    {
        return $this->filter;
    }

    /**
     * @return string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }
}