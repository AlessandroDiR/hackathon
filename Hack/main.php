<?php

// FILE NEL QUALE SI TROVANO LE PAROLE DA SCARTARE
define("WORDSFILE", "stopwords_it.txt");

function sanitize($str){
    $content = read();

    // RIMUOVO GLI SPAZI BIANCHI E SEPARO TUTTE LE PAROLE CON LO SPAZIO, METTENDOLE POI IN UN ARRAY
    $replace = array_map("trim", explode(" ", $content));
    
    // SOSTITUISCO TUTTI I SEGNI DI PUNTEGGIATURA E I CARATTERI SPECIALI CON UNO SPAZIO NELLA STRINGA DATA
    $str = preg_replace("/[.,\/#!$%\^&\*';\":{}=\-_`~()]/", ' ', $str);

    // SEPARO TUTTE LE PAROLE DEL TESTO DATO CON UNO SPAZIO CREANDO UN ARRAY
    $words = explode(" ", strtolower($str));
    
    $return = $words;

    // SE L'ARRAY PRECEDENTEMENTE CREATO CONTIENE UNA DELLE PAROLE DA SCARTARE, TOLGO QUELLE PAROLE DALL'ARRAY
    foreach($words as $k=>$v){
        if(in_array($v, $replace) || strlen($v) == 1 || is_numeric($v)){
            unset($return[$k]);
        }
    }

    return array_filter($return);
}

function read(){
    // RESTITUISCO IL CONTENUTO DEL FILE
    return file_get_contents(WORDSFILE);
}

function findwords($str){
    $occurrences = array();

    // PRENDO LE PAROLE "VALIDE" DALL'INPUT DELL'UTENTE
    $words = sanitize($str);

    // TOTALE DELLE OCCORRENZE (100%)
    $tot = 0;

    // SE L'ARRAY $occurrences CONTIENE UNA DELLE PAROLE, ALLORA AUMENTO IL SUO VALORE, ALTRIMENTI AGGIUNGO LA PAROLA ALL'ARRAY
    foreach($words as $v){
        if(array_key_exists($v, $occurrences))
            $occurrences[$v] += 1;
        else
            $occurrences[$v] = 1;

        $tot++;
    }

    // ORDINO LE PAROLE DA QUELLA CHE APPARE MAGGIORMENTE A QUELLA CHE APPARE MENO
    arsort($occurrences);

    // PRENDO SOLO LE PRIME 20 PAROLE CON LA MAGGIOR FREQUENZA
    $occurrences = array_slice($occurrences, 0, 20);

    $returnstring = "Le parole che appaiono di più sono: <b>";

    foreach($occurrences as $k=>$v){
        $returnstring .= $k." (".$v." volte), ";

        // PERCENTUALE DELLE OCCORRENZE DELLA PAROLA
        $perc = (100 * $v) / $tot;
    }

    echo substr($returnstring, 0, -2)."</b>.";
}

function searchByTag($tag, $page){
    // PRENDO IL CONTENUTO DEL DOCUMENTO TRAMITE L'URL CHE MI VIENE DATO
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);

    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );

    $html = file_get_contents($page, false, stream_context_create($arrContextOptions));

    // CARICO L'HTML PROVENIENTE DALL'URL
    $dom->loadHTML($html);

    // PRENDO IL CONTENUTO DEL TAG CHE VIENE SPECIFICATO (ES: IL CONTENUTO DI TUTTI I TAG <p></p>)
    $books = $dom->getElementsByTagName($tag);
    
    // LA LUNGHEZZA DELL'OGGETTO CHE VIENE CREATO
    $count = $books->length;

    $testo = "";

    // CICLO TUTTI I TAG P PER PRENDERNE IL CONTENUTO
    for($i = 0; $i < $count; $i++)
        $testo .= $books->item($i)->nodeValue;

    return $testo;
}