<?php

namespace App\Controller;

use App\Entity\Book;
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

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index()
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    // private function addBook(Form $form): Form
    // {
    //     return $form->add("book", EntityType::Class, [
    //         "label" => "Book",
    //         "class" => Book::Class,
    //         "choice_label" => "Color",
    //         "expanded" => false,
    //         "multiple" => false,
    //         "required" => true,
    //     ]);
    // }


//TODO
    /**
     * @Route("/createOrder", name="createOrder")
     */
    public function createOrder(Request $request)
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
     * @Route("/readOrder", name="readOrder")
     */
    public function readOrder(Request $request)
    {
        $recettes = $this->getDoctrine()->getManager()->getRepository(Recette::class)->findAll();
        // $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findAll();
        $productRecettes = $this->getDoctrine()->getManager()->getRepository(ProductRecette::class)->findAll();
        $plats = $this->getDoctrine()->getManager()->getRepository(CategoryRecette::class)->findAll();
        
        return $this->render('order/read.html.twig', [
            'recettes' => $recettes,
            // 'categories' => $categories,
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
}
