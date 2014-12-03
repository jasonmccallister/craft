<?php namespace CraftCli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ChoiceQuestion;
use GuzzleHttp\ClientInterface;
use ZipArchive;

class InstallCommand extends Command {

	private $client;

	public function __construct(ClientInterface $client)
	{
		$this->client = $client;

		parent::__construct();
	}

	public function configure()
	{
		$this->setName('install')
			->setDescription('Install a new Craft website.')
			->addArgument('directory', InputArgument::REQUIRED, 'Target installation directory.');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$helper = $this->getHelper('question');

		$question = new ChoiceQuestion('Do you agree with the terms and conditions for Craft (n)?', array(
			'y' => 'yes','n' => 'no'), n);

		$question->setErrorMessage('<error>You must agree to the terms and conditions.</error>');

		$answer = $helper->ask($input, $output, $question);

		$directory = getcwd() . '/' . $input->getArgument('directory');

		if ($answer == no)
		{
			$output->writeln('<error>You must agree with the terms and conditions to continue!</error>');

			$output->writeln('<info>Craft License is located here: http://buildwithcraft.com/license</info>');

			exit(1);
		}

		$this->doesDirectoryExist($directory, $output);

		$this->download($output, $zip = $this->createZip());

		$this->unzip($zip, $directory);

		$this->cleanUp($zip);

		$output->writeln('<comment>Craft installed and ready to rock!!!</comment>');
	}

	protected function doesDirectoryExist($directory, OutputInterface $output)
	{
		if (is_dir($directory))
		{
			$output->writeln('<error>Whoops... directory already exists!</error>');

			exit(1);
		}
	}

	protected function createZip()
	{
		return getcwd() . '/craft_' . md5(time()) . '.zip';
	}


	protected function download($output, $zip)
	{
		$output->writeln("<info>Downloading Craft, please grab a coffee or tea while you wait...</info>");

		$response = $this->client->get('http://buildwithcraft.com/latest.zip?accept_license=yes')->getBody();

		file_put_contents($zip, $response);

		return $this;
	}

	protected function unzip($zip, $directory)
	{
		$archive = new ZipArchive;

		$archive->open($zip);
		$archive->extractTo($directory);
		$archive->close();

		return $this;
	}

	protected function cleanUp($zip)
	{
		unlink($zip);
	}

}
