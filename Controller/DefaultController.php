<?php

namespace Skyeff\FileSearchBundle\Controller;

use Skyeff\FileSearchBundle\Entity\SearchTask;
use Skyeff\FileSearchBundle\Form\Type\SearchTaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $registry = $this->get('skyeff_file_search.search_engine_registry');

        $task = new SearchTask();

        $form = $this->createForm(SearchTaskType::class, $task, [
            SearchTaskType::ENGINE_CHOICES => $registry->getAliases(),
            'method' => 'GET'
        ]);

        $form->handleRequest($request);

        $foundFiles = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $searchEngine = $registry->getEngineOrDefault($task->getEngine());
            $foundFiles = $searchEngine->findFiles2($form->getData());
        }

        return $this->render('SkyeffFileSearchBundle:Default:index.html.twig', [
            'form' => $form->createView(),
            'foundFiles' => $foundFiles,
        ]);
    }
}
