<?php

namespace CL\MassAssign\Test;

use CL\MassAssign\AssignLinkOne;
use CL\MassAssign\UnsafeData;
use CL\LunaCore\Repo\LinkOne;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AssignLinkOneTest extends AbstractTestCase
{
    /**
     * @covers CL\MassAssign\AssignLinkOne::__construct
     * @covers CL\MassAssign\AssignLinkOne::getLink
     */
    public function testConstruct()
    {
        $link = new LinkOne(
            Repo\User::get()->getRel('address'),
            new Model\Address()
        );

        $assign = new AssignLinkOne($link);

        $this->assertSame($link, $assign->getLink());
    }

    /**
     * @covers CL\MassAssign\AssignLinkOne::execute
     */
    public function testExecute()
    {
         $link = new LinkOne(
            Repo\User::get()->getRel('address'),
            new Model\Address()
        );

        $assign = new AssignLinkOne($link);

        $data = new UnsafeData([
            'zipCode' => 123,
            'location' => 'here',
        ]);

        $assign->execute($data);

        $this->assertInstanceOf(__NAMESPACE__.'\Model\Address', $link->get());
        $this->assertEquals(123, $link->get()->zipCode);
        $this->assertEquals('here', $link->get()->location);
    }
}
