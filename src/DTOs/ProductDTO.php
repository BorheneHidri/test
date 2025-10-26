<?php
namespace App\DTOs;

class ProductDTO
{   
   public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $description=null,
        public ?string $price = null,
        public ?bool $isAvailable = null,   
        public ?int $category= null,
    ){}
}