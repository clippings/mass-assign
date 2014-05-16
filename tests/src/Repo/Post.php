<?php

namespace CL\MassAssign\Test\Repo;

use CL\MassAssign\Test\Rel;
use CL\Carpo\Assert;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Post extends AbstractTestRepo {

    private static $instance;

    /**
     * @return User
     */
    public static function get()
    {
        if (! self::$instance) {
            self::$instance = new Post('CL\MassAssign\Test\Model\Post');
        }

        return self::$instance;
    }

    public function initialize()
    {
        $this
            ->setRels([
                new Rel\One('user', $this, Post::get()),
            ]);
    }
}
