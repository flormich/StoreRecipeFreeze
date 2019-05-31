<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Page;
use App\Entity\Product;
use App\Entity\Recette;
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
        return $form->add("productRecettes", EntityType::Class, [
            "label" => "Produit",
            "class" => ProductRecette::Class,
            "choice_label" => "Product",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }



//TODO
    /**
     * @Route("/createRecette", name="createRecette")
     */
    public function createRecette(Request $request)
    {
        $createRecipe = new Recette();
        $form = $this->createForm(RecipeRegisterType::class, $createRecipe);
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
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findAll();
        $productRecettes = $this->getDoctrine()->getManager()->getRepository(ProductRecette::class)->findAll();
        $plats = $this->getDoctrine()->getManager()->getRepository(CategoryRecette::class)->findAll();
        
        return $this->render('recipe/read.html.twig', [
            'recettes' => $recettes,
            'categories' => $categories,
            'productRecettes' => $productRecettes,
            'plats' => $plats,
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
}
