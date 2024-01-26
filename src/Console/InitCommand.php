<?php

namespace App\Console;

use App\Entity\Account;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'init')]
class InitCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->entityManager->getConnection()->exec('TRUNCATE TABLE products');
        $this->entityManager->getConnection()->exec('TRUNCATE TABLE accounts');

        $product = new Product(1, 'Foo');
        $this->entityManager->persist($product);

        $account = new Account(1, 100.0);
        $this->entityManager->persist($account);

        $this->entityManager->flush();

        $output->writeln('Success add one product and one account for testing.');

        return 0;
    }
}