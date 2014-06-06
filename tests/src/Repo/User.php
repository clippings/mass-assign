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
class User extends AbstractJsonRepo {

    public static function newInstance()
    {
        return new User('Harp\MassAssign\Test\Model\User', TEST_DIR.'/User.json');
    }

    public function initialize()
    {
        $this
            ->addRels([
                new Rel\One('address', $this, Address::get()),
                new Rel\Many('posts', $this, Post::get()),
            ])
            ->setAsserts([
                new Assert\Present('name'),
            ]);
    }
}
