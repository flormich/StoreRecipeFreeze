<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Places;
use App\Entity\Product;
use App\Entity\PictureProduct;
use App\Entity\CategoryProduct;

use App\Form\StockRegisterType;
use App\Form\PictureRegisterType;
use App\Form\ProductRegisterType;
use App\Form\QuantityGrRegisterType;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Console\Logger\ConsoleLogger;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    /**
     * @Route("/store", name="store")
     */
    public function index()
    {
        return $this->render('store/index.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }

    // private function addPicture(Form $form): Form
    // {
    //     return $form->add('PictureProduct', EntityType::class, [
    //         "label" => "Images",
    //         "class" => PictureProduct::class,
    //     ]);
    // }

    private function addCategoryProduct(Form $form): Form
    {
        return $form->add("CategoryProduct", EntityType::Class, [
            "label" => "Categories du produit",
            "class" => CategoryProduct::Class,
            "choice_label" => "name",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    private function addPlaces(Form $form): Form
    {
        return $form->add("Places", EntityType::class, [
            "label" => "Emplacement",
            "class" => Places::class,
            "choice_label" => "name",
            "expanded" => false,
            "multiple" => false,
            "required" => true,
        ]);
    }

    /**
     * @Route("/createStore", name="createStore")
     */
    public function createStore(Request $request)
    {
        $createStock = new Stock();            
        $form2 = $this->createForm(StockRegisterType::class, $createStock);
        $this->addPlaces($form2);
        // $createStore->setPictureProduct($createPicture);     

        $createStore = new Product();
        $form = $this->createForm(ProductRegisterType::class, $createStore);
        $this->addCategoryProduct($form);
        $createStore->setStock($createStock);
    
        $form->handleRequest($request);
        $form2->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($createStock);
            $em->persist($createStore);
            $em->flush();
    
            $request->getSession()
                    ->getFlashBag()
                    ->add('action', 'Enregistrement réussi');
            return $this->render('app/message.html.twig');
        }
 
        return $this->render('store/create.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/readStore", name="readStore")
     */
    public function readStore(Request $request)
    {
        $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([], ['name'=>'ASC']);
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findBy([], ['name'=>'ASC']);
        $productsAsc = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['name' => 'ASC']);
        
        // $places = $this->getDoctrine()->getManager()->getRepository(Places::class)->findAll();
        // $stock = $this->getDoctrine()->getManager()>getRepository(Stock::class)->findAll();
        // $picture = $this->getDoctrine()->getManager()->getRepository(PictureProduct::class)->findAll();

 
        return $this->render('store/read.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'productsAsc' => $productsAsc,
            // 'pictures' => $picture,
            // 'places' => $places,
        ]);
    }


//TODO
    // /**
    //  * @Route("/readStore", name="readStore")
    //  */
    // public function readStore(Request $request)
    // {
    //     $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([], ['name'=>'ASC']);
    //     $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy([], ['name'=>'ASC']);
    //     $picture = $this->getDoctrine()->getManager()->getRepository(PictureProduct::class)->findAll();

    //     return $this->render('store/read.html.twig', [
    //         'products' => $products,
    //         'categories' => $categories,
    //         'pictures' => $picture,
    //     ]);
    // }

//TODO
    /**
     * @Route ("/showProductCategory", name="showProductCategory")
     */
    public function showProductCategory(Request $request)
    {
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findBy([], ['name'=>'ASC']);
        $productsAsc = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['name' => 'ASC']);

        $request = Request::createFromGlobals();
        $valeur = $request->query->get('name');

        $em = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $allProduct = $em->createQueryBuilder('p')
            ->join('p.category', 'R')
            ->where('R.name = :name')
            ->setParameter('name', $valeur)
            ->orderby('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('store/read.html.twig', [
            'products' => $allProduct,
            'categories' => $categories,
            'productsAsc' => $productsAsc,
        ]);
    }

//TODO
    /**
     * @Route ("/showProductName", name="showProductName")
     */
    public function showProductName(Request $request)
    {
        $request = Request::createFromGlobals();
        $valeur = $request->query->get('name');

        $productName = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy(['name' => $valeur]);
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findBy([], ['name' => 'ASC']);
        $productsAsc = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['name' => 'ASC']);

        return $this->render('store/read.html.twig', [
            'products' => $productName,
            'categories' => $categories,
            'productsAsc' => $productsAsc,
        ]);
    }

//TODO
    // /**
    //  * @Route ("/showProductDrawer", name="showProductDrawer")
    //  */
    // public function showProductDrawer(Request $request)
    // {
    //     $request = Request::createFromGlobals();
    //     $valeur = $request->query->get('name');

    //     $productName = $this->getDoctrine()->getManager()->getRepository(Product::class)->findAll();
    //     $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll();
    //     $drawers = $this->getDoctrine()->getManager()->getRepository(Freezer::class)->findBy([], ['name' => $valeur]);

    //     return $this->render('store/read.html.twig', [
    //       'products' => $productName,  
    //       'categories' => $categories,
    //       'drawers' => $drawers,
    //     ]);
    // }

//TODO
    // /**
    //  * @Route("/showProduct", name="showProduct")
    //  */
    //  public function showProduct()
    //  {
    //      $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['name' => 'Asc']);
    //      $categories = $this->getDoctrine()->getManager()->getRepository(Category::class)->findBy([],['name' => 'Asc']);
 
    //      return $this->render('store/read.html.twig', [
    //          'products' => $products,
    //          'categories' => $categories,
    //      ]);
    //  }

//TODO
    /**
     * @Route("/deleteP/{id}", name="deleteProduct")
     */
    public function deleteProduct(Product $products, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($products);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('action', 'Suppression réussi');
        return $this->render('app/message.html.twig');
    }

//TODO
    /**
     * @Route("/updateP/{id}", name="updateProduct")
     */
    public function updateProduct(Product $products, Request $request)
    {
        $form = $this->createForm(StoreRegisterType::class, $products);
        $this->addCategory($form);
        $this->addFreezer($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('action', 'Modification du produit réussi');
            return $this->render('app/message.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    return $this->render('store/update.html.twig', [
        'form' => $form->createView(),
        ]);
    }

//TODO
    /**
     * @Route("/changeAdd/{id}", name="changeProductAdd")
     */
    public function changeProductAdd(Product $products, Request $request)
    {
        $oldGr = $products->getQuantityGr();
        $oldUnit = $products->getQuantityUnit();

        $form = $this->createForm(StoreRegisterType::class, $products);

        $form->handleRequest($request);

        $newdGr = $products->getQuantityGr();
        $newUnit = $products->getQuantityUnit();

        $calcGr = $oldGr + $newdGr;
        $calcUnit = $oldUnit + $newUnit;

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $products->setQuantityGr($calcGr);
            $products->setQuantityUnit($calcUnit);
            $em->flush();


            $request->getSession()
                ->getFlashBag()
                ->add('action', 'Modification du produit réussi');
            return $this->render('app/message.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    return $this->render('store/change.html.twig', [
        'form' => $form->createView(),
        ]);
    }

