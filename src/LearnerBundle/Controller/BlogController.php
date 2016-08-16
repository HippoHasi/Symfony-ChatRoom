<?php

namespace LearnerBundle\Controller;

use LearnerBundle\Form\Type\BlogType;
use LearnerBundle\Entity\Blog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use LearnerBundle\Form\Type\BlogReplyType;
use LearnerBundle\Entity\BlogReply;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

//use Symfony\Component\HttpFoundation\ParameterBag;
class BlogController extends Controller
{
	/**
     * @Route("/getBlog/{username}/{page}", defaults={"username" = "all", "page"=1}, requirements={"page": "\d"}, name="getBlog")
     */
    public function fetchAction($username, $page){
        $pageSize = 1;
        if($page < 1) $page = 1;

        if($username=="all"){
            $totalBlog = $this->getDoctrine()
                ->getRepository('LearnerBundle:Blog')
                ->findBy([], array('submitAt' => 'DESC'));

            $totalRecord = count($totalBlog);
            $totalPages = ceil($totalRecord/$pageSize);
            if($page >= $totalPages ) $page = $totalPages;
            $startRow = ($page -1)* $pageSize;

            $blog = $this->getDoctrine()
                ->getRepository('LearnerBundle:Blog')
                ->findBy([], array('submitAt' => 'DESC'), $pageSize, $startRow);
        }
        else{
            $totalBlog = $this->getDoctrine()
                ->getRepository('LearnerBundle:Blog')
                ->findBy(array('author' => $username), array('submitAt' => 'DESC'));

            $totalRecord = count($totalBlog);
            $totalPages = ceil($totalRecord/$pageSize);
            if($page >= $totalPages ) $page = $totalPages;
            $startRow = ($page -1)* $pageSize;  

            $blog = $this->getDoctrine()
                ->getRepository('LearnerBundle:Blog')
                ->findBy(array('author' => $username), array('submitAt' => 'DESC'), $pageSize, $startRow);
        }
        if(!$blog){
            throw $this->createNotFoundException('No blog detail found, this blog does not exist.');
        }
      
        $encoder = new JsonEncoder();
        //$normalizer = new ObjectNormalizer();
        $normalizer = new GetSetMethodNormalizer();

        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime ? $dateTime->format(\DateTime::ISO8601) : '';
        };

        $normalizer->setCallbacks(array('submitAt' => $callback, 'replyAt' => $callback));

        //prevent getting "A circular reference has been detected (configured limit: 1)." error message 
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        //$serializer = $this->get('serializer');
        //var_dump($serializer->serialize($blog, 'json'));
        $jsonContent = $serializer->serialize($blog, 'json');
        return new Response($jsonContent);

