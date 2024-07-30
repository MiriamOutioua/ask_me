<?php

function convert_date($date) 
{
    $jour = substr($date, 8, 2);
    $mois = substr($date, 5, 2);
    $annee = substr($date, 0, 4);
    $heure = substr($date, 11, 2);
    $min = substr($date, 14, 2);
    $sec = substr($date, 17, 2);
    
    return $jour.'/'.$mois.'/'.$annee.' à '.$heure.':'.$min.':'.$sec;
}