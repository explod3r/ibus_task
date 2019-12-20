<?php

namespace App\Command;

use Opis\JsonSchema\Validator;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\ValidationError;
use Opis\JsonSchema\Schema;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ValidateJsonCommand extends Command
{
    protected static $defaultName = 'app:validate-json';

    protected function configure()
    {
        $this
            ->setDescription('Validates screaped json with schema.json');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = json_decode(file_get_contents('http://127.0.0.1:8000/api/scraper'));
        $schema = Schema::fromJsonString(file_get_contents('https://gist.githubusercontent.com/aur1mas/a782bd72bd30599970f0111612fce908/raw/b3a24e20dce91cfb162c47f533dadf431e32a69e/schema.json'));

        $validator = new Validator();

        foreach ($data->offers as $offer) {
            $result = $validator->schemaValidation($offer, $schema);
    
            if ($result->isValid()) {
                $output->writeLn('JSON is valid');
            } else {
                $error = $result->getFirstError();
                $output->writeLn('JSON is invalid');
                $output->writeLn('Error: '.$error->keyword());
                $output->writeLn(json_encode($error->keywordArgs(), JSON_PRETTY_PRINT));
            }
        }

        return 0;
    }
}
