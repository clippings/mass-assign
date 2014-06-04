<?php

namespace Harp\MassAssign\Test;

use Harp\MassAssign\AssignLinkOne;
use Harp\MassAssign\UnsafeData;
use Harp\Core\Repo\LinkOne;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 * @coversDefaultClass Harp\MassAssign\AssignLinkOne
 */
class AssignLinkOneTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getLink
     */
    public function testConstruct()
    {
        $link = new LinkOne(
            new Model\User(),
            Repo\User::get()->getRel('address'),
            new Model\Address()
        );

        $assign = new AssignLinkOne($link);

        $this->assertSame($link, $assign->getLink());
    }

    /**
     * @covers ::execute
     */
    public function testExecute()
    {
         $link = new LinkOne(
            new Model\User(),
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
