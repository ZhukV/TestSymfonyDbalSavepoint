<?php

namespace App\Messenger;

use App\Entity\Account;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class WithdrawMoneyHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(WithdrawMoney $message): void
    {
        /** @var Account $account */
        $account = $this->entityManager->createQueryBuilder()
            ->from(Account::class, 'accounts')
            ->select('accounts')
            ->andWhere('accounts.id = :id')
            ->setParameter('id', $message->id)
            ->getQuery()
            ->setLockMode(LockMode::PESSIMISTIC_WRITE)
            ->getOneOrNullResult();

        if (!$account) {
            throw new \Exception('account was not found');
        }

        $actualBalance = $account->getBalance();
        $resultBalance = $actualBalance - $message->money;

        if ($resultBalance < 0) {
            throw new \Exception('insufficient funds');
        }

        $account->setBalance($resultBalance);
    }
}