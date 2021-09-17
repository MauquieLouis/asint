<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\MessageDigestPasswordHasher;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\DependencyInjection\ContainerInterface;
// [AsCommand(
//     name: 'app:makeAdmin',
//     description: 'Add a short description for your command',
// )]
class MakeAdminCommand extends Command
{
    
    private $container;
    
    public function __construct(PasswordHasherFactoryInterface $passwordEncode, UserRepository $uR, ContainerInterface $cI){
        $this->passwordEncoder = $passwordEncode;
        $this->uR = $uR;
        $this->cI = $cI;
        
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'username')
            ->addArgument('arg2', InputArgument::OPTIONAL, 'password')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('arg1');
        $password = $input->getArgument('arg2');
        
        $user = new User();
        $user->setUsername($username);
//         $defaultHasher = new MessageDigestPasswordHasher('sha512', true, 5000);
// //         $weakHasher = new MessageDigestPasswordHasher('md5', true, 1);
        
//         $hashers = [
//             InMemoryUser::class => $defaultHasher,
// //             LegacyUser::class   => $weakHasher,
//             // ...
//         ];
//         $hasherFactory = new PasswordHasherFactory($hashers);
//         $hasher = $hasherFactory->getPasswordHasher($user);
//         $hashedPassword = $hasher->hashPassword($user, $password);
        $user->setPassword('$2y$13$XShOeRFZxMmW/jX/5CpC6.PHsNuc9nsOVSK4YbGsGFs47tsyMZUdO');
//         $user->setPassword($this->passwordEncoder->getPasswordHasher($user));
        $user->setRoles(['ROLE_ADMIN']);
        
        $em = $this->cI->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
        
        if ($username) {
            $io->note(sprintf('You passed an argument: username : %s, password : %s', $username, $password));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
