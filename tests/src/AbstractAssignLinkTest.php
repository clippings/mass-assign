<?php

namespace Harp\MassAssign\Test;

use Harp\MassAssign\AbstractAssignLink;
use Harp\MassAssign\UnsafeData;
use Harp\MassAssign\Test\Integration\AbstractIntegrationTestCase;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 * @coversDefaultClass Harp\MassAssign\AbstractAssignLink
 */
class AbstractAssignLinkTest extends AbstractIntegrationTestCase
{
    /**
     * @covers ::getRepo
     */
    public function testGetRepo()
    {
        $rel = Repo\User::get()->getRel('address');

        $assign = $this->getMockForAbstractClass('Harp\MassAssign\AbstractAssignLink');

        $data = new UnsafeData([]);

        $result = $assign->getRepo($rel, $data);

        $this->assertSame(Repo\Address::get(), $result);

        $data = new UnsafeData(['_repo' => __NAMESPACE__.'\Repo\User']);

        $result = $assign->getRepo($rel, $data);

        $this->assertSame(Repo\User::get(), $result);
    }

    /**
     * @covers ::getModel
     */
    public function testGetModel()
    {
        $rel = Repo\User::get()->getRel('address');

        $assign = $this->getMockForAbstractClass('Harp\MassAssign\AbstractAssignLink');

        $data = new UnsafeData([]);

        $result = $assign->getModel($rel, $data);

        $this->assertEquals(new Model\Address(), $result);

        $data = new UnsafeData(['_id' => 1]);

        $result = $assign->getModel($rel, $data);

        $this->assertSame(Repo\Address::get()->find(1), $result);

        $data = new UnsafeData(['_id' => 1, '_repo' => __NAMESPACE__.'\Repo\User']);

        $result = $assign->getModel($rel, $data);

        $this->assertSame(Repo\User::get()->find(1), $result);
    }
}
