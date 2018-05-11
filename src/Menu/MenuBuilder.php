<?php

// src/Menu/Builder.php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilder
{

    private $factory;
    private $security;

    /**
     * @param FactoryInterface $factory
     *
     */
    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }

    public function createMainMenu(array $options)
    {
       
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttributes(array('class' => 'nav'));
        $menu->setlinkAttributes(array('class' => 'nav'));

        $menu->addChild('Home', array('route' => 'index'));
        if( $this->security->isGranted( 'IS_AUTHENTICATED_FULLY' ) ){
            if( $this->security->isGranted( 'ROLE_ADMIN' ) ){
                $menu->addChild('Administration', array('route' => 'admin'));
            }
            
            $menu->addChild('Deconnexion', array('route' => 'security_logout'))->setAttribute('class', 'nav-item');
        }
        else{

            $menu->addChild('Connexion', array('route' => 'security_login'));
        }

        return $menu;
    }
    
    public function createAdminMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Administration', array('route' => 'index'));

        return $menu;
    }
}