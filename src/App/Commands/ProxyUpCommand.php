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
                'stop',
                'chirripo_proxy',
            ],
            [
                'docker',
                'rm',
                'chirripo_proxy',
            ],
            [
                'docker',
                'network',
                'create',
                'chirripo_proxy',
            ],
            [
                'docker',
                'run',
                '-d',
                '-p',
                '8085:8080',
                '-p',
                '80:80',
                '-v',
                $_SERVER['PWD'] . '/traefik.toml:/etc/traefik/traefik.toml',
                '-v',
                '/var/run/docker.sock:/var/run/docker.sock',
                '--network',
                'chirripo_proxy',
                '--name',
                'chirripo_proxy',
                'traefik:v1.7',
            ],
        ];

        foreach ($commands as $index => $command) {
            $process = new Process($command);
                $process->setTimeout(300);
                $process->run();

                // Executes after the command finishes.
                if ($index >= 3  && !$process->isSuccessful()) {
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
