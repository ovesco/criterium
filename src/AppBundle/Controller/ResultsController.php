<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participant;
use AppBundle\Entity\SubUnit;
use AppBundle\Entity\Unit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResultsController extends Controller
{
    /**
     * @Route("/results/eclaireurs", name="app.results.eclaireurs")
     */
    public function resultsEclaireursAction() {

        $em             = $this->getDoctrine()->getManager();
        $troupes        = $em->getRepository('AppBundle:Unit')->findBy(array('type' => Unit::TROUPE));
        $patrouilles    = $em->getRepository('AppBundle:SubUnit')->createQueryBuilder('su')
            ->leftJoin('su.unit', 'u')
            ->where('u.type = :type')
            ->setParameter('type', Unit::TROUPE)
            ->getQuery()->getResult();

        $participants   = $em->getRepository('AppBundle:Participant')->createQueryBuilder('p')
            ->leftJoin('p.subUnit', 'su')
            ->leftJoin('su.unit', 'u')
            ->where('u.type = :type')
            ->setParameter('type', Unit::TROUPE)
            ->getQuery()->getResult();

        return $this->resultsAction($participants, $troupes, $patrouilles);
    }

    /**
     * @Route("/results/louveteaux", name="app.results.louveteaux")
     */
    public function resultsLouveteauxAction() {

        $em             = $this->getDoctrine()->getManager();
        $troupes        = $em->getRepository('AppBundle:Unit')->findBy(array('type' => Unit::MEUTE));
        $patrouilles    = $em->getRepository('AppBundle:SubUnit')->createQueryBuilder('su')
            ->leftJoin('su.unit', 'u')
            ->where('u.type = :type')
            ->setParameter('type', Unit::MEUTE)
            ->getQuery()->getResult();

        $participants   = $em->getRepository('AppBundle:Participant')->createQueryBuilder('p')
            ->leftJoin('p.subUnit', 'su')
            ->leftJoin('su.unit', 'u')
            ->where('u.type = :type')
            ->setParameter('type', Unit::MEUTE)
            ->getQuery()->getResult();

        return $this->resultsAction($participants, $troupes, $patrouilles);
    }

    /**
     * @param array $participants
     * @param array $units
     * @param array $subUnits
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultsAction(array $participants, array $units, array $subUnits) {

        $years          = [];

        foreach($participants as $participant)
            if(!in_array($participant->getNaissance(), $years))
                $years[] = $participant->getNaissance();

        usort($participants, function(Participant $p1, Participant $p2) {

            if($p1->getGlobalTime() == $p2->getGlobalTime())
                return 0;

            return $p1->getGlobalTime() < $p2->getGlobalTime() ? -1 : 1;
        });

        usort($subUnits, function(SubUnit $a, SubUnit $b) {

            if(!$a->getScore()) return 1;
            if(!$b->getScore()) return -1;

            if($a->getScore() == $b->getScore())
                return 0;

            return $a->getScore() < $b->getScore() ? -1 : 1;
        });

        usort($units, function(Unit $a, Unit $b) {

            if(!$a->getScore()) return 1;
            if(!$b->getScore()) return -1;

            if($a->getScore() == $b->getScore())
                return 0;

            return $a->getScore() < $b->getScore() ? -1 : 1;
        });

        return $this->render('results.html.twig', array(

            'years'         => $years,
            'participants'  => $participants,
            'subUnits'   => $subUnits,
            'units'       => $units
        ));
    }
}
