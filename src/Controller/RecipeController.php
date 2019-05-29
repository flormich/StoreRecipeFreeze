<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Page;
use App\Entity\Plat;
use App\Entity\Product;
use App\Entity\Recette;
use App\Entity\Category;
use App\Entity\ProductRecette;

use App\Form\PageRegisterType;
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
        return $form->add("productRecettes", EntityType::Class, [
            "label" => "Produit",
            "class" => ProductRecette::Class,
            "choice_label" => "Product",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addPlat(Form $form): Form
    {
        return $form->add("plat", EntityType::Class, [
            "label" => "Plat",
            "class" => Plat::Class,
            "choice_label" => "Name",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addBook(Form $form): Form
    {
        return $form->add("book", EntityType::Class, [
            "label" => "Book",
            "class" => Book::Class,
            "choice_label" => "Color",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addProduct(Form $form): Form
    {
        return $form->add("product", EntityType::Class, [
            "label" => "Product",
            "class" => Product::Class,
            "choice_label" => "name",
            "expanded" => false,
            "multiple" => true,
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
        $this->addPlat($form);
        $this->addBook($form);

        $createStore = new Product();
        $form2 = $this->createForm(StoreRegisterType::class, $createStore);

        $productRecette = new ProductRecette();
        $productRecette->setRecette($createRecipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($createRecipe);
            $em->persist($productRecette);
            $em->persist($createStore);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('action', 'Enregistrement réussi');
            return $this->render('app/message.html.twig');
        }
        return $this->render('recipe/create.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/readRecette", name="readRecette")
     */
    public function readRecette(Request $request)
    {
        $recettes = $this->getDoctrine()->getManager()->getRepository(Recette::class)->findAll();
        $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
        $productRecettes = $this->getDoctrine()->getManager()->getRepository(ProductRecette::class)->findAll();
        $plats = $this->getDoctrine()->getManager()->getRepository(Plat::class)->findAll();
        
        return $this->render('recipe/read.html.twig', [
            'recettes' => $recettes,
            'categories' => $categories,
            'productRecettes' => $productRecettes,
            'plats' => $plats,
        ]);
    }

       /**
    * @Route ("/readRecettePlat", name="readRecettePlat")
    */
    public function readRecettePlat(Request $request)
    {
        $request = Request::createFromGlobals();
        $valeur = $request->query->get('name');
 
        $plats = $this->getDoctrine()->getManager()->getRepository(Plat::class)->findAll();
        $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
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
}
