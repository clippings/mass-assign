<?php

namespace Harp\MassAssign;

use Harp\Core\Model\AbstractModel;
use Harp\Core\Repo\LinkOne;
use Harp\Core\Repo\LinkMany;

/*
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class AssignModel
{
    private $model;

    public function __construct(AbstractModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return AbstractModel
     */
    public function getModel()
    {
        return $this->model;
    }

    public function execute(UnsafeData $data)
    {
        $properties = $data->getPropertiesData($this->model);
        $this->model->setProperties($properties);

        $relsData = $data->getRelData($this->model);

        foreach ($relsData as $relName => $relData) {
            $link = $this->model->getRepo()->loadLink($this->model, $relName);

            if ($link instanceof LinkOne) {
                (new AssignLinkOne($link))->execute($relData);
            } elseif ($link instanceof LinkMany) {
                (new AssignLinkMany($link))->execute($relData);
            }
        }
    }
}
