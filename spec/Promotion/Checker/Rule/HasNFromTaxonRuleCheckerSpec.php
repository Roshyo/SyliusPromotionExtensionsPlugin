<?php

declare(strict_types=1);

namespace spec\Setono\SyliusPromotionExtensionsPlugin\Promotion\Checker\Rule;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Promotion\Checker\Rule\RuleCheckerInterface;
use Sylius\Component\Promotion\Exception\UnsupportedTypeException;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

final class HasNFromTaxonRuleCheckerSpec extends ObjectBehavior
{
    function it_is_a_rule_checker(): void
    {
        $this->shouldImplement(RuleCheckerInterface::class);
    }

    function it_recognizes_a_subject_as_eligible_if_product_taxon_is_matched(
        OrderInterface $subject,
        OrderItemInterface $item1,
        OrderItemInterface $item2,
        ProductInterface $bastardSword,
        ProductInterface $crazySword,
        TaxonInterface $swords
    ): void {
        $configuration = [
            'taxons' => ['swords'],
            'quantity' => 2,
        ];

        $swords->getCode()->willReturn('swords');

        $bastardSword->getTaxons()->willReturn(new ArrayCollection([$swords->getWrappedObject()]));
        $crazySword->getTaxons()->willReturn(new ArrayCollection([$swords->getWrappedObject()]));

        $item1->getProduct()->willReturn($bastardSword);
        $item1->getQuantity()->willReturn(1);

        $item2->getProduct()->willReturn($crazySword);
        $item2->getQuantity()->willReturn(1);

        $subject->getItems()->willReturn(new ArrayCollection([$item1->getWrappedObject(), $item2->getWrappedObject()]));

        $this->isEligible($subject, $configuration)->shouldReturn(true);
    }

    function it_recognizes_a_subject_as_not_eligible_if_a_product_taxon_is_not_matched(
        OrderInterface $subject,
        OrderItemInterface $item,
        ProductInterface $reflexBow,
        TaxonInterface $bows
    ): void {
        $configuration = [
            'taxons' => ['swords', 'axes'],
            'quantity' => 2,
        ];

        $bows->getCode()->willReturn('bows');
        $reflexBow->getTaxons()->willReturn(new ArrayCollection([$bows->getWrappedObject()]));
        $item->getProduct()->willReturn($reflexBow);
        $item->getQuantity()->willReturn(10);
        $subject->getItems()->willReturn(new ArrayCollection([$item->getWrappedObject()]));

        $this->isEligible($subject, $configuration)->shouldReturn(false);
    }

    function it_does_nothing_if_a_configuration_is_invalid(OrderInterface $subject): void
    {
        $subject->getItems()->shouldNotBeCalled();

        $this->isEligible($subject, []);
    }

    function it_throws_an_exception_if_promotion_subject_is_not_order(
        Collection $taxonsCollection,
        PromotionSubjectInterface $subject
    ): void {
        $this
            ->shouldThrow(new UnsupportedTypeException($subject->getWrappedObject(), OrderInterface::class))
            ->during('isEligible', [$subject, ['taxons' => $taxonsCollection, 'quantity' => 10]])
        ;
    }
}
