<?php
// src/LearnerBundle/Controller/userController.php
namespace LearnerBundle\Controller;

use LearnerBundle\Form\Type\RegisterType;
use LearnerBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class userController extends Controller
{
	    /**
     * @Route("/register", name="register")
     */
	public function RegisterAction(Request $request)
	{
		// build the form
		$user = new User();
		$form = $this->createForm(RegisterType::class, $user);
		//handle the submit (will only happen on POST)
		$form->handleRequest($request);

		$form_values = $form->getData();  //object
		// $file stores the uploaded user image 
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $form_values->getAvatar();

		if ($form->isSubmitted() && $form->isValid()) {
			//encode the password
			$password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
			if($file){
                $path = 'avatars';
				$this->uploadFile($user, $file, $path);
            }           
			// saving the user to database
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			//adding 'successfully registered' message
			$this->addFlash('notice', 'Welcome to Hippo Hasi, have a wonderful journey!');			
			return $this->redirectToRoute('home');
		}
		return $this->render('LearnerBundle:form:register.html.twig', 
			array('form' => $form->createView())
		);
	}


	 /**
     * @Route("/login", name="login")
     */
	public function LoginAction(Request $request)
	{

		$authenticationUtils = $this->get('security.authentication_utils');
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		return $this->render('LearnerBundle:form:login.html.twig',
			array(
			// last username entered by the user
				'last_username' => $lastUsername,
				'error' => $error,
			)
			);
	}

	/**
	* @Route("/login_check", name="login_check")
	*/
	public function loginCheckAction()
	{
		// this controller will not be executed,
		// as the route is handled by the Security system
	}

	/**
	* @Route("/logout", name="logout")
	*/
	public function logoutAction()
	{
		$this->addFlash('notice', 'You are logged out safely!');
			return $this->redirectToRoute('home');
	}

public function uploadFile($object, $file, $path){
    // Generate a unique name for the file before saving it
     $fileName = md5(uniqid()).'.'.$file->guessExtension();
    // Move the file to the directory where brochures are stored
    $screenshotDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$path;
    $file->move($screenshotDir, $fileName);
    // Update the 'screenshot' property to store the file name instead of the file
    return $object->setAvatar($fileName);
}

public function bigtosmall($fileName,$path,$width,$height){

	$img=$path.'/'.$fileName;//image location
	$imgSize=getimagesize($img); //get image parameters
	$originalWidth=$imgSize[0];//original width
	$originalHeight=$imgSize[1];//original height
	$type=$imgSize[2];//image type
	//best fit for resizing
	if($originalWidth/$originalHeight>$width/$height){ 
		$minWidth=$width; 
		$minHeight=intval($originalHeight*($width/$originalWidth)); 
	} 
	else{ 
		$minWidth=intval($originalWidth*($height/$originalHeight)); 
		$minHeight=$height; 
	} 
	//using original image to create small image holder
	switch($type){ 
			case 1: 
				$srcf = ImageCreateFromGIF($img); 
				break; 
			case 2: 
				$srcf = imagecreatefromjpeg($img); 
				break; 
			case 3: 
				$srcf = ImageCreateFromPNG($img); 
				break;  
			case 6 : 
            	$srcf = imageCreateFromBmp($img); 
        		break;			
			default: 
				echo 'Invalid image type.';
	   exit;
				break; 
	} 
	//create target image
	$desf = imagecreatetruecolor($minWidth,$minHeight);
	ImageCopyResampled($desf,$srcf,0,0,0,0,$minWidth,$minHeight,$originalWidth,$originalWidth); 
	$NewName=$path."/small/".$fileName;

	//save the file
	switch($type){ 
		case 1: 
			ImageGIF($desf,$NewName); 
			break; 
		case 2: 
			ImageJPEG($desf,$NewName); 
			break; 
		case 3: 
			ImagePNG($desf,$NewName); 
			break; 
		default: 
			return false;
			break; 
	} 
	ImageDestroy($desf); //release the data
	ImageDestroy($srcf); 
    return ture;
}

}
?>