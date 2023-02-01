<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Service\JobSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/job", name="app_job")
     */
    public function index(Request $request, JobSearch $jobSearch, PaginatorInterface $paginator): Response
    {

        $form = $this->createForm(SearchFormType::class);

        $form->handleRequest( $request );

        $jobSearch->setPage($request->query->getInt('page', 1));
        $jobSearch->setLimit(10);

        $jobSearch->setCountry('FR');

        if ( $form->isSubmitted() && $form->isValid() ) {

            $jobSearch->setWhat($form->get('what')->getData());
            $jobSearch->setWhere($form->get('where')->getData());

        }

        $jobsData = $jobSearch->search();

        $totalJobs = $jobsData ? $jobsData->total : 0;
        $pagination = $paginator->paginate(
            array_fill(1, $totalJobs, null),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('job/index.html.twig', [
            'form' => $form->createView(),
            'jobs' => $jobsData ? $jobsData->ads : [],
            'totalJobs' => $totalJobs,
            'pagination' => $pagination
        ]);
    }
}
