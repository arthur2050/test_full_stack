<?php


namespace App\Commands;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestUserCommand extends Command
{
    /** @var string $defaultName */
    protected static $defaultName = 'add-test-user';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Добавление тестового user')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();
        $user->setEmail('test@tes.ru');
        $user->setPassword('testpass');
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $output->writeln('User was created successful');
        return Command::SUCCESS;
    }
}