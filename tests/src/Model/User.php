<?php

namespace Harp\MassAssign\Test\Model;

use Harp\Core\Model\AbstractModel;
use Harp\MassAssign\Test\Repo;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class User extends AbstractModel {

    public function getRepo()
    {
        return Repo\User::get();
    }

    public $id;
    public $name;
    public $password;
    public $addressId;
    public $isBlocked = false;

    public function getAddress()
    {
        return $this->getRepo()->loadLink($this, 'address')->get();
    }

    public function setAddress(Address $address)
    {
        $this->getRepo()->loadLink($this, 'address')->set($address);

        return $this;
    }

    public function getPosts()
    {
        return $this->getRepo()->loadLink($this, 'posts');
    }
}
