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

		$question = new ChoiceQuestion('Do you agree with the Craft terms and conditions [NO]?', array(
			'Yes','No'), 1);

		$question->setErrorMessage("<error>You must agree to the terms and conditions.</error>");

		$answer = $helper->ask($input, $output, $question);

		$directory = getcwd() . '/' . $input->getArgument('directory');

		if ($answer == 1)
		{
			$output->writeln('<error>You must agree to the license to continue...');

			exit(1);
		}

		$this->doesDirectoryExist($directory, $output);

		$this->download($zip = $this->createZip(), $output);

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


	protected function download($zip, $output)
	{
		$response = $this->client->get('http://buildwithcraft.com/latest.zip?accept_license=yes')->getBody();

		file_put_contents($zip, $response);

		$output->writeln("<info>Downloading Craft, please grab a coffee or tea while you wait...</info>");

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