        //return new JsonResponse($jsonContent); 
    }
    /**
     * @Route("/blog/{username}/{page}", defaults={"username" = "all", "page"="1"}, requirements={"page": "\d"}, name="blog")
     */
    public function blogAction($username, $page){
        $pageSize = 1;
        if($page < 1) $page = 1;

        if($username=="all"){
            $totalBlog = $this->getDoctrine()
                ->getRepository('LearnerBundle:Blog')
                ->findBy([], array('submitAt' => 'DESC'));

            $totalRecord = count($totalBlog);
            $totalPages = ceil($totalRecord/$pageSize);
            if($page >= $totalPages ) $page = $totalPages;
        }
        else{
            $totalBlog = $this->getDoctrine()
                ->getRepository('LearnerBundle:Blog')
                ->findBy(array('author' => $username), array('submitAt' => 'DESC'));

            $totalRecord = count($totalBlog);
            $totalPages = ceil($totalRecord/$pageSize);
            if($page >= $totalPages ) $page = $totalPages;                     
        }
        return $this->render('LearnerBundle::blog.html.twig', 
            array('username'=>$username, 'totalPages'=>$totalPages, 'page'=>$page));
    }
    /**
     * @Route("/createBlog", name="createBlog")
     */
    public function writeAction(Request $request){
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        $author = $user->getUsername();

        $blog = new Blog();

        //assigning current user to author form property and setting hidden fields of the form
        $blog->setAuthor($author);
        //SubmitAt field is not posted by form as hidden type returns string which dosn't match DateTime type(object) of this field.
        $now = date('Y-m-d H:i:s');
        $blog->setSubmitAt(new \DateTime($now));
        $blog->setCount('0');
        // build the form
        //$form = $this->createForm(BlogType::class, $blog);
        $form = $this->createFormBuilder($blog)->getForm();
        //print_r($_POST['content']);
        //print_r($_FILES['pics']); exit;

        //handle the submit (will only happen on POST)
        $form->handleRequest($request);
        $form_values = $form->getData();  //object
        //print_r($form_values);exit;
        // $file stores the uploaded screenshot 
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $form_values->getPics();
        if ($form->isSubmitted() && $form->isValid()) {
            if($file){
                $path = 'pic';
                $this->uploadFile($blog, $file, $path);
            }
            // saving user written symfony talk to database
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            //adding 'successfully created talk' message
            $this->addFlash('notice', 'Your Symfony Talk has been created successfully!');          
            return $this->redirectToRoute('blog');
        }
        return $this->render('LearnerBundle:form:CreateBlog.html.twig', 
                array('form' => $form->createView())
            );  
    }

    /**
     * @Route("/blogReply", name="blogReply")
     */
    public function replyAction(){
        $reply = new BlogReply();
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();
            $author = $user->getUsername();
            $reply->setAuthor($author);
        }
        $reply->setContent($_POST['content']);
        $blogId = $_POST['blogId'];
        $now = date('Y-m-d H:i:s');
        $reply->setReplyAt(new \DateTime($now));

        //find the blog object which has the id=$blogId 
        $blog = $this->getDoctrine()
            ->getRepository('LearnerBundle:Blog')
            ->find($blogId);
        $reply->setBlog($blog);

        $em = $this->getDoctrine()->getManager();
        $em->persist($reply);
        $em->flush();
        return $this->redirectToRoute('blog');
    }

    /**
     * @Route("/editBlog/{id}", requirements={"id": "\d+"}, name="editBlog")
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('LearnerBundle:Blog')
            ->find($id);  
        if (!$blog) {
            throw $this->createNotFoundException('No blog found for id '.$id);
        }
        if($_REQUEST){
            $now = date('Y-m-d H:i:s');
            $blog->setSubmitAt(new \DateTime($now));
            $blog->setContent($_POST['content']);
            $em->flush();
            //$talk_id = $reply->getTalk()->getId();
            return $this->redirectToRoute('symfonyTalkDetail', array('id'=>$talk_id));
        }
        else{        
            return $this->render('LearnerBundle:form:editBlog.html.twig', array('blog'=>$blog));
        }
    }

    /**
     * @Route("/deleteBlogReply/{id}", requirements={"id": "\d+"}, name="deleteBlogReply")
     */
    public function deleteReplyAction($id){
        $em = $this->getDoctrine()->getManager();
        $reply = $em
            ->getRepository('LearnerBundle:BlogReply')
            ->find($id);  
        if (!$reply) {
            throw $this->createNotFoundException('No Blog Reply found for id '.$id);
        }
/*        if($filename = $reply->getScreenshot()){
            $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/screenshots/replys/'.$filename;
            unlink($path);
        }*/
        $em->remove($reply);
        $em->flush();
        //$blog_id = $reply->getBlog()->getId();
        return $this->redirectToRoute('blog');
    }

    /**
     * @Route("/symfonyDeleteFile/{id}/{file}/{talk_id}", requirements={"id": "\d+", "talk_id": "\d+"}, name="symfonyDeleteFile")
     */
    //delete file name from database + actual file from the upload folder 
    public function deleteFile($id, $file, $talk_id){
        $em = $this->getDoctrine()->getManager();
        $reply = $em
            ->getRepository('LearnerBundle:SymfonyTalkReply')
            ->find($id);         
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/screenshots/replys/'.$file;
        unlink($path);
        $reply->setScreenshot('');
        $em->flush();
        return $this->redirectToRoute('symfonyTalkDetail', array('id'=>$talk_id));
    }    
    
public function uploadFile($object, $file, $path){
    // Generate a unique name for the file before saving it
     $fileName = md5(uniqid()).'.'.$file->guessExtension();
    // Move the file to the directory where brochures are stored
    $picDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$path;
    $file->move($picDir, $fileName);
    // Update the 'screenshot' property to store the file name instead of the file
    return $object->setPic($fileName);
}

    public function userListAction(){
        $users = $this->getDoctrine()
            ->getRepository('LearnerBundle:User')
            ->findall();
        return $this->render('LearnerBundle::userList.html.twig', array('users'=>$users));
    }



}
?>