//TODO
    /**
     * @Route("/changeMin/{id}", name="changeProductMin")
     */
    public function changeProductMin(Product $products, Request $request)
    {
        $oldGr = $products->getQuantityGr();
        $oldUnit = $products->getQuantityUnit();
 
        $form = $this->createForm(StoreRegisterType::class, $products);
 
        $form->handleRequest($request);
 
        $newdGr = $products->getQuantityGr();
        $newUnit = $products->getQuantityUnit();
 
        $calcGr = $oldGr - $newdGr;
        $calcUnit = $oldUnit - $newUnit;
 
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $products->setQuantityGr($calcGr);
            $products->setQuantityUnit($calcUnit);
            $em->flush();
 
            $request->getSession()
                ->getFlashBag()
                ->add('action', 'Modification du produit réussi');
            return $this->render('app/message.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    return $this->render('store/change.html.twig', [
        'form' => $form->createView(),
        ]);
    }

//TODO
    /**
     * @Route("/showProductNameAsc", name="showProductNameAsc")
     */
    public function showProductNameAsc()
    {
        $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['name' => 'ASC']);
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findBy([], ['name'=>'ASC']);
        $productsAsc = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['name' => 'ASC']);

        return $this->render('store/read.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'productsAsc' => $productsAsc,
        ]);
    }

//TODO
    /**
     * @Route("/showProductCatAsc", name="showProductCatAsc")
     */
    public function showProductCatAsc()
    {
        $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([], ['category' => 'ASC', 'name' => 'ASC']);
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findBy([], ['name' => 'ASC']);
        $productsAsc = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['name' => 'ASC']);

        return $this->render('store/read.html.twig', [
            'products' => $products,
            'categories' => $categories, 
            'productsAsc' => $productsAsc,            
        ]);
    }

//TODO
    /**
     * @Route("/showProductTirAsc", name="showProductTirAsc")
     */
    public function showProductTirAsc()
    {
        $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['freezer' => 'ASC', 'name' => 'ASC']);
        $categories = $this->getDoctrine()->getManager()->getRepository(CategoryProduct::class)->findBy([], ['name' => 'ASC']);
        $productsAsc = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy([],['name' => 'ASC']);
 
        return $this->render('store/read.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'productsAsc' => $productsAsc,
        ]);
    }
}