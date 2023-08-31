<?php

namespace Symfobooster\Base\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfobooster\Base\Input\InputInterface;

class TransactionalDecorator implements ServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ServiceInterface $inner
    ) {
    }

    public function behave(InputInterface $input): mixed
    {
        return $this->entityManager->wrapInTransaction(
            fn() => $this->inner->behave($input)
        );
    }
}
