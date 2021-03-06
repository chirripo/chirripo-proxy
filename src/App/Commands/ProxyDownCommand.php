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
                'docker-compose',
                'stop',
            ],
        ];

        foreach ($commands as $index => $command) {
            $env = [];
            if ($index === 0) {
                if (empty($_SERVER['CHIRRIPO_PROXY_PORT'])) {
                    $env['CHIRRIPO_PROXY_PORT'] = '80';
                }
                if (empty($_SERVER['CHIRRIPO_PROXY_SECURE_PORT'])) {
                    $env['CHIRRIPO_PROXY_SECURE_PORT'] = '443';
                }
                if (empty($_SERVER['CHIRRIPO_PROXY_DASHBOARD_PORT'])) {
                    $env['CHIRRIPO_PROXY_DASHBOARD_PORT'] = '8085';
                }
            }
            $process = new Process($command, __DIR__);
            $process->setTimeout(300);
            $process->run(null, $env);
        }
        $output->writeln("Proxy stopped.");
    }
}
