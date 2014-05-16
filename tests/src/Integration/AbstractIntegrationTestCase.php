<?php

namespace CL\MassAssign\Test\Integration;

use CL\EnvBackup\Env;
use CL\EnvBackup\DirectoryParam;
use CL\MassAssign\Test\Repo;
use CL\MassAssign\Test\AbstractTestCase;

abstract class AbstractIntegrationTestCase extends AbstractTestCase
{
    private $env;

    public function getEnv()
    {
        return $this->env;
    }

    public function setUp()
    {
        parent::setUp();

        $this->env = new Env([
            new DirectoryParam(__DIR__.'/../../repos', [
                'Address.json' => '{
                    "1": {
                        "id": 1,
                        "name": null,
                        "zipCode": "1000",
                        "location": "test location"
                    }
                }',
                'Post.json' => '{
                    "1": {
                        "id": 1,
                        "name": "post 1",
                        "body": "my post 1",
                        "userId": 1
                    },
                    "2": {
                        "id": 2,
                        "name": "post 2",
                        "body": "my post 2",
                        "userId": 1
                    }
                }',
                'User.json' => '{
                    "1": {
                        "id": 1,
                        "name": "name",
                        "password": null,
                        "addressId": 1,
                        "isBlocked": true
                    }
                }',
                'BlogPost.json' => '{}',
            ])
        ]);

        $this->env->apply();

        Repo\User::get()->getIdentityMap()->clear();
        Repo\Address::get()->getIdentityMap()->clear();
        Repo\Post::get()->getIdentityMap()->clear();
        Repo\BlogPost::get()->getIdentityMap()->clear();
    }

    public function tearDown()
    {
        // $this->env->restore();
    }
}
