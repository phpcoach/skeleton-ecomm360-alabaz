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

use App\Domain\Command\DeleteUser;
use Drift\CommandBus\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * /users/123 DELETE
 */
class DeleteUserController
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
     * @param string $id
     */
    public function __invoke(string $id)
    {
        $deleteUser = new DeleteUser($id);

        return $this
            ->bus
            ->execute($deleteUser)
            ->then(function() {
                return new JsonResponse('User deleted');
            });
    }
}
