<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserInitCommand extends Command
{
    protected static $defaultName = 'admin:user:init';
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();
        $this->em = $em;
        $this->encoder = $encoder;
    }


    protected function configure()
    {
        $this
            ->setDescription('admin user init')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $user = $this->em->getRepository(User::class)->find(1);
        if (!$user) {
            $user = new User();
            $user->setUsername('yoyo');
            $user->setPlainPassword('123456');
            $user->setPassword($this->encoder->encodePassword($user, $user->getPlainPassword()));
            $this->em->persist($user);
        }
        $user->setRoles(["ROLE_SUPER_ADMIN"]);

        $this->em->flush();
        $io->success('超级用户初始化完成');
    }
}
