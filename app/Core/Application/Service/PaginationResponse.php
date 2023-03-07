<?php

namespace App\Core\Application\Service;

use JsonSerializable;

class PaginationResponse implements JsonSerializable
{
    private array $data;
    private int $page;
    private float $max_page;

    /**
     * @param array $data
     * @param int $page
     * @param float $max_page
     */
    public function __construct(array $data, int $page, float $max_page)
    {
        $this->data = $data;
        $this->page = $page;
        $this->max_page = $max_page;
    }

    public function jsonSerialize(): array
    {
        return [
            "data_per_page" => $this->data,
            "meta" => [
                "page" => $this->page,
                "max_page" => $this->max_page,
            ]
        ];
    }
}
