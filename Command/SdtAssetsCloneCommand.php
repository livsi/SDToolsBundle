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

class SdtAssetsCloneCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('sdt:assets:clone')
            ->setDefinition(array(
                new InputArgument('target', InputArgument::OPTIONAL, 'The target directory', 'web'),
            ))
            ->setDescription('Installs site-level web assets under a public web directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $targetArg = rtrim($input->getArgument('target'), '/');

        if (!is_dir($targetArg)) {
            throw new \InvalidArgumentException(sprintf('The target directory "%s" does not exist.', $input->getArgument('target')));
        }

        $filesystem = $this->getContainer()->get('filesystem');
        
        $parser = new Parser();
        $site_assets = $parser->parse(file_get_contents("app/config/assets.yml"));

        foreach($site_assets['assets'] as $name=>$assets){
            if(is_file($assets['origin'])){
//                echo "file - ".$assets['target']."\n";
                $filesystem->copy($assets['origin'],$targetArg."/".$assets['target'], true);
            } elseif(is_dir($assets['origin'])){
                $filesystem->mirror($assets['origin'],$targetArg."/".$assets['target']);
            } else {
                $output->writeln(sprintf("Assets not found - <error>%s</error>", $assets['target']));
            }
            $output->writeln(sprintf("Installed assets for the <comment>%s</comment>", $name));
        }
        
        

    }

}