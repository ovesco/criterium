<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participant;
use AppBundle\Entity\SubUnit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RunController extends Controller
{
    /**
     * @param Request $request
     * @Route("/load", name="app.load.excel")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadExcelViewAction(Request $request) {

        $em         = $this->getDoctrine()->getManager();
        $patrols    = $em->getRepository('AppBundle:SubUnit')->findAll();

        return $this->render('load.html.twig', array(

            'subUnits' => $patrols
        ));
    }

    /**
     * @param Request $request
     * @Route("/ajax/load", name="app.load.ajax_excel")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajaxLoadAction(Request $request) {

        $data           = $request->get('data');
        $em             = $this->getDoctrine()->getManager();
        $subUnits    = $em->getRepository('AppBundle:SubUnit')->findAll();
        $count          = 0;

        foreach($data as $membreData) {

            if(count($membreData) != 5)
                continue;

            $count++;

            $membre     = new Participant();
            $subUnit = null;

            /** @var SubUnit $p */
            foreach($subUnits as $p)
                if($p->getId() == $membreData['subUnit'])
                    $subUnit = $p;

            if($em->getRepository('AppBundle:Participant')->findOneBy(array('numero' => $membreData['dossard'])) !== null)
                return $this->message("danger", "Le dossard " . $membreData['dossard'] . " est déjà pris!");

            if($subUnit === null)
                return $this->message("warning", "La subUnit avec id " . $membreData['subUnit'] . " n'existe pas! Corrigez le problème et réessayez.");

            $membre->setSubUnit($subUnit)
                ->setNom($membreData['nom'])
                ->setPrenom($membreData['prenom'])
                ->setNaissance($membreData['annee'])
                ->setNumero($membreData['dossard']);

            $em->persist($membre);
        }

        $em->flush();
        return $this->message("success", "$count participants inscrits!");
    }

    /**
     * @Route("/run/depart", name="app.run.depart_run")
     */
    public function departViewAction(Request $request) {

        $em         = $this->getDoctrine()->getManager();
        $patrols    = $em->getRepository('AppBundle:SubUnit')->findAll();

        return $this->render('depart.html.twig', array(

            'subUnits' => $patrols
        ));
    }

    /**
     * @Route("/ajax/run/depart", name="app.run.ajax_depart_run")
     */
    public function ajaxDepartAction(Request $request) {

        $timeData   = $request->get('time');
        $patrolId   = $request->get('patrol');
        $course     = $request->get('course');
        $em         = $this->getDoctrine()->getManager();
        $time       = explode(" ", trim($timeData));

        $patrol     = $em->find('AppBundle:SubUnit', $patrolId);
        if($patrol === null)
            return $this->message("error", "La subUnit $patrolId n'existe pas!");

        if(count($time) > 3 || count($time) < 2)
            return $this->message("error", "Valeur de temps invalide : $timeData");
        $time[2]    = isset($time[2]) ? $time[2] : '00';

        foreach($time as $key => $value)
            $time[$key] = strlen($value) == 1 ? '0' . $value : $value;

        $depart     = \DateTime::createFromFormat('G:i:s', implode(':', $time));

        foreach($patrol->getParticipants() as $membre) {

            if($course == 'matin')
                $membre->setDepartMatin($depart);
            elseif($course == 'clm')
                $membre->setDepartCLM($depart);
            elseif($course == 'aprem')
                $membre->setDepartApresMidi($depart);
            else
                return $this->message("error", "Aucune course '$course' n'existe!");

            $em->persist($membre);
        }

        $em->flush();

        return $this->message("info", count($patrol->getParticipants()) . " membres de '{$patrol->getNom()}' partis avec succès pour '$course'!", $depart);
    }

    /**
     * @Route("/run/end", name="app.run.end_run")
     */
    public function endRunViewAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $patrols    = $em->getRepository('AppBundle:SubUnit')->findAll();

        return $this->render('end-run.html.twig', array(

            'subUnits'   => $patrols
        ));
    }

    /**
     * @Route("/ajax/run/end", name="app.run.ajax_end_run")
     */
    public function ajaxEndRunAction(Request $request) {

        $now        = new \DateTime();
        $dossard    = $request->get('runner');
        $course     = $request->get('course');
        $patrolId   = $request->get('patrol');
        $em         = $this->getDoctrine()->getManager();

        if($course == 'clm') {

            $patrol = $em->find('AppBundle:SubUnit', $patrolId);
            if($patrol === null)
                return $this->message("danger", "SubUnit $patrolId introuvable!", $now);

            foreach($patrol->getParticipants() as $membre) {
                $membre->setArriveeCLM($now);
                $em->persist($membre);
            }

            $em->flush();
            return $this->message("success", count($patrol->getParticipants()) . " membres de '" . $patrol->getNom() . "' ont fini le contre-la-montre", $now);
        }

        $membre     = $em->getRepository('AppBundle:Participant')->findOneBy(array('numero' => $dossard));
        if($membre === null)
            return $this->message("danger", "Le dossard $dossard n'existe pas!", $now);

        if($course == 'matin')
            $membre->setArriveeMatin($now);
        elseif($course == 'aprem')
            $membre->setArriveeApresMidi($now);
        else
            return $this->message("danger", "La course de type $course n'existe pas pour le coureur $dossard!", $now);

        $em->persist($membre);
        $em->flush();

        return $this->message("success", "Dossard $dossard {$membre->getPrenom()} {$membre->getNom()} de {$membre->getSubUnit()->getUnit()->getNom()} a bien terminé la course '$course'", $now);
    }

    protected function message($type, $message, \DateTime $time = null) {

        $time   = $time === null ? new \DateTime() : $time;

        return $this->json(array(

            'type'      => $type,
            'message'   => $message,
            'time'      => $time->format('d.m.Y H:i:s')
        ));
    }
}
