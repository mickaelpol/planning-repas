<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminCommand extends ContainerAwareCommand
{

    CONST COMMAND = 'create:admin';

    CONST FOS_COMMAND = 'fos:user:create';

    CONST FOS_COMMAND_PROMOTE = 'fos:user:promote';

    protected function configure()
    {
        $this
            ->setName(self::COMMAND)
            ->setDescription('Create an Administrator of web site')
            ->setHelp('Insert data in database with path file sql')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('username', 'u', InputOption::VALUE_REQUIRED, 'the username of user', 'Mickael'),
                    new InputOption('mail', 'm', InputOption::VALUE_REQUIRED, 'the mail of user', 'mickael@gmail.com'),
                    new InputOption('password', 'p', InputOption::VALUE_REQUIRED, 'the password of user', 'motdepasse'),
                    new InputOption('role', 'r', InputOption::VALUE_REQUIRED, 'the rôle of user', 'ROLE_USER'),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $input->getOption('username');
        $email = $input->getOption('mail');
        $password = $input->getOption('password');
        $role = $input->getOption('role');

        // This part create user
        $cmd = $this->getApplication()->find(self::FOS_COMMAND);
        $arguments = [
            'command'  => self::FOS_COMMAND,
            'username' => $user,
            'email'    => $email,
            'password' => $password,
        ];
        $greetInput = new ArrayInput($arguments);
        $returnCode = $cmd->run($greetInput, $output);

        // This part promote user to role passed to option
        $cmdPromote = $this->getApplication()->find(self::FOS_COMMAND_PROMOTE);
        $argumentsRole = [
            'command'  => self::FOS_COMMAND_PROMOTE,
            'username' => $user,
            'role'     => $role,
        ];

        $promoteInput = new ArrayInput($argumentsRole);
        $returnCode = $cmdPromote->run($promoteInput, $output);


        $output->writeln([
            sprintf('<info>L\'utilisateur %s à bien été créer ! et à comme role, le role: %s</info>', $user, $role) . PHP_EOL,
        ]);
    }

}
