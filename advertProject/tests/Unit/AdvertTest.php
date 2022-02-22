<?php
namespace App\tests\Unit;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdvertTest extends WebTestCase
{
    public function testGetAdvert()
    {
        $client = self::createClient();

        $client->request('GET', '/api/advert/1', [], []);
        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('Audi a vendre', $response['Title']);
        $this->assertEquals(' laoreet mauris vulputate sed. Quisque luctus posuere pellentesque. Ut in sem congue, venenatis eros non, feugiat nisi.', $response['Content']);
        $this->assertEquals('Automobile', $response['Category']);

        self::assertResponseIsSuccessful();
    }

    public  function testPostAdvert(): void
    {
        $client = self::createClient();

        $data = ['Title' => 'Test post',
            'Content' => 'Test content',
            'Category' => "2",
            ];

        $client->request('POST','/api/advert',  [],[],[],json_encode($data));
        $statuCode = $client->getResponse()->getStatusCode();
        $this->assertEquals(201, $statuCode);
        $this->assertEquals('Votre annonce a été bien ajouté :)', $client->getResponse()->getContent());
    }


    public  function testPutAdvert(): void
    {
        $client = self::createClient();

        $data = ['Title' => 'Test PUT',
            'Content' => 'Test content',
            'Category' => 1,
            'Model' => 5
        ];

        $client->request('PATCH','/api/advert/2',  [],[],[],json_encode($data));
        $statuCode = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $statuCode);
        $this->assertEquals('Votre annonce a été bien modifié :)', $client->getResponse()->getContent());
    }

    public  function testMatchNameModelDS3(): void
    {
        $client = self::createClient();

        $client->request('GET','/api/advert/model/ds 3',[],[]);
        $statuCode = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $statuCode);
        $this->assertEquals('Ds3', $client->getResponse()->getContent());
    }

    public  function testMatchNameModelSerie5(): void
    {
        $client = self::createClient();

        $client->request('GET','/api/advert/model/rs4',[],[]);
        $statuCode = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $statuCode);
        $this->assertEquals('Rs4', $client->getResponse()->getContent());
    }

}