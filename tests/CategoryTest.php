<?php 
namespace Tests\Util;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    
    public function testSetCategoryName()
    {
        $category = new Category();
        $category->setName('TestCategory');

        // assert that your calculator added the numbers correctly!
        $this->assertEquals($category->getName(), 'TestCategory');
    }
}