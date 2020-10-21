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

use App\Domain\Command\PutUser;
use App\Domain\Model\User;
use Drift\CommandBus\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetUserController.
 *
 * /users/123 PUT
 */
class PutUserController
{
    private $bus;

    /**
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus)
    {
        $this->bus =  $bus;
    }

    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id');
        $body = json_decode($request->getContent(), true);
        $user = new User($id, $body['name'], $body['email']);
        $putUser = new PutUser($user);

        return $this
            ->bus
            ->execute($putUser)
            ->then(function() {
                return new JsonResponse('User put');
            });
    }
}
