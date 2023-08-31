<?php

declare(strict_types=1);

namespace Symfobooster\Base\DataProvider\Filter;

use Symfobooster\Base\DataProvider\AbstractFilter;

class PageSizeFilter extends AbstractFilter
{
    public function setQuery(mixed $query): void
    {
        $query->setMaxResults($this->input->pageSize);
    }
}
