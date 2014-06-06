<?php

namespace Harp\MassAssign\Test\Repo;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class BlogPost extends Post {

    public static function newInstance()
    {
        return new BlogPost('Harp\MassAssign\Test\Model\BlogPost', TEST_DIR.'/Post.json');
    }

    public function initialize()
    {
        parent::initialize();
    }
}
