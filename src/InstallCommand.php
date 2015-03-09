<?php namespace CraftCli;

use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use ZipArchive;

class InstallCommand extends Command {

	/**
	 * @var ClientInterface
	 */
	private $client;

	/**
	 * Create a new instance.
	 *
	 * @param ClientInterface $client
	 */
	public function __construct(ClientInterface $client)
	{
		$this->client = $client;

		parent::__construct();
	}

	/**
	 * Configure the command.
	 */
	public function configure()
	{
		$this->setName('install')
			->setDescription('Create a new Craft installation.')
			->addArgument('directory', InputArgument::REQUIRED, 'Target installation directory.');
	}

	/**
	 * Execute the command.
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	public function execute(InputInterface $input, OutputInterface $output)
	{
		$helper = $this->getHelper('question');

		$question = new ChoiceQuestion('Do you agree with the terms and conditions for Craft (n)?', ['y' => 'yes', 'n' => 'no'], n);

		$question->setErrorMessage('<error>You must agree to the terms and conditions.</error>');

		$answer = $helper->ask($input, $output, $question);

		$directory = getcwd() . '/' . $input->getArgument('directory');

		if ($answer == no) {
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

	/**
	 * Check if the installation directory already exists.
	 *
	 * @param $directory
	 * @param OutputInterface $output
	 */
	protected function doesDirectoryExist($directory, OutputInterface $output)
	{
		if (is_dir($directory)) {
			$output->writeln('<error>Whoops... directory already exists!</error>');

			exit(1);
		}
	}

	/**
	 * Create the zip filename for the installation package.
	 *
	 * @return string
	 */
	protected function createZip()
	{
		return getcwd() . '/craft_' . md5(time()) . '.zip';
	}


	/**
	 * Download the latest version of Craft.
	 *
	 * @param $output
	 * @param $zip
	 * @return $this
	 */
	protected function download($output, $zip)
	{
		$output->writeln("<info>Downloading Craft, please grab a coffee or tea while you wait...</info>");

		$response = $this->client->get('http://buildwithcraft.com/latest.zip?accept_license=yes')->getBody();

		file_put_contents($zip, $response);

		return $this;
	}

	/**
	 * Unzip the new Craft installation.
	 *
	 * @param $zip
	 * @param $directory
	 * @return $this
	 */
	protected function unzip($zip, $directory)
	{
		$archive = new ZipArchive;

		$archive->open($zip);
		$archive->extractTo($directory);
		$archive->close();

		return $this;
	}

	/**
	 * Clean up the zip.
	 *
	 * @param $zip
	 */
	protected function cleanUp($zip)
	{
		unlink($zip);
	}

}
