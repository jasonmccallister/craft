<?php namespace CraftCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Process\Process;

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

		if ($answer == 0)
		{

			$craftUrl = "http://buildwithcraft.com/latest.zip?accept_license=yes";

			$process = new Process("curl -L -o craft.zip $craftUrl");

			$process->start();

			$process->wait(function ($type, $buffer)
			{

				if (Process::ERR === $type)
				{
					echo $buffer;
				}

				else
				{
					$output->writeln($buffer);
				}

			});

			// executes after the command finishes
			if (!$process->isSuccessful())
			{
				throw new \RuntimeException($process->getErrorOutput());
			};

			$output->writeln($process->getOutput());

			// TODO unzip the craft.zip

			// TODO move to the installation directory

		}
	}

}
