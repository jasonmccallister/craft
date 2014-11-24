<?php namespace CraftCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class UpdateCommand extends Command {

	public function configure()
	{
		$this->setName('update')
		->setDescription('Update an existing Craft website.')
		->addArgument('directory', InputArgument::REQUIRED, 'Installation directory (to public index.php).');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('updating!');
	}
}
