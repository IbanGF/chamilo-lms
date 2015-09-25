<?php

/**
 * This file is part of the DigitalOcean library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DigitalOcean\CLI\Domains;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use DigitalOcean\CLI\Command;

/**
 * Command-line domains:records:add class.
 *
 * @author Antoine Corcy <contact@sbin.dk>
 */
class AddRecordCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('domains:records:add')
            ->addArgument('id', InputArgument::REQUIRED, 'The id or the name of the domain')
            ->addArgument('record_type', InputArgument::REQUIRED, 'The type of record you would like to create between A, CNAME, NS, TXT, MX and SRV')
            ->addArgument('data', InputArgument::REQUIRED, 'The value of the record')
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the record required for A, CNAME, TXT and SRV')
            ->addArgument('priority', InputArgument::OPTIONAL, 'The priority of the record required for SRV and MX')
            ->addArgument('port', InputArgument::OPTIONAL, 'The port of the record required for SRV')
            ->addArgument('weight', InputArgument::OPTIONAL, 'The weight of the record requiret for SRV')
            ->setDescription('Add a new record to a specific domain')
            ->addOption('credentials', null, InputOption::VALUE_REQUIRED,
                'If set, the yaml file which contains your credentials', Command::DEFAULT_CREDENTIALS_FILE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $digitalOcean = $this->getDigitalOcean($input->getOption('credentials'));
        $record       = $digitalOcean->domains()->newRecord($input->getArgument('id'), array(
            'record_type' => $input->getArgument('record_type'),
            'data'        => $input->getArgument('data'),
            'name'        => $input->getArgument('name'),
            'priority'    => $input->getArgument('priority'),
            'port'        => $input->getArgument('port'),
            'port'        => $input->getArgument('port'),
            'weight'      => $input->getArgument('weight'),
        ));

        $content   = array();
        $content[] = array(
            $record->status,
            $record->domain_record->id,
            $record->domain_record->domain_id,
            $record->domain_record->record_type,
            $record->domain_record->name,
            $record->domain_record->data,
            $record->domain_record->priority,
            $record->domain_record->port,
            $record->domain_record->weight,
        );
        $table = $this->getHelperSet()->get('table');
        $table
            ->setHeaders(array('Status', 'ID', 'Domain ID', 'Type', 'Name', 'Data', 'Priority', 'Port', 'Weight'))
            ->setRows($content);

        $table->render($output);
    }
}
