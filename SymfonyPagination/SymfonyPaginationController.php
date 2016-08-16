<?php
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CustomerBundle\Entity\CustomerEntity;


class SymfonyPaginationController extends Controller
{
    /**
     * @Route("/blog/{currentPage}", defaults={"currentPage"=1}, 
     * requirements={"currentPage": "\d"}, name="blog")
     */
    public function fetchAction($currentPage){
        $pageSize = 5;
        if($currentPage < 1) $currentPage = 1;
        //retrieve all records from database to count the total 
		$totalBlogs = $this->getDoctrine()
			->getRepository('BundleName:EntityName')
			->findBy([], array('submitAt'=>'DESC')); //it's the way to sort findAll() outcome
        $totalRecords = count($totalTalk);
        $totalPages = ceil($totalRecords/$pageSize);
        if($currentPage >= $totalPages ) $currentPage = $totalPages;
        $startRow = ($currentPage -1)* $pageSize;
        $currentBlogs = $this->getDoctrine()
            ->getRepository('BundleName:EntityName')
            ->findBy([], array('submitAt' => 'DESC'), $pageSize, $startRow); 

        if (!$currentBlogs) {
            throw $this->createNotFoundException(
                'No blog has found, this is an empty room.'
            );
        }

        return $this->render('BundleName::TemplateName', 
            array('currentBlogs'=>$currentBlogs, 'totalPages'=>$totalPages, 'currentPage'=>$currentPage));
    }

}

?>