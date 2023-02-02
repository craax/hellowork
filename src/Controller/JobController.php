<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Model\API\JobiJobaQuery;
use App\Service\JobSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class JobController extends AbstractController
{
    /**
     * @Route("/job", name="app_job")
     * @param Request $request
     * @param JobSearch $jobSearch
     * @param PaginatorInterface $paginator
     * @return Response
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function index(Request $request, JobSearch $jobSearch, PaginatorInterface $paginator): Response
    {

        $form = $this->createForm(SearchFormType::class);

        $form->handleRequest( $request );

        $jobiJobaQuery = new JobiJobaQuery( [
            'page' => $request->query->getInt('page', JobiJobaQuery::DEFAULT_PAGE ),
            'limit' => JobiJobaQuery::DEFAULT_LIMIT
        ] );

        if ( $form->isSubmitted() && $form->isValid() ) {

            $jobiJobaQuery->setWhat( $form->get('what')->getData() ?: '' );
            $jobiJobaQuery->setWhere( $form->get('where')->getData() ?: '' );

        }

        $jobSearch->setQuery($jobiJobaQuery);
        $jobiJobaResponse = $jobSearch->search();

        $totalJobs = $jobiJobaResponse->getTotal();
        $pagination = $paginator->paginate(
            array_fill(1, $totalJobs, null),
            $request->query->getInt('page', JobiJobaQuery::DEFAULT_PAGE ),
            JobiJobaQuery::DEFAULT_LIMIT
        );

        return $this->render('job/index.html.twig', [
            'form' => $form->createView(),
            'jobs' => $jobiJobaResponse->getAds(),
            'totalJobs' => $totalJobs,
            'pagination' => $pagination
        ]);
    }
}
