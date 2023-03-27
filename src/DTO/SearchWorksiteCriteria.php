<?php

declare(strict_types=1);

namespace App\DTO;

class SearchWorksiteCriteria
{
    public ?string $title= '';

    public ?array $categories= [];

    public ?string $orderBy= 'title';

    public ?string $direction = 'ASC';

    public ?int  $limit= 15;

    public ?int $page=1;
}
