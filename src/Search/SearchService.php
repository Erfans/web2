<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Search;


use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

class SearchService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function searchBook($input)
    {
        $bookRepository = $this->entityManager->getRepository(Book::class);
        return $bookRepository->createQueryBuilder('b')
            ->where('b.name like :q')
            ->setParameter('q', '%' . $input . '%')
            ->getQuery()
            ->getResult();
    }
}