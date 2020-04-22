<?php 
     
class Sifarnik
{
    public static function mjestoReadall()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.mjesto_id, a.postanskibroj, a.naziv, b.naziv as nazivdrzave from mjesto a 
                                inner join drzava b on a.drzava_id = b.drzava_id');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function mjestoRead($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.mjesto_id, a.postanskibroj, a.naziv, b.naziv as nazivdrzave from mjesto a 
                                inner join drzava b on a.drzava_id = b.drzava_id
                                where a.mjesto_id = :mjesto_id');
        $izraz->execute(['mjesto_id'=>$id]);
        return $izraz->fetch();
    }

    public static function mjestoCreate()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into mjesto (postanskibroj, naziv, drzava_id) values 
                                (:postanskibroj, :naziv, :drzava_id)');
        $izraz->execute(['postanskibroj'=>$_POST['postanskibroj'], 'naziv'=>$_POST['nazivmjesta'], 'drzava_id'=>$_POST['drzava']]);
    }

    public static function mjestoUpdate($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update mjesto set postanskibroj = :postanskibroj, naziv = :naziv, drzava_id = :drzava_id where mjesto_id = :mjesto_id');
        $izraz->execute(['postanskibroj'=>$_POST['postanskibroj'], 'naziv'=>$_POST['nazivmjesta'], 'drzava_id'=>$_POST['drzava'], 'mjesto_id'=>$id]);
    }

    public static function mjestoDelete()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from mjesto where mjesto_id = :mjesto_id and mjesto_id not in (select mjesto_id from partner where mjesto_id = :mjesto_id) and 
                                mjesto_id not in (select mjesto_id from tvrtka where mjesto_id = :mjesto_id)');
        try{
            $izraz->execute($_GET);
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function drzavaReadall()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from drzava');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function drzavaRead($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from drzava where drzava_id = :drzava_id');
        $izraz->execute(['drzava_id'=>$id]);
        return $izraz->fetch();
    }

    public static function drzavaCreate()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into drzava (naziv, oznaka) values (:naziv, :oznaka)');
        $izraz->execute(['naziv'=>$_POST['nazivdrzave'], 'oznaka'=>$_POST['oznakadrzave']]);
    }

    public static function drzavaUpdate($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update drzava set naziv = :naziv, oznaka = :oznaka where drzava_id = :drzava_id');
        $izraz->execute(['naziv'=>$_POST['nazivdrzave'], 'oznaka'=>$_POST['oznakadrzave'], 'drzava_id'=>$id]);
    }

    public static function drzavaDelete()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from drzava where drzava_id = :drzava_id and drzava_id not in (select drzava_id from mjesto where drzava_id = :drzava_id)');
        try{
            $izraz->execute($_GET);
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }


}