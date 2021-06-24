<?php
/**
 * codekunst GmbH <www.codekunst.com>
 * @author e <hello@codekunst.com>
 */

namespace App\Tests\Controller;

use App\Controller\SearchController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{

    public function testSearch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/search?query=test1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h5', 'prefix Test1 postfix');
    }
}
