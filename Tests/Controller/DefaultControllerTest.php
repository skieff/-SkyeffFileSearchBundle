<?php

namespace Skyeff\FileSearchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    const ROUTE = '/';

    public function testRoutes()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', self::ROUTE);

        $this->assertContains('File Search plugin', $client->getResponse()->getContent());
    }

    /**
     * @param $searchTerm
     * @param $showAllResults
     * @param $limit
     * @param $expectedMessage
     *
     * @dataProvider validationRulesProvider
     */
    public function testValidationRules($searchTerm, $showAllResults, $limit, $expectedMessage) {
        $client = static::createClient();

        $crawler = $client->request('GET', self::ROUTE);
        $form = $crawler->selectButton('Search')->form();

        $form['search_task[term]'] = $searchTerm;
        $form['search_task[limit]'] = $limit;

        if ($showAllResults) {
            $form['search_task[all]']->tick();
        }

        $client->submit($form);

        $this->assertContains($expectedMessage, $client->getResponse()->getContent());
    }

    /**
     * @return array
     */
    public function validationRulesProvider() {
        return [
            ['', false, 50, 'This value should not be blank.'],
            ['pattern', false, -50, 'This value should be 1 or more.'],
            ['pattern', false, 0, 'This value should be 1 or more.'],
            ['pattern', false, 1, '../match.1'],
            ['pattern', true, -50, '../match.1'],
        ];
    }
}
