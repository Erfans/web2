<?php

namespace App\Command;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class PriceReportCommand extends Command
{
    protected static $defaultName = 'app:price:report';
    protected static $defaultDescription = 'Add a short description for your command';

    /** @var BookRepository */
    private BookRepository $bookRepository;

    /** @var EntityManagerInterface */
    private EntityManagerInterface $entityManager;
    private Filesystem $filesystem;

    /**
     * PriceUpdateCommand constructor.
     * @param BookRepository $bookRepository
     * @param EntityManagerInterface $entityManager
     * @param string|null $name
     */
    public function __construct(
        BookRepository $bookRepository,
        EntityManagerInterface $entityManager,
        Filesystem $filesystem,
        string $name = null
    )
    {
        parent::__construct($name);

        $this->bookRepository = $bookRepository;
        $this->entityManager = $entityManager;
        $this->filesystem = $filesystem;
    }


    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $result = $this->bookRepository->createQueryBuilder("b")
            ->select("min(b.price) as min")
            ->addSelect("max(b.price) as max")
            ->addSelect("avg(b.price) as avg")
            ->getQuery()
            ->getArrayResult();

        $result = $result[0];


        $buffered = new BufferedOutput();
        $table = new Table($buffered);
        $table->setHeaders(["min", "max", "avg"]);
        $table->setRows([
            [
                $result["min"],
                $result["max"],
                $result["avg"],
            ]
        ]);
        $table->setStyle("box-double");
        $table->render();

        $this->filesystem->appendToFile("/var/www/html/var/report.txt", $buffered->fetch());

        return 0;
    }
}
