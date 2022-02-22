<?php



class AdvertTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{

    public function testGetAdvert()
    {
        $client = self::createClient();

        $client->request('GET', '/api/advert/2', [], []);
        $this->assertResponseIsSuccessful();
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('Symfonny annonce', $response['Title']);
        $this->assertEquals('prerequis : php', $response['Content']);
        $this->assertEquals('Emploi', $response['Category']);

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
            'Category' => "2",
            'Model' => 5
        ];

        $client->request('PATCH','/api/advert/11',  [],[],[],json_encode($data));
        $statuCode = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $statuCode);
        $this->assertEquals('Votre annonce a été bien modifié :)', $client->getResponse()->getContent());
    }

    public  function testMatchNameModel(): void
    {
        $client = self::createClient();

        $client->request('GET','/api/advert/model/DS3',  [],[]);
        $statuCode = $client->getResponse()->getStatusCode();
        $this->assertEquals(200, $statuCode);
        $this->assertEquals('Ds3', $client->getResponse()->getContent());
    }
}