<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/saveCategory", name="admin_save_category", methods={"POST"})
     */
    public function saveCategory(Request $request): Response
    {
        $name = $request->request->get('name');

        $category = new Category();
        $category->setName($name);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("/admin/categoryDelete/{id}", name="admin_category_delete")
     */
    public function categoryDelete(int $id): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if ($category) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    public function editCategory(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $c = $entityManager->getRepository(Category::class)->find($id);

        if (!$c) {
            throw $this->createNotFoundException('Category not found');
        }

        $c->setName($request->request->get('name'));
        $entityManager->flush();

        return $this->redirectToRoute('your_edit_category_route');
    }

    public function product(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Produit::class)->findAll();

        return $this->render('products/index.html.twig', [
            'products' => $products,
        ]);
    }

    public function saveProduct(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $p = new Produit();
        $p->setName($request->request->get('name'));
        $p->setDescription($request->request->get('description'));
        $p->setCategoryId($request->request->get('category_id'));

        $path = 'storage/' . $request->files->get('path')->move('products', 'public');
        $p->setPath($path);

        $p->setPrice($request->request->get('price'));

        $entityManager->persist($p);
        $entityManager->flush();

        return $this->redirectToRoute('your_product_route');
    }

    public function updateProduct(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $p = $entityManager->getRepository(Produit::class)->find($id);

        if (!$p) {
            throw $this->createNotFoundException('Product not found');
        }

        $p->setName($request->request->get('name'));
        $p->setDescription($request->request->get('description'));
        $p->setCategoryId($request->request->get('category_id'));

        if ($request->files->get('path') !== null) {
            $path = 'storage/' . $request->files->get('path')->move('products', 'public');
            $p->setPath($path);
        }

        $p->setPrice($request->request->get('price'));

        $entityManager->flush();

        return $this->redirectToRoute('your_product_route');
    }

    public function deleteProduct($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $p = $entityManager->getRepository(Produit::class)->find($id);

        if ($p) {
            $entityManager->remove($p);
            $entityManager->flush();
        }

        return $this->redirectToRoute('your_product_route');
    }

    public function promotion(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $promotions = $entityManager->getRepository(Promotion::class)->findAll();

        return $this->render('promotion/index.html.twig', [
            'promotions' => $promotions,
        ]);
    }

    public function storePromotion(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $p = new Promotion();
        $p->setProduitId($request->request->get('product'));
        $p->setStart(new \DateTime($request->request->get('start')));
        $p->setEnd(new \DateTime($request->request->get('end')));
        $p->setPercent($request->request->get('percent'));

        $entityManager->persist($p);
        $entityManager->flush();

        return $this->redirectToRoute('your_promotion_route');
    }

    public function promotionDelete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $p = $entityManager->getRepository(Promotion::class)->find($id);

        if ($p) {
            $entityManager->remove($p);
            $entityManager->flush();
        }

        return $this->redirectToRoute('your_promotion_route');
    }
}
