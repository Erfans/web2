<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Tests\Search;

use App\Entity\Book;
use App\Entity\BookStore;
use App\Search\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SearchServiceTest extends KernelTestCase
{
    public function testSearchBook()
    {
        self::bootKernel();
        $container = self::$container;
        /** @var SearchService $searchService */
        $searchService = $container->get(SearchService::class);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine')->getManager();

        $bookStore = new BookStore();
        $bookStore->setName("test");
        $bookStore->setEmail("test@test.com");
        $bookStore->setPhone("1234");
        $entityManager->persist($bookStore);

        $book = new Book();
        $book->setName("prefix Test1 postfix");
        $book->setPrice(10);
        $book->setBookStore($bookStore);
        $entityManager->persist($book);

        $entityManager->flush();

        /** @var Book[] $result */
        $result = $searchService->searchBook("Test1");
        $this->assertNotEmpty($result);

        $firstBook = $result[0];
        $this->assertEquals(10, $firstBook->getPrice());
    }
}
