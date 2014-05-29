<?php

namespace Harp\MassAssign;

use Harp\Core\Model\AbstractModel;
use Harp\Core\Save\AbstractSaveRepo;
use InvalidArgumentException;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class UnsafeData
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var AbstractSaveRepo
     */
    protected $repo;

    /**
     * @return array
     */
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

    /**
     * @param  string     $repoClass
     * @return UnsafeData $this
     */
    public function setRepoClass($repoClass)
    {
        if (! is_subclass_of($repoClass, 'Harp\Core\Save\AbstractSaveRepo')) {
            throw new InvalidArgumentException('_repo must be a AbstractSaveRepo class');
        }

        $this->repo = $repoClass::get();

        return $this;
    }

    /**
     * @return AbstractSaveRepo
     */
    public function getRepo()
    {
        return $this->repo;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  AbstractModel $model
     * @return UnsafeData    $this
     */
    public function assignTo(AbstractModel $model)
    {
        $assign = new AssignModel($model);
        $assign->execute($this);

        return $this;
    }

    /**
     * @param  AbstractModel $model
     * @return array
     */
    public function getPropertiesData(AbstractModel $model)
    {
        $rels = $model->getRepo()->getRels();

        return array_diff_key($this->data, $rels);
    }

    /**
     * @param  AbstractModel $model
     * @return array
     */
    public function getRelData(AbstractModel $model)
    {
        $rels = $model->getRepo()->getRels();

        $relData = array_intersect_key($this->data, $rels);

        foreach ($relData as & $data) {
            $data = new UnsafeData($data);
        }

        return $relData;
    }

    /**
     * @return UnsafeData[]
     */
    public function getArray()
    {
        return array_map(function ($data) {
            return new UnsafeData($data);
        }, $this->data);
    }
}
