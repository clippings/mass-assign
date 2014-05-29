<?php

namespace Harp\MassAssign\Test\Repo;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class BlogPost extends Post {

    private static $instance;

    /**
     * @return User
     */
    public static function get()
    {
        if (! self::$instance) {
            self::$instance = new BlogPost('Harp\MassAssign\Test\Model\BlogPost', TEST_DIR.'/Post.json');
        }

        return self::$instance;
    }

    public function initialize()
    {
        parent::initialize();
    }
}
