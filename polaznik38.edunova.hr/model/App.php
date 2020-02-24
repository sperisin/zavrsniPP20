<?php

class App
{
    public static function start()
    {
       $ruta = Request::getRuta();
        // echo $ruta;   

        $dijelovi = explode('/',$ruta);

    // print_r($dijelovi);

        $klasa='';
        if(!isset($dijelovi[1]) || $dijelovi[1]===''){
            $klasa='Index';
        }else{
            $klasa=ucfirst($dijelovi[1]);
        }

        // $klasa= $klasa . 'Controller'; - duži način
        $klasa.='Controller';

        // echo $klasa;

        $funkcija='';
        if(!isset($dijelovi[2]) || $dijelovi[2]===''){
                $funkcija='index';
            }else{
                $funkcija=$dijelovi[2];
        }

/*
        $parametar1='';
        if(!isset($dijelovi[3]) || $dijelovi[3]===''){
                $parametar1='';
            }else{
                $parametar1=$dijelovi[3];
        }
*/
        //echo $klasa . '->' . $funkcija . '();';


        if(class_exists($klasa) && method_exists($klasa,$funkcija)){
           /*
            if($parametar1!==''){
                $instanca = new $klasa();
                $instanca->$funkcija($parametar1);
            }else{
                $instanca = new $klasa();
                $instanca->$funkcija();
            }
            */

            $instanca = new $klasa();
            $instanca->$funkcija();
        }else{
            header('HTTP/1.0 404 Not Found');
           // echo 'HGSS';
        }


    }

    public static function config($kljuc)
    {
        $konfiguracija = include BP . 'konfiguracija.php';
    
        return $konfiguracija[$kljuc];
    }
}