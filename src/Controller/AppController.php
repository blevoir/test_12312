<?php

namespace App\Controller;
use App\Entity\Film;
use App\Form\SearchFiltersForm;
use App\Form\Type\FilmType;
use App\Service\AppManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller de l'app
 * @Route(name="app_", path="")
 */
class AppController extends AbstractController
{
    /**
     * Liste des films
     *
     * @Route("", name="index")
     */
    public function index(Request $request, AppManager $manager):  Response
    {
        $form = $this->createForm(SearchFiltersForm::class, ['term' => ""]);
        $form->handleRequest($request);

        return $this->render(
            'app/index.html.twig',
            [
                'form' => $form->createView(),
                'films' => $manager->getList(
                    $form->getData(),
                    $request->query->getInt('page', 1)
                )
            ]
        );
    }

    /**
     * Ajout / Edition de film
     *
     * @Route("/add", name="add")
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, AppManager $manager, ?Film $film = null):  Response
    {
        if ($request->attributes->get('_route') == 'app_add') {
            $film = new Film();
        } else {
            if (!$film) {
                throw $this->createNotFoundException();
            }
        }

        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->saveFilm($film);
            return $this->redirect($this->generateUrl('app_edit', ['id' => $film->getId()]));
        }

        return $this->render(
            'app/edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Affiche un film
     *
     * @Route("/show/{id}", name="show")
     */
    public function show(Film $film): Response
    {
        return $this->render(
            'app/show.html.twig',
            [
                'film' => $film
            ]
        );
    }
}
