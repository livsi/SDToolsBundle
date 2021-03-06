<?php
//src/Acme/CrudGeneratorBundle/Command/MyDoctrineCrudCommand.php

namespace Livsi\SDToolsBundle\Command;

use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;

class SdtGenerateCrudCommand extends \Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('sdt:generate:crud');
    }

    protected function getGenerator()
    {
        $app_path = $this->getContainer()->get('kernel')->getRootDir();
        $generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), $app_path.'/Resources/skeleton/crud');
        $this->setGenerator($generator);
        return parent::getGenerator();
    }
}