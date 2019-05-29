<?php

// FILE NEL QUALE SI TROVANO LE PAROLE DA SCARTARE
define("WORDSFILE", "files/stopwords_it.txt");

// MASSIMO DI PAROLE DA MOSTRARE
define("MAX_RESULTS", 20);

function sanitize($str){
    $content = read();

    // RIMUOVO GLI SPAZI BIANCHI E SEPARO TUTTE LE PAROLE CON LO SPAZIO, METTENDOLE POI IN UN ARRAY
    $replace = array_map("trim", explode(" ", $content));
    
    // SOSTITUISCO TUTTI I SEGNI DI PUNTEGGIATURA E I CARATTERI SPECIALI CON UNO SPAZIO NELLA STRINGA DATA
    $str = preg_replace("/[.,\/#!$%\“”^&\*';\":{}=\-_`~()]/", ' ', $str);

    // SEPARO TUTTE LE PAROLE DEL TESTO DATO CON UNO SPAZIO CREANDO UN ARRAY
    $words = explode(" ", strtolower($str));
    
    $return = $words;

    // SE L'ARRAY PRECEDENTEMENTE CREATO CONTIENE UNA DELLE PAROLE DA SCARTARE, TOLGO QUELLE PAROLE DALL'ARRAY
    foreach($words as $k=>$v){
        if(in_array($v, $replace) || strlen($v) == 1 || is_numeric($v) || ctype_space($v)){
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
    $occurrences = array_slice($occurrences, 0, MAX_RESULTS);

    // COSTRUISCO UNA TABELLA PER VISUALIZZARE I RISULTATI
    $returnstring = '<h5 class="text-uppercase font-weight-bold text-center">Le parole che appaiono di più sono:</h5>';
    $returnstring .= '<table class="table table-striped table-bordered mt-2 mb-0">';
    $returnstring .= '<thead>';
    $returnstring .= '<tr>';
    $returnstring .= '<td>Parola</td>';
    $returnstring .= '<td>Occorrenze</td>';
    $returnstring .= '<td>Percentuale</td>';
    $returnstring .= '</tr></thead><tbody>';

    $cloud_words = array();

    foreach($occurrences as $k=>$v){
        // PERCENTUALE DELLE OCCORRENZE DELLA PAROLA
        $perc = number_format((100 * $v) / $tot, 2)."%";
        
        $returnstring .= '<tr>';
        $returnstring .= '<td width="50%">'.$k.'</td>';
        $returnstring .= '<td width="30%">'.$v.'</td>';
        $returnstring .= '<td width="20%">'.$perc.'</td>';
        $returnstring .= '</tr>';

        for($i = 0; $i < $v; $i++)
            $cloud_words[] = $k;
    }

    $returnstring .= '</tbody></table>';

    $cloud_words = implode(";", $cloud_words);

    $returnstring .= '<iframe width="100%" height="500" class="border-0 mt-5" src="getcloud.php?max='.MAX_RESULTS.'&words='.$cloud_words.'"></iframe>';

    echo $returnstring;
}

function searchByTag($tag, $page){
    // PRENDO IL CONTENUTO DEL DOCUMENTO TRAMITE L'URL CHE MI VIENE DATO
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);

    $html = file_get_contents($page);

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