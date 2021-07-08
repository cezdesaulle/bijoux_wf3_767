<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{

    /**
     * @Route("/addArticle", name="addArticle")
     */
    public function addArticle(Request $request, EntityManagerInterface $manager)
    {

        $article = new Article(); // ici on instancie un nouvel objet Article vide que l'on va charger avec les données du formulaire

        $form = $this->createForm(ArticleType::class, $article);  // on instancie un objet Form qui va va controller automatiquement la corrrespondance des champs de formulaire (contenus dans articlType) avec l'entité Article (contenu dans $article)

        $form->handleRequest($request);// la méthode handlerequest de Form nous permet de préparer la requête et remplir notre objet article instancié

        if ($form->isSubmitted() && $form->isValid()): // si le formulaire a été soumis et qu'il est valide (booléan de correspondance généré dans le createForm)
            $article->setCreateAt(new \DateTime('now'));

            $photo=$form->get('photo')->getData();   //on récupere l'input type File photo de notre formulaire grace à getData on obtient $_FILE dans son intégralité

            if ($photo):

                $nomPhoto=date('YmdHis').uniqid().$photo->getClientOriginalName(); //ici on modifie le nom de notre photo avec uniqid(), fonction de php générant une clé de hashage de 10 caractère aléatoires concaténé avec son nom et la date avec heure,minute et seconde pour s'assuré de l'unicité de la photo en bdd
                //et en upload

                $photo->move(
                    $this->getParameter('upload_directory'),
                    $nomPhoto
                ); // equivalent de move_uploaded_file() en symfony attendant 2 paramètres, la direction de l'upload (défini dans config/service.yaml dans les parameters et le nom du fichier à inserer)

                $article->setPhoto($nomPhoto);

                $manager->persist($article); // le manager de symfony fait le lien entre l'entité et la BDD via l'ORM (Object Relationnal MApping) Doctrine.Grace à la méthode persist() il conserve en mémoire la requete préparé.
                $manager->flush();  //ici la méthode flush execute les requête en mémoire

                $this->addFlash('success', 'L\article a bien été ajouté');
                return $this->redirectToRoute('addArticle');
                endif;



        endif;

        return $this->render('front/addArticle.html.twig',[
            'form'=>$form->createView()

        ]);


    }


}
