<?php

namespace AppBundle\Command;

use AppBundle\Entity\SubUnit;
use AppBundle\Entity\Unit;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadUnitesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:load')
            ->setDescription('Load units data');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $subUnits    = [
            'Bouquetins'    => 'BS 1',
            'Lynx'          => 'BS 1',
            'Aigles'        => 'BS 1',
            'Castors'       => 'BS 1',
            'Loups'         => 'BS 2',
            'Hermines'      => 'BS 2',
            'Eperviers'     => 'BS 2',
            'Ours'          => 'BS 2',
            'Taureaux'      => 'BS 2',
            'Antilopes'     => 'BS 5',
            'Cigognes'      => 'BS 5',
            'Hérons'        => 'BS 5',
            'Renards'       => 'BS 5',
            'Loutres'       => 'BS 5',
            'Chauves-souris'=> 'BS 5',
            'Rennes'        => 'BS 6',
            'Marmottes'     => 'BS 6',
            'Poussins-Coqs' => 'BS 6',
            'Cygnes'        => 'BS 6',
            'Yacks'         => 'BS 6',
            'Panthères'     => 'BS 7',
            'Koalas'        => 'BS 7',
            'Cerfs'         => 'BS 7',
            'Faucons'       => 'BS 7',
            'Léopards'      => 'BS 7',
            'Surcouf'       => 'BS 8',
            'Jean-Bart'     => 'BS 8',
            'Frégate'       => 'BS 8',
            'Galion'        => 'BS 8',
            'Phénix'        => 'BS 9',
            'Cobras'        => 'BS 9',
            'Tigres'        => 'BS 9',

            'Hirondelles'       => 'BS 10',
            'Ratons-Laveurs'    => 'BS 10',
            'Goélands'          => 'BS 10',
            'Pandas'            => 'BS 10',
            'Gazelles'          => 'BS 10',
            'Licornes'          => 'BS 11',
            'Fennecs'           => 'BS 11',
            'Okapis'            => 'BS 11',
            'Kangourous'        => 'BS 11',
            'Chevreuils'        => 'BS 11',
            'Impalas'           => 'BS 12',
            'Mangoustes'        => 'BS 12',
            'Coyotes'           => 'BS 12',
            'Caméléons'         => 'BS 12',
            'Oryx'              => 'BS 13',
            'Condors'           => 'BS 13',
            'Irbis'             => 'BS 13'
        ];

        $units    = [

            'BS 1'  => ['Zanfleuron',   Unit::HOMME, Unit::TROUPE],
            'BS 2'  => ['Manloud',      Unit::HOMME, Unit::TROUPE],
            'BS 5'  => ['La Neuvaz',    Unit::HOMME, Unit::TROUPE],
            'BS 6'  => ['Chandelard',   Unit::HOMME, Unit::TROUPE],
            'BS 7'  => ['Berisal',      Unit::HOMME, Unit::TROUPE],
            'BS 8'  => ['Montfort',     Unit::HOMME, Unit::TROUPE],
            'BS 9'  => ['Lovegno',      Unit::HOMME, Unit::TROUPE],
            'BS 10' => ['Solalex',      Unit::FEMME, Unit::TROUPE],
            'BS 11' => ['Grammont',     Unit::FEMME, Unit::TROUPE],
            'BS 12' => ['Armina',       Unit::FEMME, Unit::TROUPE],
            'BS 13' => ['Santis',       Unit::FEMME, Unit::TROUPE]
        ];

        $sizaines   = [

            'Panthères (lvtx)'  => 'BSL 1',
            'Koalas (lvtx)'     => 'BSL 1',
            'Renards'           => 'BSL 1',
            'Kangourous'        => 'BSL 1',
            'Ours (lvtx)'       => 'BSL 2',
            'Dauphins'          => 'BSL 2',
            'Chevaux'           => 'BSL 2',

            'Panthères (lvttes)'    => 'BSLe 1',
            'Chouettes'             => 'BSLe 1',
            'Ours (lvttes)'         => 'BSLe 1',
            'Elephants'             => 'BSLe 1',
            'Opossums'              => 'BSLe 2',
            'Koalas (lvttes)'       => 'BSLe 2',
            'Wombats'               => 'BSLe 2',
            'Quokkas'               => 'BSLe 2'
        ];

        $meutes     = [

            'BSL 1'  => ["Mont d'or",    Unit::HOMME, Unit::MEUTE],
            'BSL 2'  => ["Clairière",    Unit::HOMME, Unit::MEUTE],
            'BSLe 1' => ["Chenaulaz",    Unit::FEMME, Unit::MEUTE],
            'BSLe 2' => ["Cabéru",       Unit::FEMME, Unit::MEUTE],
        ];

        foreach($units as $abbr => $data) {

            $unit = new Unit();
            $unit->setAbbreviation($abbr)
                ->setNom($data[0])
                ->setSexe($data[1])
                ->setType($data[2]);

            foreach($subUnits as $name => $trp) {
                if($trp === $abbr) {

                    $subUnit = new SubUnit();
                    $subUnit->setNom($name);
                    $subUnit->setUnit($unit);
                    $em->persist($subUnit);
                }
            }

            $em->persist($unit);
        }

        foreach($meutes as $abbr => $data) {

            $unit = new Unit();
            $unit->setAbbreviation($abbr)
                ->setNom($data[0])
                ->setSexe($data[1])
                ->setType($data[2]);

            foreach($sizaines as $name => $trp) {
                if($trp === $abbr) {
                    $subUnit = new SubUnit();
                    $subUnit->setNom($name);
                    $subUnit->setUnit($unit);
                    $em->persist($subUnit);
                }
            }

            $em->persist($unit);
        }

        $em->flush();
    }
}
