<?php

namespace LearnerBundle\Controller;

use LearnerBundle\Form\Type\SymfonyTalkType;
use LearnerBundle\Entity\SymfonyTalk;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use LearnerBundle\Form\Type\ReplyType;
use LearnerBundle\Entity\SymfonyTalkReply;


class SymfonyTalkController extends Controller
{
    /**
     * @Route("/symfonyTalk/{category}/{page}", defaults={"category" = "All", "page"=1}, 
     * requirements={"page": "\d"}, name="symfonyTalk")
     */
    public function fetchAction($category, $page){
        $pageSize = 4;
        if($page < 1) $page = 1;

    	switch ($category) {
    		case 'All':
    			$totalTalk = $this->getDoctrine()
					->getRepository('LearnerBundle:SymfonyTalk')
					->findBy([], array('submitAt'=>'DESC'));

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy([], array('submitAt' => 'DESC'), $pageSize, $startRow); 
    			break;
    		case 'Installation':
    			$totalTalk = $this->getDoctrine()
    				->getRepository('LearnerBundle:SymfonyTalk')
    				->findBy(array('category' => '1'), array('submitAt' => 'DESC'));

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy(array('category' => '1'), array('submitAt' => 'DESC'), $pageSize, $startRow);    
    			break;
    		case 'Controllers':
    			$totalTalk = $this->getDoctrine()
    				->getRepository('LearnerBundle:SymfonyTalk')
    				->findBy(array('category' => '2'), array('submitAt' => 'DESC'));

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy(array('category' => '2'), array('submitAt' => 'DESC'), $pageSize, $startRow);
    			break;
    		case 'Templating':
    			$totalTalk = $this->getDoctrine()
    				->getRepository('LearnerBundle:SymfonyTalk')
    				->findBy(array('category' => '3'), array('submitAt' => 'DESC'));

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy(array('category' => '3'), array('submitAt' => 'DESC'), $pageSize, $startRow);
    			break;
    		case 'Routing':
    			$totalTalk = $this->getDoctrine()
    				->getRepository('LearnerBundle:SymfonyTalk')
    				->findBy(array('category' => '4'), array('submitAt' => 'DESC'));

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy(array('category' => '4'), array('submitAt' => 'DESC'), $pageSize, $startRow);
    			break;
    		case 'Doctrine':
    			$totalTalk = $this->getDoctrine()
    				->getRepository('LearnerBundle:SymfonyTalk')
    				->findBy(array('category' => '5'), array('submitAt' => 'DESC'));

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy(array('category' => '5'), array('submitAt' => 'DESC'), $pageSize, $startRow);
    			break;
    		case 'Forms':
    			$totalTalk = $this->getDoctrine()
    				->getRepository('LearnerBundle:SymfonyTalk')
    				->findBy(array('category' => '6'), array('submitAt' => 'DESC'));

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy(array('category' => '6'), array('submitAt' => 'DESC'), $pageSize, $startRow);
    			break;
    		case 'Configuration':
    			$totalTalk = $this->getDoctrine()
    				->getRepository('LearnerBundle:SymfonyTalk')
    				->findBy(array('category' => '7'), array('submitAt' => 'DESC'));

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy(array('category' => '7'), array('submitAt' => 'DESC'), $pageSize, $startRow);
    			break;
    		case 'Other':
    			$totalTalk = $this->getDoctrine()
    				->getRepository('LearnerBundle:SymfonyTalk')
    				->findBy(array('category' => '8'), array('submitAt' => 'DESC'));  

                $totalRecord = count($totalTalk);
                $totalPages = ceil($totalRecord/$pageSize);
                if($page >= $totalPages ) $page = $totalPages;
                $startRow = ($page -1)* $pageSize;
                $talk = $this->getDoctrine()
                    ->getRepository('LearnerBundle:SymfonyTalk')
                    ->findBy(array('category' => '8'), array('submitAt' => 'DESC'), $pageSize, $startRow);  				    				    			    				    			   				
    			break;
    	}                                                                                                               

		if (!$talk) {
			throw $this->createNotFoundException(
				'No talk has found, this is an empty room.'
			);
		}

		return $this->render('LearnerBundle::SymfonyTalk.html.twig', 
            array('symfonyTalk'=>$talk, 'category'=>$category, 'totalPages'=>$totalPages, 'page'=>$page));
    }

