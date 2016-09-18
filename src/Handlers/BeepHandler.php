<?php

namespace BeeperApi\Handlers;

use BeeperApi\Repositories\Beeps\BeepRepository;
use BeeperApi\Services\AuthService;
use BeeperApi\Services\MicroPaginator;
use BeeperApi\Validators\Beeps\CreateBeepValidator;
use Http\Request;
use Http\Response;

class BeepHandler
{
    private $request;
    private $response;
    private $beeps;
    private $authService;

    public function __construct(Request $request,
                                Response $response,
                                BeepRepository $beeps,
                                AuthService $authService)
    {
        $this->request = $request;
        $this->response = $response;
        $this->beeps = $beeps;
        $this->authService = $authService;
    }

    public function postBeep(CreateBeepValidator $validator)
    {
        $validator->validate();

        $user = $this->authService->getCurrentUser();
        $this->beeps->create($this->request->getParameters(), $user);

        $this->response->setStatusCode(201);
    }

    public function getAllBeeps(MicroPaginator $paginator)
    {
        $beeps = $this->beeps->find();
        //reverse to show newest first
        $beeps = array_reverse($beeps);

        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $results = $paginator->paginate($beeps, $page);

        $this->response->setContent($results);
    }
}