<?php

namespace Harp\MassAssign\Test;

use Harp\MassAssign\Data;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 * @coversDefaultClass Harp\MassAssign\Data
 */
class DataTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getPermitted
     */
    public function testConstruct()
    {
        $data = new Data([], []);

        $this->assertEquals([], $data->all());
        $this->assertEquals([], $data->getPermitted());
        $this->assertEquals(null, $data->getId());
        $this->assertEquals(null, $data->getRepo());

        $data = new Data(
            ['name' => 'test', '_id' => 123, '_repo' => __NAMESPACE__.'\Repo\User'],
            ['_id', 'name']
        );

        $this->assertEquals(['name' => 'test'], $data->all());
        $this->assertEquals(123, $data->getId());
        $this->assertEquals(['_id' => null, 'name' => null], $data->getPermitted());
        $this->assertEquals(Repo\User::get(), $data->getRepo());
    }

    /**
     * @covers ::getPropertiesData
     * @covers ::getRelData
     */
    public function testData()
    {
        $data = new Data(
            [
                'name' => 'test',
                'id' => 123,
                'address' => [
                    'zipCode' => 123,
                    'location' => 'here',
                ],
            ],
            ['name', 'address' => 'zipCode']
        );

        $user = new Model\User();

        $expectedProperties = [
            'name' => 'test',
        ];

        $expectedRels = [
            'address' => new Data(
                [
                    'zipCode' => 123,
                    'location' => 'here',
                ],
                ['zipCode' => null]
            ),
        ];

        $this->assertEquals($expectedProperties, $data->getPropertiesData($user));
        $this->assertEquals($expectedRels, $data->getRelData($user));
    }

    /**
     * @covers ::getArray
     */
    public function testGetArray()
    {
        $data = new Data(
            [
                [
                    'id' => 12,
                    'name' => 'test',
                ],
                [
                    'id' => 123,
                    'name' => 'test2',
                ],
            ],
            ['name']
        );

        $expected = [
            new Data(
                [
                    'id' => 12,
                    'name' => 'test',
                ],
                ['name' => null]
            ),
            new Data(
                [
                    'id' => 123,
                    'name' => 'test2',
                ],
                ['name' => null]
            ),
        ];

        $this->assertEquals($expected, $data->getArray());
    }
}
