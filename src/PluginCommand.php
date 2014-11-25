<?php namespace CraftCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ChoiceQuestion;

class PluginCommand extends Command {

	public function configure()
	{
		$this->setName('plugin')
		->setDescription('Create a new Craft plugin.')
		->addArgument('name', InputArgument::REQUIRED, 'Plugin name (New Plugin)')
		->addArgument('bare', InputArgument::OPTIONAL, 'Whether or not you want to create a bare plugin.');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$helper = $this->getHelper('question');

		// ask to create a controller

		$controllerQuestion = new ChoiceQuestion('Do you want to create a default controller?', array(
			'yes','no'), 1);

		$controllerAnswer = $helper->ask($input, $output, $controllerQuestion);

		if ($controllerAnswer == 0)
		{

			// check for if file exists

			// create a new controller

		}

		// ask to create a model

		$modelQuestion = new ChoiceQuestion('Do you want to create a default model?', array(
			'yes','no'), 1);

		$modelAnswer = $helper->ask($input, $output, $modelQuestion);

		if ($modelAnswer == 0)
		{

			// check for if file exists

			// create a new model

		}

		// ask to create a service

		$serviceQuestion = new ChoiceQuestion('Do you want to create a default service?', array(
			'yes','no'), 1);

		$serviceAnswer = $helper->ask($input, $output, $serviceQuestion);

		if ($serviceAnswer == 0)
		{

			// check for if file exists

			// create a new service

		}

		// ask to create a record

		$recordQuestion = new ChoiceQuestion('Do you want to create a default record?', array(
			'yes','no'), 1);

		$recordAnswer = $helper->ask($input, $output, $recordQuestion);

		if ($recordAnswer == 0)
		{

			// check for if file exists

			// create a new record

		}

	}

	// PROTECTED

	protected function doesDirectoryExist($directory)
	{
		if (file_exists($directory)) {
			return true;
		}

		return false;
	}

	protected function doesFileExist($file)
	{
		if (file_exists($file)) {
			return true;
		}

		return false;
	}

}
