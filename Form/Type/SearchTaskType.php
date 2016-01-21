<?php

namespace Skyeff\FileSearchBundle\Form\Type;

use Skyeff\FileSearchBundle\Entity\SearchTask;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchTaskType extends AbstractType {
    const ENGINE_CHOICES = 'engineChoices';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('term')
            ->add('engine', ChoiceType::class, [
                'choices' => $options[self::ENGINE_CHOICES],
                'choices_as_values' => true,
                'required' => false,
                'placeholder' => 'Use default',
                'choice_label' => function($value) {
                    return ucfirst($value);
                }
            ])
            ->add('all', CheckboxType::class, ['label' => 'Show all results?', 'required' => false])
            ->add('limit', IntegerType::class)
            ->add('search', SubmitType::class, ['label' => 'Search']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('validation_groups', function(FormInterface $form) {
            /** @var SearchTask $data */
            $data = $form->getData();

            return $data->getAll() ? ['Default'] : ['Default', 'resultsLimit'];
        });

        $resolver->setRequired([
            self::ENGINE_CHOICES
        ]);

        $resolver->setAllowedTypes(self::ENGINE_CHOICES, ['array']);
    }
}