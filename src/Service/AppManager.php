<?php

namespace App\Service;
use App\Entity\Film;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Code métier de l'app
 */
class AppManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var PaginatorInterface
     */
    protected $pager;

    /**
     * AppManager constructor.
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $pager
     */
    public function __construct(EntityManagerInterface $em, PaginatorInterface $pager)
    {
        $this->pager = $pager;
        $this->em = $em;
    }


    /**
     * Retourne la liste des films paginée et filtrée
     */
    public function getList(array $filters, int $page): PaginationInterface
    {
        return $this->pager->paginate(
            $this->em->getRepository(Film::class)->getSearchQuery($filters['term'] ?? ""),
            $page
        );
    }

    /**
     * Sauvegarde un film
     */
    public function saveFilm(Film $film): void
    {
        if (!$film->getId()) {
            $this->em->persist($film);
        }

        foreach ($film->getCharacters() as $character) {
            if (!$character->getId()) {
                $character->setFilm($film);
                $this->em->persist($character);
            }
        }

        $this->em->flush();
    }
}