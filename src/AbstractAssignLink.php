<?php

namespace Harp\MassAssign;

use Harp\Core\Rel\AbstractRel;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class AbstractAssignLink
{
    /**
     * @return \Harp\Core\Save\AbstractSaveRepo
     */
    public function getRepo(AbstractRel $rel, UnsafeData $data)
    {
        $repo = $data->getRepo();

        if ($repo !== null) {
            return $repo;
        } else {
            return $rel->getForeignRepo();
        }
    }

    /**
     * @return \Harp\Core\Model\AbstractModel
     */
    public function getModel(AbstractRel $rel, UnsafeData $data)
    {
        $repo = $this->getRepo($rel, $data);

        if ($data->getId() !== null) {
            return $repo->find($data->getId());
        } else {
            return $repo->newModel();
        }
    }
}
