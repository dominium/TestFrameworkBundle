<?php

/** @var Labudzinski\TestFrameworkBundle\Component\Layout\LayoutManipulatorInterface $layoutManipulator */
/** @var Labudzinski\TestFrameworkBundle\Component\Layout\LayoutItemInterface $item */

$layoutManipulator
    ->add('header', 'root_alias', 'header')
    ->add('logo', 'header', 'logo', ['title' => 'test'])
    ->addAlias('root_alias', 'root');
