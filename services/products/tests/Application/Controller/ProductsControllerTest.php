<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductsControllerTest extends WebTestCase
{
    public function testProductsGetMethodWithoutSearchParams(): void
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/products');

        $this->assertResponseIsSuccessful();
    }
}
