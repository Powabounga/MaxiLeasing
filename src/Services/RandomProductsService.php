<?php

namespace App\Services;

class RandomProductsService
{
    public function getRandomProducts(array $products, int $count = 5): array
    {
        $randomKeys = array_rand($products, $count);
        $randomProducts = [];

        foreach ($randomKeys as $key) {
            $randomProducts[] = $products[$key];
        }

        return $randomProducts;
    }
}
