<?php

namespace App\Enum;

enum etatHabitat: string
{
    case TRES_BON_ETAT = 'Très bon état';
    case BON_ETAT = 'Bon état';
    case ETAT_MOYEN = 'Etat moyen';
    case MAUVAIS_ETAT = 'Mauvais état';
}
