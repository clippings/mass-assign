<?php

namespace Harp\MassAssign\Test;

use Harp\MassAssign\AssignModel;
use Harp\MassAssign\UnsafeData;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 * @coversDefaultClass Harp\MassAssign\AssignModel
 */
class AssignModelTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getModel
     */
    public function testConstruct()
    {
        $user = new Model\User();

        $assign = new AssignModel($user);

        $this->assertSame($user, $assign->getModel());
    }

    /**
     * @covers ::execute
     */
    public function testExecute()
    {
        $user = new Model\User();

        $assign = new AssignModel($user);
        $data = new UnsafeData([
            'name' => 'test',
            'id' => 123,
            'address' => [
                'zipCode' => 123,
                'location' => 'here',
            ],
            'posts' => [
                [
                    'name' => 'test',
                    'body' => 'post',
                ],
            ],
        ]);

        $assign->execute($data);

        $this->assertEquals(123, $user->id);
        $this->assertEquals('test', $user->name);
        $this->assertTrue($user->getAddress()->isPending());
        $this->assertEquals(123, $user->getAddress()->zipCode);
        $this->assertEquals('here', $user->getAddress()->location);
        $this->assertEquals(
            [(new Model\Post())->setProperties(['name' => 'test', 'body' => 'post'])],
            $user->getPosts()->toArray()
        );
    }
}
