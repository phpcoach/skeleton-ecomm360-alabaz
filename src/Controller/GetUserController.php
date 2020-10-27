<?php

/*
 * This file is part of the DriftPHP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Exception\NotFoundException;
use App\Domain\Model\User;
use App\Domain\Query\GetUser;
use Drift\CommandBus\Bus\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetUserController.
 *
 * /users/123 GET
 */
class GetUserController
{
    private $bus;

    /**
     * @param QueryBus $bus
     */
    public function __construct(QueryBus $bus)
    {
        $this->bus =  $bus;
    }

    /**
     * @param string $id
     */
    public function __invoke(string $id)
    {
        $getUser = new GetUser($id);

        return $this
            ->bus
            ->ask($getUser)
            ->then(function(User $user) {
                return new JsonResponse([
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail()
                ]);
            })
            ->otherwise(function(NotFoundException $exception) {
                return new JsonResponse([
                    'message' => $exception->getMessage()
                ], 404);
            });
    }
}
