<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        $builder
            ->add('name')
            ->add('start_date', DateType::class)
            ->add('end_date', DateType::class)
            ->add('description', TextareaType::class)
            ->add('image_path', FileType::class)
            ->add('category', ChoiceType::class, [
                'choices' => $categories,
                'choice_value' => 'name',
                'choice_label' => function (?Category $category): string {
                    return $category ? strtoupper($category->getName()) : '';
                }
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