    /**
     * @Route("/createSymfonyTalk", name="createSymfonyTalk")
     */
    public function writeAction(Request $request){
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
        $author = $user->getUsername();

        $symfonyTalk = new SymfonyTalk();
        //assigning current user to author form property and setting hidden fields of the form
        $symfonyTalk->setAuthor($author);
        //SubmitAt field is not posted by form as hidden type returns string which dosn't match DateTime type(object) of this field.
        $now = date('Y-m-d H:i:s');
        $symfonyTalk->setSubmitAt(new \DateTime($now));
        $symfonyTalk->setCount('0');
        // build the form
        $form = $this->createForm(SymfonyTalkType::class, $symfonyTalk);
            
        //handle the submit (will only happen on POST)
        $form->handleRequest($request);
        $form_values = $form->getData();  //object
        $symfonyTalk->setCategory($form_values->getCategory());

        // $file stores the uploaded screenshot 
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $form_values->getScreenshot();
        if ($form->isSubmitted() && $form->isValid()) {
            if($file){
                $path = 'screenshots';
                $this->uploadFile($symfonyTalk, $file, $path);
            }
            // saving user written symfony talk to database
            $em = $this->getDoctrine()->getManager();
            $em->persist($symfonyTalk);
            $em->flush();
            //adding 'successfully created talk' message
            $this->addFlash('notice', 'Your Symfony Talk has been created successfully!');          
            return $this->redirectToRoute('symfonyTalk');
        }
        return $this->render('LearnerBundle:form:CreateSymfonyTalk.html.twig', 
                array('form' => $form->createView())
            );  
    }
    /**
     * @Route("/symfonyTalkDetail/{id}", requirements={"id": "\d+"}, name="symfonyTalkDetail")
     */
    public function DetailAction($id){
        $symfonyTalk = $this->getDoctrine()
            ->getRepository('LearnerBundle:SymfonyTalk')
            ->find($id);
        $talkUsername = $symfonyTalk->getAuthor();
        $talkUser = $this->getDoctrine()
            ->getRepository('LearnerBundle:User')
            ->findOneByUsername($talkUsername);
        if(!$symfonyTalk){
            throw $this->createNotFoundException('No talk detail found, this talk does not exist.');
        }
        $reply = $this->getDoctrine()
            ->getRepository('LearnerBundle:SymfonyTalkReply')
            ->findByTalk($id);
        return $this->render('LearnerBundle::SymfonyTalkDetail.html.twig', 
            array('symfonyTalk' => $symfonyTalk, 'replys'=>$reply, 'talkUser'=>$talkUser)
        );
    }
    /**
     * @Route("/symfonyTalkReply/{talk_id}", requirements={"talk_id": "\d+"}, name="symfonyTalkReply")
     */
    public function ReplyAction($talk_id, Request $request){
        $reply = new SymfonyTalkReply();
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();
            $author = $user->getUsername();
            $reply->setAuthor($author);
        }
        
        $now = date('Y-m-d H:i:s');
        $reply->setReplyAt(new \DateTime($now));

        //find the symfony talk object which has the id=$talk_id 
        $symfonyTalk = $this->getDoctrine()
            ->getRepository('LearnerBundle:SymfonyTalk')
            ->find($talk_id);

        $reply->setTalk($symfonyTalk);
        //build the reply form
        $form = $this->createForm(ReplyType::class, $reply);
            
        //handle the submit (will only happen on POST)
        $form->handleRequest($request);
        $form_values = $form->getData();  //object
        // $file stores the uploaded screenshot 
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $form_values->getScreenshot();
        if ($form->isSubmitted() && $form->isValid()) {
            if($file){
                $path = 'screenshots/replys';
                $this->uploadFile($reply, $file, $path); 
            }
            // saving user written symfony talk to database
            $em = $this->getDoctrine()->getManager();
            $em->persist($reply);
            $em->flush();
            //adding 'successfully created talk' message
            $this->addFlash('notice', 'Your Symfony Talk has been created successfully!');          
            return $this->redirectToRoute('symfonyTalkDetail', array('id'=>$talk_id));
        }

        return $this->render('LearnerBundle:form:reply.html.twig', 
            array('form' => $form->createView(), 'talk_id'=>$talk_id)
        ); 
    }

    /**
     * @Route("/symfonyReplyEdit/{id}", requirements={"id": "\d+"}, name="symfonyReplyEdit")
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getManager();
        $reply = $em->getRepository('LearnerBundle:SymfonyTalkReply')
            ->find($id);  
        if (!$reply) {
            throw $this->createNotFoundException('No Symfony Talk Reply found for id '.$id);
        }
        if($_REQUEST){
            $now = date('Y-m-d H:i:s');
            $reply->setReplyAt(new \DateTime($now));
            $reply->setContent($_POST['content']);
            $em->flush();
            $talk_id = $reply->getTalk()->getId();
            return $this->redirectToRoute('symfonyTalkDetail', array('id'=>$talk_id));
        }
        else{        
            return $this->render('LearnerBundle:form:editReply.html.twig', array('reply'=>$reply));
        }
    }

    /**
     * @Route("/symfonyTalkReplyDelete/{id}", requirements={"id": "\d+"}, name="symfonyTalkReplyDelete")
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $reply = $em
            ->getRepository('LearnerBundle:SymfonyTalkReply')
            ->find($id);  
        if (!$reply) {
            throw $this->createNotFoundException('No Symfony Talk Reply found for id '.$id);
        }
        if($filename = $reply->getScreenshot()){
            $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/screenshots/replys/'.$filename;
            unlink($path);
        }
        $em->remove($reply);
        $em->flush();
        $talk_id = $reply->getTalk()->getId();
        return $this->redirectToRoute('symfonyTalkDetail', array('id'=>$talk_id));
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
    $screenshotDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$path;
    $file->move($screenshotDir, $fileName);
    // Update the 'screenshot' property to store the file name instead of the file
    return $object->setScreenshot($fileName);
}




}
?>    