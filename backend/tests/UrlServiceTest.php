<?php

namespace App\Tests;

use App\Service\UrlService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UrlServiceTest extends KernelTestCase
{
    public function testFullUrlBuilding()
    {
        self::bootKernel();

        /** @var UrlService $urlService */
        $logger = self::$container->get(LoggerInterface::class);

        $urlService = new UrlService($logger);

        $testCases = $this->getTestCases();

        foreach ($testCases as $testCase) {
            $this->assertEquals($testCase['full_url'], $urlService->getFullUrl($testCase['url'], $testCase['href']));
        }
    }

    protected function getTestCases()
    {
        return [
            [
                'url' => 'https://forum.xda-developers.com/honor-8x/development/debranding-rebranding-honor-8x-to-t3904842',
                'href' => '/honor-8x/development/debranding-rebranding-honor-8x-to-t3904842/page2',
                'full_url' => 'https://forum.xda-developers.com/honor-8x/development/debranding-rebranding-honor-8x-to-t3904842/page2',
            ],
            [
                'url' => 'https://stackoverflow.com/questions/51042051/proper-way-to-test-a-service-in-symfony-4-with-database-access',
                'href' => '/questions/51042051/proper-way-to-test-a-service-in-symfony-4-with-database-access?answertab=active#tab-top',
                'full_url' => 'https://stackoverflow.com/questions/51042051/proper-way-to-test-a-service-in-symfony-4-with-database-access?answertab=active#tab-top',
            ],
            [
                'url' => 'https://stackoverflow.com/questions/51042051/proper-way-to-test-a-service-in-symfony-4-with-database-access',
                'href' => 'https://stackoverflow.com/questions/51042051/proper-way-to-test-a-service-in-symfony-4-with-database-access',
                'full_url' => 'https://stackoverflow.com/questions/51042051/proper-way-to-test-a-service-in-symfony-4-with-database-access',
            ],
            [
                'url' => 'https://forum.xda-developers.com/honor-8x/development/debranding-rebranding-honor-8x-to-t3904842"',
                'href' => 'member.php?s=e55aa82a633f0c0b86e0c9df5799f738&u=9793126',
                'full_url' => 'https://forum.xda-developers.com/member.php?s=e55aa82a633f0c0b86e0c9df5799f738&u=9793126',
            ],
            [
                'url' => 'https://forum.xda-developers.com/honor-8x/development/debranding-rebranding-honor-8x-to-t3904842"',
                'href' => '/member.php?s=e55aa82a633f0c0b86e0c9df5799f738&u=9793126',
                'full_url' => 'https://forum.xda-developers.com/member.php?s=e55aa82a633f0c0b86e0c9df5799f738&u=9793126',
            ],
        ];
    }
}
