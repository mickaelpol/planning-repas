<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class InsertDataCommand extends ContainerAwareCommand
{

    CONST COMMAND = 'insert:data';

    CONST COMMAND_USER = 'fos:user:create';

    CONST START_USER = 'Création d\'un utilisateur administrateur';

    CONST END_USER = 'Fin de la création de l\'utilisateur administrateur';

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
                    new InputOption('path', 'p', InputOption::VALUE_REQUIRED, 'the path of filename', 'relative_path/dump.sql'),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // this parts insert data with file pass in arguments
        $output->writeln(
            '<question>' . self::START . '</question>'
        );

        $pathFile = $input->getOption('path');
        $ext = $this->get_extension($pathFile);
        $response = '';

        if ($ext != 'sql') {
            $response = 'Le fichier reçu n\'est pas un fichier sql';

            $output->writeln([
                sprintf('<error>' . self::ERROR . '</error>'),
                '<error>$response</error>',
            ]);

        } else {

            $this->container = $this->getApplication()->getKernel()->getContainer();
            $this->em = $this->container->get('doctrine')->getManager();

            $db = $this->em->getConnection();

            $contentSql = file_get_contents($pathFile);
            $db->executeUpdate($contentSql);

            $response = 'Le fichier reçu est un fichier sql, le traitement est en cours';

            $output->writeln([
                sprintf('<info>' . $response . '</info>'),
                '<info>' . self::END . '</info>',
            ]);
        }

    }


    private function get_extension($file)
    {
        $extension = explode(".", $file);
        return $extension[1];
    }

}
