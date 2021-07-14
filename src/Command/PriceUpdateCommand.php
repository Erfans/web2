<?php

namespace App\Command;

use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PriceUpdateCommand extends Command
{
    protected static $defaultName = 'app:price:update';
    protected static $defaultDescription = 'A command to update the Book prices';

    /** @var BookRepository */
    private BookRepository $bookRepository;

    /** @var EntityManagerInterface */
    private EntityManagerInterface $entityManager;

    /**
     * PriceUpdateCommand constructor.
     * @param BookRepository $bookRepository
     * @param EntityManagerInterface $entityManager
     * @param string|null $name
     */
    public function __construct(
        BookRepository $bookRepository,
        EntityManagerInterface $entityManager,
        string $name = null
    )
    {
        parent::__construct($name);

        $this->bookRepository = $bookRepository;
        $this->entityManager = $entityManager;
    }


    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount of changes in the price')
            ->addOption('unit', 'u', InputOption::VALUE_OPTIONAL, 'Unit of amount (e.g. % or IRR)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $amount = $input->getArgument('amount');
        $unit = $input->getOption('unit');

        if ($unit == null) {
            $unit = "IRR";
        }

        if ($unit != "%" && $unit != "IRR") {
            $io->error("We currently only support % or IRR for Unit");
            return -1;
        }

        $this->entityManager->beginTransaction();

        $totalCount = $this->bookRepository->count([]);
        $progressed = 0;

        $progressBar = $io->createProgressBar($totalCount);
        $progressBar->start();

        try {
            while ($progressed < $totalCount) {
                $this->entityManager->clear();

                $books = $this->bookRepository->findBy([], ['id' => 'ASC'], 1000, $progressed);

                $counter = 0;
                foreach ($books as $book) {
                    $price = $book->getPrice();

                    if ($unit == "%") {
                        $price += $price * $amount;
                    } else {
                        $price += $amount;
                    }

                    $book->setPrice($price);

                    $counter++;
                    if ($counter > 100) {
                        $this->entityManager->flush();
                        $counter = 0;
                    }

                    $progressed++;
                    $progressBar->advance(1);
                }
                $this->entityManager->flush();
            }
        } catch (\Exception $exception) {
            $this->entityManager->getConnection()->rollBack();
        }

        $this->entityManager->getConnection()->commit();

        $progressBar->finish();
        $io->success('Finished');

        return 0;
    }
}
