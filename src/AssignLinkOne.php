<?php

namespace Harp\MassAssign;

use Harp\Core\Repo\LinkOne;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AssignLinkOne extends AbstractAssignLink
{
    /**
     * @var LinkOne
     */
    private $link;

    public function __construct(LinkOne $link)
    {
        $this->link = $link;
    }

    /**
     * @return LinkOne
     */
    public function getLink()
    {
        return $this->link;
    }

    public function execute(UnsafeData $data)
    {
        $model = $this->getModel($this->link->getRel(), $data);

        $this->link->set($model);

        $assign = new AssignModel($model);
        $assign->execute($data);
    }
}
