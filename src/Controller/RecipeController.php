<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Page;
use App\Entity\Product;
use App\Entity\Recette;
use App\Entity\NumberPeople;
use App\Entity\ProductRecette;
use App\Entity\CategoryProduct;
use App\Entity\CategoryRecette;

use App\Form\StoreRegisterType;
use App\Form\RecipeRegisterType;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    /**
     * @Route("/recipe", name="recipe")
     */
    public function index()
    {
        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }

    private function addProductRecette(Form $form): Form
    {
        return $form->add("ProductRecettes", EntityType::Class, [
            "label" => "Produit",
            "class" => ProductRecette::Class,
            "choice_label" => "Product",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addCategoryRecette(Form $form): Form
    {
        return $form->add("CategoryRecette", EntityType::class, [
            "label" => "CategoryRecette",
            "class" => CategoryRecette::Class,
            "choice_label" => "name",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addBook(Form $form): Form
    {
        return $form->add("Book", EntityType::class, [
            "label" => "Book",
            "class" => Book::class,
            "choice_label" => "title",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addPage(Form $form): Form
    {
        return $form->add("Page", EntityType::class, [
            "label" => "Page",
            "class" => Page::class,
            "choice_label" => "number",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addNumberPeople(Form $form): Form
    {
        return $form->add("NumberPeople", EntityType::class, [
            "label" => "NumberPeople",
            "class" => NumberPeople::class,
            "choice_label" => "number",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addProduct(Form $form): Form
    {
        return $form->add('productRecettes', EntityType::class, [
            "label" => "productRecettes",
            "class" => ProductRecette::class,
            "choice_label" => "name",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }


    /**
     * @Route("/createRecette", name="createRecette")
     */
    public function createRecette(Request $request)
    {
        $createRecipe = new Recette();
        $form = $this->createForm(RecipeRegisterType::class, $createRecipe);
        $this->addCategoryRecette($form);
        $this->addBook($form);
        $this->addPage($form);
        $this->addNumberPeople($form);
        $this->addProduct($form);

        // $this->addPlat($form);
        // $this->addBook($form);

        // $createStore = new Product();
        // $form2 = $this->createForm(StoreRegisterType::class, $createStore);

        // $productRecette = new ProductRecette();
        // $productRecette->setRecette($createRecipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($createRecipe);
            // $em->persist($productRecette);
            // $em->persist($createStore);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('action', 'Enregistrement réussi');
            return $this->render('app/message.html.twig');
        }
        return $this->render('recipe/create.html.twig', [
            'form' => $form->createView(),
            // 'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/readRecette", name="readRecette")
     */
    public function readRecette(Request $request)
    {
        $recettes = $this->getDoctrine()->getManager()->getRepository(Recette::class)->findAll();
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findBy([], ['name'=>'ASC']);
        $productRecettes = $this->getDoctrine()->getManager()->getRepository(ProductRecette::class)->findAll();
        $plats = $this->getDoctrine()->getManager()->getRepository(CategoryRecette::class)->findAll();
        
        return $this->render('recipe/read.html.twig', [
            'recettes' => $recettes,
            'categories' => $categories,
            'productRecettes' => $productRecettes,
            'plats' => $plats,
        ]);
    }

    /**
     * @Route ("/showSpecRecette/{id}", name="showSpecRecette")
     */
    public function showSpecRecette(Recette $recette)
    {
        $recettes = $this->getDoctrine()->getManager()->getRepository(Recette::class)->findById($recette);
        // $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findAll();

        return $this->render("recipe/showSpecRecipe.html.twig", [
            'recettes' => $recettes,
            // 'products' => $products,
        ]);
    }


//TODO
    /**
     * @Route ("/readRecettePlat", name="readRecettePlat")
     */
    public function readRecettePlat(Request $request)
    {
        $request = Request::createFromGlobals();
        $valeur = $request->query->get('name');
 
        $plats = $this->getDoctrine()->getManager()->getRepository(CategoryRecette::class)->findAll();
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findAll();
        $productRecettes = $this->getDoctrine()->getManager()->getRepository(ProductRecette::class)->findAll();

        $em = $this->getDoctrine()->getManager()->getRepository(Recette::class);
        $recettes = $em->createQueryBuilder('p')
            ->join('p.plat', 'R')
            ->where('R.name = :name')
            ->setParameter('name', $valeur)
            // ->orderby('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('recipe/read.html.twig', [
            'recettes' => $recettes,
            'categories' => $categories,
            'productRecettes' => $productRecettes,
            'plats' => $plats,
        ]);
    }


//TODO
    /**
     * @Route("/deleteR/{id}", name="deleteRecipe")
     */
    public function deleteRecipe(Recette $recettes, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($recettes);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('action', 'Suppression réussi');
        return $this->render('app/message.html.twig');
    }


//TODO
    /**
     * @Route("/updateR/{id}", name="updateRecipe")
     */
    public function updateRecipe(Recette $recettes, Request $request)
    {
        $form = $this->createForm(RecipeRegisterType::class, $recettes);
        $this->addPlat($form);
        $this->addBook($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('action', 'Modification du produit réussi');
            return $this->render('app/message.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    return $this->render('recipe/update.html.twig', [
        'form' => $form->createView(),
        ]);
    }


//TODO
    /**
     * @Route("/showSpecRecipe/{id}", name="showSpecRecipe")
     */
    public function showSpecRecipe(Recette $recette, Request $request)
    {     
        $recettes = $this->getDoctrine()->getManager()->getRepository(Recette::class)->findById($recette);
        $productRecettes = $this->getDoctrine()->getManager()->getRepository(ProductRecette::class)->findAll();
 
        return $this->render('recipe/showSpec.html.twig', [
            'recettes' => $recettes,
            'productRecettes' => $productRecettes,
        ]);            
    }


    /**
     * @Route ("/showRecipeCategory", name="showRecipeCategory")
     */
    public function showRecipeCategory(Request $request)
    {
        $recettes = $this->getDoctrine()->getManager()->getRepository(Recette::class)->findAll();
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findBy([], ['name'=>'ASC']);
        $productRecettes = $this->getDoctrine()->getManager()->getRepository(ProductRecette::class)->findAll();
        $plats = $this->getDoctrine()->getManager()->getRepository(CategoryRecette::class)->findAll();       

        $request = Request::createFromGlobals();
        $valeur = $request->query->get('name');

        $em = $this->getDoctrine()->getManager()->getRepository(Recette::class);
        $recettes = $em->createQueryBuilder('p')
            ->join('p.CategoryRecette', 'R')
            ->where('R.name = :name')
            ->setParameter('name', $valeur)
            ->orderby('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('recipe/read.html.twig', [
            'recettes' => $recettes,
            'categories' => $categories,
            'productRecettes' => $productRecettes,
            'plats' => $plats,
        ]);
    }
}
