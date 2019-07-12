<?php


namespace App\Tests\DataControllerIntegrationalTest;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use App\Controller\DataController;

class DataControllerTest extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();
    }

    public function getMethodDistributionTest()
    {
        return [
            ['[{"host":"dept59.ac-sia.depaul.edu ","datetime":{"day":"30","hour":"00","minute":"36","second":"34"},"request":{"method":"GET","url":"\/logos\/small_gopher.gif HTTP\/1.0\"","protocol":"","protocol_version":""},"response_code":"200","document_size":"935"}]',
             1,0,0],
             ['[{"host":"dept59.ac-sia.depaul.edu ","datetime":{"day":"30","hour":"00","minute":"36","second":"34"},"request":{"method":"POST","url":"\/logos\/small_gopher.gif HTTP\/1.0\"","protocol":"","protocol_version":""},"response_code":"200","document_size":"935"}]',
             0,1,0],
             ['{}',0,0,0]
        ];
    }

    /**
     * @dataProvider getMethodDistributionTest
     */
    public function testMethodDistribution($json, $get, $post, $head)
    {
        $filesystem = new Filesystem();
        $filesystem->dumpFile('var/uploads/json.txt', $json);
        $dataController = self::$kernel->getContainer()
            ->get(DataController::class);
        $result = $dataController->methodDistribution("var/uploads/");
        $result = json_decode($result->getContent(),true);
        $this->assertSame($result['GET'], $get);
        $this->assertSame($result['POST'], $post);
        $this->assertSame($result['HEAD'], $head);
    }

    public function getAnswerDistributionTest()
    {
        return [
            ['[{"host":"dept59.ac-sia.depaul.edu ","datetime":{"day":"30","hour":"00","minute":"36","second":"34"},"request":{"method":"GET","url":"\/logos\/small_gopher.gif HTTP\/1.0\"","protocol":"","protocol_version":""},"response_code":"200","document_size":"935"}]']
        ];
    }

    /**
     * @dataProvider getAnswerDistributionTest
     */
    public function testAnswerDistribution200($json)
    {
        $filesystem = new Filesystem();
        $filesystem->dumpFile('var/uploads/json.txt', $json);
        $dataController = self::$kernel->getContainer()
            ->get(DataController::class);
        $result = $dataController->answerDistribution("var/uploads/");
        $result = json_decode($result->getContent(),true);
        
        $this->assertSame($result[200], 1);
    }
}
