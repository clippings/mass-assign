<?php

namespace CL\MassAssign\Test\Repo;

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
            self::$instance = new BlogPost('CL\MassAssign\Test\Model\BlogPost');
        }

        return self::$instance;
    }

    public function initialize()
    {
        parent::initialize();
    }
}
