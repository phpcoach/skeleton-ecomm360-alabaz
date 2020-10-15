<?php


namespace App\Domain\QueryHandler;


use App\Domain\Exception\NotFoundException;
use App\Domain\Model\User;
use App\Domain\Query\GetUser;
use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

class GetUserHandler
{
    /**
     * @param GetUser $getUser
     *
     * @return PromiseInterface<User>
     */
    public function handle(GetUser $getUser) : PromiseInterface
    {
        if ($getUser->getId() === "10") {
            $exception = new NotFoundException('User ' . $getUser->getId() . ' not found');

            return reject($exception);
        }

        return resolve(new User(
            $getUser->getId(),
            'engonga',
            'hola@kease.com'
        ));
    }
}