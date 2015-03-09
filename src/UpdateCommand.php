<?php namespace CraftCli;

use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command {

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
	 * Configure the update command.
	 */
	public function configure()
	{
		$this->setName('update')
			->setDescription('Update a Craft installation.')
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
		// ask for the craft installation path

		// load the app path - fail if unable too.

		// trigger a backup in craft

		// check for the backup

		// set a temporary path using md5 on the current time?

		// copy the db.php configuration to temporary path?

		// copy the general.php configuration to temporary path?
	}

	public function loadCraft($path)
	{
	    // attempt load the craft application
	}
}