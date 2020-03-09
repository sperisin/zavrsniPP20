<?php

class Partner
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from partner');
        $izraz->execute();
        return $izraz->fetchAll();
    }
}