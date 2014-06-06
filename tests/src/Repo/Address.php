<?php

namespace Harp\MassAssign\Test\Repo;

use Harp\JsonStore\AbstractJsonRepo;
use Harp\JsonStore\Rel;
use Harp\Validate\Assert;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Address extends AbstractJsonRepo {

    public static function newInstance()
    {
        return new Address('Harp\MassAssign\Test\Model\Address', TEST_DIR.'/Address.json');
    }

    public function initialize()
    {
        $this->addRel(new Rel\One('user', $this, Address::get()));
    }
}
