<?php
// src/LearnerBundle/Form/Type/BlogType.php
namespace LearnerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
class BlogType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('content', TextareaType::class)
/*			->add('pics', FileType::class, 
				array('required' => false, 'attr'=>['multiple'=>true]))*/
			->add('submit', SubmitType::class);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'LearnerBundle\Entity\Blog',
		));
	}
}

?>