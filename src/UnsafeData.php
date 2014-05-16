<?php

namespace CL\MassAssign;

use CL\LunaCore\Model\AbstractModel;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class UnsafeData
{
    protected $data;
    protected $id;
    protected $repo;

    public function all()
    {
        return $this->data;
    }

    public function __construct(array $data)
    {
        if (isset($data['_id'])) {
            $this->id = $data['_id'];
        }

        if (isset($data['_repo'])) {
            $this->setRepoClass($data['_repo']);
        }

        unset($data['_repo'], $data['_id']);

        $this->data = $data;
    }

    public function setRepoClass($repoClass)
    {
        if (! is_subclass_of($repoClass, 'CL\LunaCore\Repo\AbstractRepo')) {
            throw new InvalidArgumentException('_repo must be a AbstractRepo class');
        }

        $this->repo = $repoClass::get();

        return $this;
    }

    public function getRepo()
    {
        return $this->repo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function assignTo(AbstractModel $node)
    {
        $assign = new AssignModel($node);
        $assign->execute($this);

        return $this;
    }

    public function getPropertiesData(AbstractModel $node)
    {
        $rels = $node->getRepo()->getRels()->all();

        return array_diff_key($this->data, $rels);
    }

    public function getRelData(AbstractModel $node)
    {
        $rels = $node->getRepo()->getRels()->all();

        $relData = array_intersect_key($this->data, $rels);

        foreach ($relData as & $data) {
            $data = new UnsafeData($data);
        }

        return $relData;
    }

    public function getArray()
    {
        return array_map(function ($data) {
            return new UnsafeData($data);
        }, $this->data);
    }
}
