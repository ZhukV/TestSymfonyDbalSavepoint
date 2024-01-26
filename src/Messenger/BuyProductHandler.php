<?php

namespace App\Messenger;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class BuyProductHandler
{
    public function __construct(private EntityManagerInterface $entityManager, private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(BuyProduct $message): void
    {
        $product = $this->entityManager->find(Product::class, $message->productId);

        $withdrawMessage = new WithdrawMoney($message->accountId, $product->getPrice());
        $this->messageBus->dispatch($withdrawMessage);

        // @todo: other operations...
    }
}
