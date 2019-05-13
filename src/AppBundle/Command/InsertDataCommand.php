<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class InsertDataCommand extends ContainerAwareCommand
{

    CONST COMMAND = 'insert:data';

    CONST START = 'Début de l\'insertion des datas dans la table ingrédient';

    CONST ERROR = 'Erreur lors de l\'insertion des données, verifier le fichier !';

    CONST END = 'Fin de l\'insertion des datas dans la table ingrédient';

    protected $container;
    protected $em;


    public function __construct(Container $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(self::COMMAND)
            ->setDescription('Update Database with data')
            ->setHelp('Insert data in database with path file sql')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('path', 'p', InputOption::VALUE_REQUIRED, 'the path of filename', 'relative_path/dump.sql')
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln(
            self::START
        );

        $pathFile = $input->getOption('path');
        $ext = $this->get_extension($pathFile);
        $response = '';

        if ($ext != 'sql') {
            $response = 'Le fichier reçu n\'est pas un fichier sql';

            $output->writeln([
                sprintf(self::ERROR),
                $response
            ]);

        } else {

            $this->container = $this->getApplication()->getKernel()->getContainer();
            $this->em = $this->container->get('doctrine')->getManager();

            $db = $this->em->getConnection();

            $contentSql = file_get_contents($pathFile);
            $db->executeUpdate($contentSql);

            $response = 'Le fichier reçu est un fichier sql, le traitement est en cours';

            $output->writeln([
                sprintf(self::END),
                $response
            ]);
        }

    }


    private function get_extension($file) {
        $extension = explode(".", $file);
        return $extension[1];
    }

}
