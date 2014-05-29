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
class Post extends AbstractJsonRepo {

    private static $instance;

    /**
     * @return User
     */
    public static function get()
    {
        if (! self::$instance) {
            self::$instance = new Post('Harp\MassAssign\Test\Model\Post', TEST_DIR.'/Post.json');
        }

        return self::$instance;
    }

    public function initialize()
    {
        $this->addRel(new Rel\One('user', $this, Post::get()));
    }
}
