<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\RandomProductsService;

#[Route('/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{

    private $randomProductsService;

    public function __construct(RandomProductsService $randomProductsService)
    {
        $this->randomProductsService = $randomProductsService;
    }

    #[Route('/', name: 'main')]
    public function index(CategoriesRepository $categoriesRepository, ProductsRepository $productsRepository, RandomProductsService $randomProductsService): Response
    {
        $categories = $categoriesRepository->findBy([], ['categoryOrder' => 'ASC']);
        $products = $productsRepository->findAll();

        $randomProducts = $randomProductsService->getRandomProducts($products, 6);
        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
            'randomProducts' => $randomProducts,
            'randomProductsService' => $randomProductsService
        ]);
    }

    #[Route('/{slug}', name: 'list')]
    public function list(Categories $category, ProductsRepository $productsRepository, Request $request): Response
    {

        $page = $request->query->getInt('page', 1); // 1

        $products = $productsRepository->findProductPaginated($page, $category->getSlug(), 16);

        return $this->render('categories/list.html.twig', compact('category', 'products'));
    }
}
