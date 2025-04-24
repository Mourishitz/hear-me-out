<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class PaginationDTO
{
    protected int $page = 1;

    protected int $perPage = 10;

    protected int $total;

    protected int $lastPage = 1;

    protected array $items = [];

    protected array $links = [];

    public function __construct() {}

    public static function fromArray(array $data): self
    {
        $instance = new self;

        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->{$key} = $value;
            }
        }

        return $instance;
    }

    public static function fromRequest(Request $request): self
    {
        $instance = new self;

        $instance->page = (int) $request->get('page', 1);
        $instance->perPage = (int) $request->get('per_page', 10);
        $instance->total = (int) $request->get('total', 0);
        $instance->lastPage = (int) $request->get('last_page', 1);
        $instance->items = (array) $request->get('items', []);
        $instance->links = (array) $request->get('links', []);

        return $instance;
    }

    public function getPagination(): object
    {
        return (object) [
            'page' => $this->getPage(),
            'perPage' => $this->getPerPage(),
            'total' => $this->getTotal(),
            'lastPage' => $this->getLastPage(),
            'items' => $this->getItems(),
            'links' => $this->getLinks(),
        ];
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function setLastPage(int $lastPage): self
    {
        $this->lastPage = $lastPage;

        return $this;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function setLinks(array $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getLinks(): array
    {
        return $this->links;
    }
}
