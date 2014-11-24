<?php namespace CraftCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ChoiceQuestion;

class InstallCommand extends Command {

	public function configure()
	{
		$this->setName('install')
			->setDescription('Install a new Craft website.')
			->addArgument('directory', InputArgument::REQUIRED, 'Target installation directory.');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$helper = $this->getHelper('question');
		$question = new ChoiceQuestion('Do you agree with the Craft terms and conditions? (default is no)', array(
			'yes','no'), 1);

		$question->setErrorMessage('You must agree to the terms and conditions.');

		$answer = $helper->ask($input, $output, $question);

		if ($answer == 0) {

			// install Craft
			$output->writeln('Lets install Craft!');

		}
	}
}
