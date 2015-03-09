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
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 */
	public function execute(InputInterface $input, OutputInterface $output)
	{

	}
}