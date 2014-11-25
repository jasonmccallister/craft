<?php namespace CraftCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Process\Process;

class InstallCommand extends Command {

	/**
	* Configure the command options.
	*
	* @return void
	*/
	public function configure()
	{
		$this->setName('install')
			->setDescription('Install a new Craft website.')
			->addArgument('directory', InputArgument::REQUIRED, 'Target installation directory.');
	}

	/**
	* Execute the command.
	*
	* @param  \Symfony\Component\Console\Input\InputInterface  $input
	* @param  \Symfony\Component\Console\Output\OutputInterface  $output
	* @return void
	*/
	public function execute(InputInterface $input, OutputInterface $output)
	{
		$helper = $this->getHelper('question');

		$question = new ChoiceQuestion('Do you agree with the Craft terms and conditions? [NO]', array(
			'Yes','No'), 1);

		$question->setErrorMessage('You must agree to the terms and conditions.');

		$answer = $helper->ask($input, $output, $question);

		if ($answer == 0)
		{

			$craftUrl = "http://buildwithcraft.com/latest.zip?accept_license=yes";

			$downloadProcess = new Process("curl -L -o craft.zip $craftUrl");

			$downloadProcess->start();

			$downloadProcess->wait(function ($type, $buffer)
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

			if (!$downloadProcess->isSuccessful())
			{
				throw new \RuntimeException($downloadProcess->getErrorOutput());
			};

			$output->writeln($downloadProcess->getOutput());

			$directory = $input->getArgument('directory');

			$unzipProcess = new Process("unzip craft.zip -d $directory");

			$unzipProcess->start();

			$unzipProcess->wait(function ($type, $buffer)
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

			if (!$unzipProcess->isSuccessful())
			{
				throw new \RuntimeException($unzipProcess->getErrorOutput());
			};

			$output->writeln($unzipProcess->getOutput());

		}
	}

}
