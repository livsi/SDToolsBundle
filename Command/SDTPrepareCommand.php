<?php

namespace Livsi\SDToolsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Parser;

class SDTPrepareCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('sdt:prepare')
            ->setDefinition(array(
            new InputArgument('target', InputArgument::OPTIONAL, 'The target directory', 'app'),
        ))
            ->setDescription('Prepare site-level tools for development');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $targetArg = rtrim($input->getArgument('target'), '/');

        if (!is_dir($targetArg)) {
            throw new \InvalidArgumentException(sprintf('The target directory "%s" does not exist.', $input->getArgument('target')));
        }

        $container = $this->getContainer();
        $kernel = $container->get('kernel');
        $filesystem = $container->get('filesystem');

        $originalPath = $kernel->locateResource('@SensioGeneratorBundle/Resources/skeleton');

        $filesystem->mirror($originalPath,$targetArg."/Resources/skeleton", Finder::create()->in($originalPath));

        $output->writeln("Copied skeleton folder for <comment>development</comment>");

        $filesystem->copy($kernel->locateResource('@LivsiSDToolsBundle/Resources/config/assets.yml'), $targetArg."/config/assets.yml",
            true);

        $output->writeln("Copied assets.yml for <comment>site-level assets clone</comment>");
    }

}