<?php

namespace Harp\MassAssign\Test;

use Harp\MassAssign\UnsafeData;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 * @coversDefaultClass Harp\MassAssign\UnsafeData
 */
class UnsafeDataTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::all
     * @covers ::getId
     * @covers ::getRepo
     * @covers ::setRepoClass
     */
    public function testConstruct()
    {
        $data = new UnsafeData([]);

        $this->assertEquals([], $data->all());
        $this->assertEquals(null, $data->getId());
        $this->assertEquals(null, $data->getRepo());

        $data = new UnsafeData(['name' => 'test', '_id' => 123, '_repo' => __NAMESPACE__.'\Repo\User']);

        $this->assertEquals(['name' => 'test'], $data->all());
        $this->assertEquals(123, $data->getId());
        $this->assertEquals(Repo\User::get(), $data->getRepo());
    }

    /**
     * @covers ::__construct
     * @covers ::setRepoClass
     * @expectedException InvalidArgumentException
     */
    public function testConstructWithInvalidRepo()
    {
        new UnsafeData(['name' => 'test', '_id' => 123, '_repo' => __NAMESPACE__.'\Model\User']);
    }

    /**
     * @covers ::assignTo
     */
    public function testAssignTo()
    {
        $data = new UnsafeData([
            'name' => 'test',
            'id' => 123,
            'address' => [
                'zipCode' => 123,
                'location' => 'here',
            ]
        ]);

        $user = new Model\User();

        $data->assignTo($user);

        $this->assertEquals(123, $user->id);
        $this->assertEquals('test', $user->name);
        $this->assertTrue($user->getAddress()->isPending());
        $this->assertEquals(123, $user->getAddress()->zipCode);
        $this->assertEquals('here', $user->getAddress()->location);
    }

    /**
     * @covers ::getPropertiesData
     * @covers ::getRelData
     */
    public function testData()
    {
        $data = new UnsafeData([
            'name' => 'test',
            'id' => 123,
            'address' => [
                'zipCode' => 123,
                'location' => 'here',
            ],
        ]);

        $user = new Model\User();


        $expectedProperties = [
            'name' => 'test',
            'id' => 123,
        ];

        $expectedRels = [
            'address' => new UnsafeData([
                'zipCode' => 123,
                'location' => 'here',
            ]),
        ];

        $this->assertEquals($expectedProperties, $data->getPropertiesData($user));
        $this->assertEquals($expectedRels, $data->getRelData($user));
    }

    /**
     * @covers ::getArray
     */
    public function testGetArray()
    {
        $data = new UnsafeData([
            [
                'id' => 12,
                'name' => 'test',
            ],
            [
                'id' => 123,
                'name' => 'test2',
            ],
        ]);

        $expected = [
            new UnsafeData([
                'id' => 12,
                'name' => 'test',
            ]),
            new UnsafeData([
                'id' => 123,
                'name' => 'test2',
            ]),
        ];

        $this->assertEquals($expected, $data->getArray());
    }
}
