<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    
    public function testAjoutdepotOK()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/Depot',[],[],
        ['CONTENT_TYPE'=>'application/json'],
        '{"datedepot":"2019-02-08 09:39:00","solde": 7555500}');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(201,$client->getResponse()->getStatusCode());  
    }
    /*public function testAjoutdepotKO()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/Depot',[],[],
        ['CONTENT_TYPE'=>'application/json'],
        '{"datedepot":"","solde": "jjjjjjjjj"}');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(200,$client->getResponse()->getStatusCode());  
    }*/

    public function testAjoutcompteOK()
    {
        $client = static::createClient([],
        ['PHP_AUTH_USER' => 'diouf',
        'PHP_AUTH_PW' => 'lamine',] 
    );
        $crawler = $client->request('POST', '/api/Compte',[],[],
        ['CONTENT_TYPE'=>'application/json'],
        '{"numerocompte":"1234","montant":75000}');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(200,$client->getResponse()->getStatusCode());  
    }


}
