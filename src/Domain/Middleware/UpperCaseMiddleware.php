<?php


namespace App\Domain\Middleware;


use App\Domain\Model\User;
use App\Domain\Query\GetUser;
use Drift\CommandBus\Middleware\DiscriminableMiddleware;

class UpperCaseMiddleware implements DiscriminableMiddleware
{
    /**
     * @param GetUser  $query
     * @param Callable $next
     */
    public function execute(GetUser $query, $next)
    {
        return $next($query)
            ->then(function(User $user) {
                $name = $user->getName();
                $name = ucwords($name);
                $user->updateName($name);

                return $user;
            });
    }

    /**
     * @return array
     */
    public function onlyHandle(): array
    {
        return [
            GetUser::class
        ];
    }
}