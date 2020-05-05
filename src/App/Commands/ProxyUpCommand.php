<?php

namespace Console\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Console\Output\ConsoleOutput;
use Robo\Runner;

/**
 * Docker Compose Command class.
 */
class ProxyUpCommand extends Command
{
    protected function configure()
    {
        $this->setName('proxy-up')
            ->setAliases([
                'up',
            ])
            ->setDescription('Start proxy')
            ->setHelp('Start chirripo proxy');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = [
            [
                'docker',
                'network',
                'create',
                'chirripo_proxy',
            ],
            [
                'docker-compose',
                'stop',
            ],
            [
                'docker-compose',
                'up',
                '-d',
            ],
        ];

        foreach ($commands as $index => $command) {
            $process = new Process($command, __DIR__);
                $process->setTimeout(300);
                $process->run();

                // Executes after the command finishes.
                if ($index > 1  && !$process->isSuccessful()) {
                    // Allow silent fail on stop command.
                    $output->writeln(sprintf(
                        "\n\nOutput:\n================\n%s\n\nError Output:\n================\n%s",
                        $process->getOutput(),
                        $process->getErrorOutput()
                    ));
                    exit(1);
                }
        }
        $output->writeln("Proxy started.");
    }
}
