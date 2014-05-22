<?php

namespace CL\MassAssign;

use CL\LunaCore\Repo\LinkMany;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AssignLinkMany extends AbstractAssignLink
{
    /**
     * @var LinkMany
     */
    private $link;

    public function __construct(LinkMany $link)
    {
        $this->link = $link;
    }

    /**
     * @return LinkMany
     */
    public function getLink()
    {
        return $this->link;
    }

    public function execute(UnsafeData $data)
    {
        $this->link->clear();

        foreach ($data->getArray() as $itemData) {

            $model = $this->getModel($this->link->getRel(), $itemData);

            $this->link->add($model);

            $assign = new AssignModel($model);
            $assign->execute($itemData);
        }
    }
}
