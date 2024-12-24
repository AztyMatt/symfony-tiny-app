<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Team;
use App\Entity\User;
use App\Entity\ProjectUser;
use App\Enum\ProjectStatusEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', null, [
                'attr' => ['rows' => 4],
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
            ])
            ->add('status', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($status) => $status->value, ProjectStatusEnum::cases()),
                    ProjectStatusEnum::cases()
                ),
                'choice_label' => function ($choice, $key, $value) {
                    return $key;
                },
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
            ])
            // ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            //     $form = $event->getForm();
            //     $project = $event->getData();

            //     $form->add('members', EntityType::class, [
            //         'class' => ProjectUser::class,
            //         'choice_label' => 'member.username',
            //         'multiple' => true,
            //         'expanded' => true,
            //         'data' => $project->getMembers(),
            //         'query_builder' => function (EntityRepository $er) use ($project) {
            //             return $er->createQueryBuilder('pu')
            //                 ->innerJoin('pu.member', 'u')
            //                 ->innerJoin('u.teams', 't')
            //                 ->where('t.id = :teamId')
            //                 ->setParameter('teamId', $project->getTeam()->getId())
            //                 ->groupBy('u.id');
            //         },
            //     ]);
            // })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
