<?php

declare(strict_types=1);

namespace Symfobooster\Base\DataProvider\Filter;

use Symfobooster\Base\DataProvider\AbstractFilter;

class PageFilter extends AbstractFilter
{
    public function setQuery(mixed $query): void
    {
        $query->setFirstResult($this->input->page * $this->input->pageSize);
    }
}
