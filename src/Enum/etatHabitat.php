<?php

namespace App\Enum;

enum etatHabitat: string
{
    case Tres_bon_etat = 'Très bon état';
    case bon_etat = 'Bon état';
    case etat_moyen = 'Etat moyen';
    case mauvais_etat = 'Mauvais état';
}
