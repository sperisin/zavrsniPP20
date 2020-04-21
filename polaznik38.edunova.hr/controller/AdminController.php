<?php

class AdminController extends AutorizacijaController
{
    public function __construct()
    {
        parent::__construct();
        if($_SESSION['operater']->uloga !== 'Admin' && $_SESSION['operater']->uloga !== 'superadmin'){
            $ic = new IndexController();
            $ic->odjava();
            exit;
        }
    }
}