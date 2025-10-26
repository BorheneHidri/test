<?php

namespace App\DTOs;
class CategoryDTO
{
    public function __construct(
        public string $name,
        public ?string $description = null,
    ){}
}