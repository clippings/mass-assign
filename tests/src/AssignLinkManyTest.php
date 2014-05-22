<?php

namespace CL\MassAssign\Test;

use CL\MassAssign\AssignLinkMany;
use CL\MassAssign\UnsafeData;
use CL\LunaCore\Repo\LinkMany;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AssignLinkManyTest extends AbstractTestCase
{
    /**
     * @covers CL\MassAssign\AssignLinkMany::__construct
     * @covers CL\MassAssign\AssignLinkMany::getLink
     */
    public function testConstruct()
    {
        $link = new LinkMany(
            Repo\User::get()->getRel('posts'),
            []
        );

        $assign = new AssignLinkMany($link);

        $this->assertSame($link, $assign->getLink());
    }

    /**
     * @covers CL\MassAssign\AssignLinkMany::execute
     */
    public function testExecute()
    {
         $link = new LinkMany(
            Repo\User::get()->getRel('posts'),
            []
        );

        $assign = new AssignLinkMany($link);

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

        $assign->execute($data);

        $this->assertEquals(
            [
                (new Model\Post())->setProperties(['id' => 12, 'name' => 'test']),
                (new Model\Post())->setProperties(['id' => 123, 'name' => 'test2']),
            ],
            $link->toArray()
        );
    }
}
