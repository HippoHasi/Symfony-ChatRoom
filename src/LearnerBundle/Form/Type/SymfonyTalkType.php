<?php
// src/LearnerBundle/Form/Type/SymfonyTalkType.php
namespace LearnerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route(service="symfony_talk_type")
 */
class SymfonyTalkType extends AbstractType
{
	
	private $em;
	public function __construct(EntityManager $em)
	{
	    $this->em = $em;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder
			->add('title', TextType::class)
			->add('category', ChoiceType::class, array(
				'choices' => ['Installation'=>$this->em->getRepository('LearnerBundle:Category')->find(1), 
					'Controllers'=>$this->em->getRepository('LearnerBundle:Category')->find(2),
					'Templating'=>$this->em->getRepository('LearnerBundle:Category')->find(3),
					'Routing'=>$this->em->getRepository('LearnerBundle:Category')->find(4),
					'Databases & Doctrine'=>$this->em->getRepository('LearnerBundle:Category')->find(5),
					'Forms'=>$this->em->getRepository('LearnerBundle:Category')->find(6),
					'Configuration'=>$this->em->getRepository('LearnerBundle:Category')->find(7),
					'Other'=>$this->em->getRepository('LearnerBundle:Category')->find(8)],
    			'choices_as_values' => true,
    		))
			->add('content', TextareaType::class)
			->add('screenshot', FileType::class, array('label'=>'Screenshot (Optional)', 'required' => false))
			//->add('submitAt', HiddenType::class)
			->add('author', HiddenType::class)
			->add('count', HiddenType::class)
			->add('submit', SubmitType::class)
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'LearnerBundle\Entity\SymfonyTalk',
		));
	}
}

?>