<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Messenger\BuyProduct;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class BuyProductController
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route(
        path: '/buy'
    )]
    public function __invoke(): Response
    {
        $message = new BuyProduct(1, 1);
        $this->messageBus->dispatch($message);

        return new Response('success buy product...');
    }
}
