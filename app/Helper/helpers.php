<?php  

use Stichoza\GoogleTranslate\GoogleTranslate;

function direBonjour(){

	$startTime = time();

	$i = 1;
	for ($i=0; $i < 65596; $i++) { 
		// code...
		$i += 1;
	}
	$endTime = time();

	return 'TEMPS PASSE : '.($endTime - $startTime) . ' La valeur de i = '.	$i;
}

 function trimData($array_data){
        $trim = [];
        $code_enregistrement = time();

        foreach ($array_data as $key => $value) {
            // code...

            if($value['matricule'] && $value['nom'] 
                 && $value['mois'] && $value['annee'] 
                 && $value['cotisation_employee'] 
                && $value['salaire_base'] && $value['points']  ){

                $trim[] = [
                    'matricule' => $value['matricule'],
                    'nom' => $value['nom'],
                    'annee' => intVal($value['annee']),
                    'cotisation_employee' => intVal($value['cotisation_employee']),
                    'mois' => intVal($value['mois']),
                    'salaire_base' => intVal($value['salaire_base']),
                    'points' => intVal($value['points']),
                    'traitement' =>  $code_enregistrement,
                    'created_at' =>  now(),

                ];
            }
        }

        return $trim;

    }

// Methode pour la traduction Automatique de Google 
// body
// body_en
function articleTranslater($message){
        
        if(!empty($message)){
            $Error = 'Erreur de connexion';
            $tr = new GoogleTranslate();
            try {
                return $tr->setSource('fr')->setTarget('en')->translate($message);
            } catch(ConnectException $e){
                return $Error;
             }
        }else{
            return 'Please, add some text to translate';
        }
       
    }