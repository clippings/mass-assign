<?php

namespace Harp\MassAssign\Test\Integration;

use Harp\MassAssign\Data;
use Harp\MassAssign\Test\Repo;

class DataTest extends AbstractIntegrationTestCase {

    public function testMassAssign()
    {
        $user = Repo\User::get()->find(1);

        $data = new Data([
            'posts' => [
                [
                    'name' => 'new title',
                    'body' => 'new body',
                ],
                [
                    '_id' => 2,
                    'name' => 'changed title 2',
                    'body' => 'changed body 2',
                ],
                [
                    '_repo' => 'Harp\MassAssign\Test\Repo\BlogPost',
                    'name' => 'blog title',
                    'body' => 'blog body',
                    'url' => 'http://example.com',
                ]
            ],
            'address' => [
                '_id' => 1,
                'zipCode' => 2222,
            ],
            'name' => 'new name!!',
        ], [
            'posts' => ['name', 'body', '_id', 'url', '_repo'],
            'address' => ['_id', 'zipCode'],
            'name',
        ]);

        $data->assignTo($user);

        Repo\User::get()->save($user);

        // $this->assertEquals(
        //     [
        //         'SELECT User.* FROM User WHERE (User.id = 3) AND (User.deletedAt IS NULL) LIMIT 1',
        //         'SELECT Post.polymorphicClass, Post.* FROM Post WHERE (userId IN (3))',
        //         'SELECT Address.* FROM Address WHERE (Address.id = 1) LIMIT 1',
        //         'INSERT INTO Post (id, title, body, price, tags, createdAt, updatedAt, publishedAt, userId, polymorphicClass) VALUES (NULL, "my title", "my body", NULL, NULL, NULL, NULL, NULL, NULL, "CL\Luna\Test\Model\Post"), (NULL, "my title 2", "my body 2", NULL, NULL, NULL, NULL, NULL, NULL, "CL\Luna\Test\Model\Post")',
        //         'UPDATE User SET name = "new name!!", addressId = 1 WHERE (User.id = 3) AND (User.deletedAt IS NULL)',
        //         'UPDATE Post SET userId = CASE id WHEN 5 THEN 3 WHEN 6 THEN 3 ELSE userId END WHERE (id IN (5, 6))',
        //         'UPDATE Post SET userId = NULL WHERE (Post.id = 4)',
        //         'UPDATE Address SET zipCode = 2222 WHERE (Address.id = 1)',
        //     ],
        //     $this->getLogger()->getEntries()
        // );
    }
}
