<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\CodeBarreType;
use AppBundle\Form\EvaluationType;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Evaluation;


class DefaultController extends Controller
{


    private function getApi($codeBarre){
      $url = 'https://fr.openfoodfacts.org/api/v0/produit/'.$codeBarre.'.json';
      $data = json_decode(file_get_contents($url), true);
      return $data;
    }

    /**
     * @Route("/", name="homepage")
     * @Template("index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(CodeBarreType::class);

        $em = $this->get('doctrine')->getManager();


        $qb = $this->get('doctrine')->getManager()->createQueryBuilder();

        $qb->select( 'e' )
        ->from( 'AppBundle:Produit',  'e' )
        ->orderBy('e.dateDerniereVue', 'desc')
        ->setMaxResults(8);
        $name = [];

        $produits = $qb->getQuery()->getResult();
        foreach ($produits as $key => $produit) {
          $code_barre =$produit->getCodeBarre();
          $data = $this->getApi($code_barre);

          array_push($name, ["codeBarre" => $code_barre, "nom" => $data['product']['product_name'], "image" => $data['product']['image_small_url']]);
        }

        return [
            'form'      => $form->createView(),
            'dernier_produits' => $name
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
            $data = $this->getApi($code_barre);

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
                $produit->setNbConsultations('0');
                $produit->setDateDerniereVue(new \DateTime());
                $em->persist($produit);
                $em->flush();
              }

              return $this->redirectToRoute('product',array("code_barre" => $code_barre));
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
    public function productAction(Request $request)
    {
      $request = Request::createFromGlobals();
      $code_barre = $request->query->get('code_barre');
      $data = $this->getApi($code_barre);

      $produit = [];
      $produit['code_barre'] = $code_barre;
      $produit['name'] = $data['product']['product_name_fr'];
      $produit['brands'] = $data['product']['brands'];
      $produit['image'] = $data['product']['image_front_url'];
      $produit['quantity'] = $data['product']['quantity'];
      $produit['ingredients'] = $data['product']['ingredients'];

      $em = $this->get('doctrine')->getManager();

      $produit_get = $em->getRepository(Produit::class)->findOneBy(
        array('codeBarre' => $code_barre)
      );
      $nb_view = $produit_get->getNbConsultations();
      $nb_view++;
      $produit_get->setNbConsultations($nb_view);
      $produit_get->setDateDerniereVue(new \DateTime());
      $em->persist($produit_get);
      $em->flush();

      $produit_get = $em->getRepository(Produit::class)->findOneBy(
        array('codeBarre' => $code_barre)
      );
      $nb_view = $produit_get->getNbConsultations();

// =============================================================================
//                          Create evaluation
// =============================================================================

      // Create Form
      $form = $this->createForm(EvaluationType::class);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $commentaire = $data['commentaire'];
        // var_dump ($commentaire);
        // die();
        $note = $data['note'];

        // var_dump ($this->getUser());
        // die();

        $evaluation = new Evaluation();
        $evaluation->setCommentaire($commentaire);
        $evaluation->setNote($note);
        $evaluation->setUser($this->getUser());
        $evaluation->setProduit($produit_get);
        $em->persist($evaluation);
        $em->flush();
      }
      $produitRepository = $em->getRepository('AppBundle:Produit');
      $getEvaluation = $produitRepository->findEvaluation($produit_get, $this->getUser());

      // user is connected and no evaluation
      if (!$getEvaluation && $this->getUser()) {
        $produit['user'] = true;
        $produit['evaluation'] = false;
        return [
          'form'        => $form->createView(),
          'produit'     => $produit,
          'nb_view'     => $nb_view,
        ];

      // user is connected and evaluation
      } elseif ($getEvaluation && $this->getUser()) {
        $produit['user'] = true;
        $produit['evaluation'] = true;
        return [
          'form'        => $form->createView(),
          'produit'     => $produit,
          'nb_view'     => $nb_view,
          'commentaire' => $getEvaluation[0]->getCommentaire(),
          'note' => $getEvaluation[0]->getNote()
        ];
      // user disconnected
      } else {
        $produit['user'] =false;

        return [
          'form'        => $form->createView(),
          'produit'     => $produit,
          'nb_view'     => $nb_view,
        ];
      }
    }

}
