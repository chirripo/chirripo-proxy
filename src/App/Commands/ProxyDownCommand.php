<?php

namespace Console\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Docker Compose Command class.
 */
class ProxyDownCommand extends Command
{
    protected function configure()
    {
        $this->setName('proxy-down')
            ->setAliases([
                'down',
            ])
            ->setDescription('Stop proxy')
            ->setHelp('Stop chirripo proxy');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = [
            [
                'docker',
                'stop',
                'chirripo_proxy',
            ],
        ];

        foreach ($commands as $command) {
            $process = new Process($command);
            $process->setTimeout(300);
            $process->run();
        }
        $output->writeln("Proxy stopped.");
    }
}
