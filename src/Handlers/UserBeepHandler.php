<?php

namespace BeeperApi\Handlers;

use BeeperApi\Exceptions\ApiException;
use BeeperApi\Repositories\Beeps\BeepRepository;
use BeeperApi\Repositories\Users\UserRepository;
use BeeperApi\Services\MicroPaginator;
use Http\Request;
use Http\Response;

class UserBeepHandler
{
    private $request;
    private $response;
    private $beeps;
    private $users;

    public function __construct(Request $request,
                                Response $response,
                                BeepRepository $beeps,
                                UserRepository $users)
    {
        $this->request = $request;
        $this->response = $response;
        $this->beeps = $beeps;
        $this->users = $users;
    }


    public function getUserBeeps($username, MicroPaginator $paginator)
    {
        $user = $this->users->first(['username' => $username]);
        if (!$user)
            throw new ApiException(404);
        $beeps = $this->beeps->find(['user_id' => '57de87b362d55']);

        //reverse to show newest first
        $beeps = array_reverse($beeps);

        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $results = $paginator->paginate($beeps, $page);

        $this->response->setContent($results);
    }
}