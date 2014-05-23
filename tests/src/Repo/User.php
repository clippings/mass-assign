<?php

namespace CL\MassAssign\Test\Repo;

use CL\LunaJsonStore\AbstractJsonRepo;
use CL\LunaJsonStore\Rel;
use CL\Carpo\Assert;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class User extends AbstractJsonRepo {

    private static $instance;

    /**
     * @return User
     */
    public static function get()
    {
        if (! self::$instance) {
            self::$instance = new User('CL\MassAssign\Test\Model\User', TEST_DIR.'/User.json');
        }

        return self::$instance;
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
