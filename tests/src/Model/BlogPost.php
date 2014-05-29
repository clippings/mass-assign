<?php

namespace Harp\MassAssign\Test\Model;

use Harp\Core\Model\AbstractModel;
use Harp\MassAssign\Test\Repo;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class BlogPost extends Post {

    public function getRepo()
    {
        return Repo\BlogPost::get();
    }

    public $url;
}
