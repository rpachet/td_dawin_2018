<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\CodeBarreType;
use AppBundle\Entity\Produit;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(CodeBarreType::class);

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/search", name="search")
     * @Template("search.html.twig")
     */
    public function searchAction(Request $request)
    {

        $form = $this->createForm(CodeBarreType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $code_barre = $data['code_barre'];
            $url = 'https://fr.openfoodfacts.org/api/v0/produit/'.$code_barre.'.json';
            $data = json_decode(file_get_contents($url), true);

            // Test si le produit existe dans l'api
            if ($data['status'] == 1) {
              // EntityManager
              $em = $this->get('doctrine')->getManager();

              $data['product']['product_name']."\n";
              //tester si le produit existe dans la bdd
              $produit_get = $em->getRepository(Produit::class)->findBy(
                array('codeBarre' => $code_barre)
              );

              if ($produit_get == null) {
                // Créer un nouveau produ dans la bdd
                $produit = new Produit();
                $produit->setCodeBarre($code_barre);
                $produit->setNbConsultations('1');
                $produit->setDateDerniereVue(new \DateTime());
                $em->persist($produit);
                $em->flush();
              }

              return $this->redirectToRoute('product');
            }

            // echo $data['product']['product_name']."\n";

            // XXX: A faire, chercher si le produit existe, le créer en
            // base et rediriger le visiteur vers la fiche produit

            return [
                'code_barre' => $code_barre
            ];
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/product/", name="product")
     * @Template("product.html.twig")
     */
    public function productAction()
    {
        return [];
    }
}
