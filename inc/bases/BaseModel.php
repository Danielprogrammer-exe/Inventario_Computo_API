<?php

namespace Inc\bases;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const ID = 'id';
    const DATE_CREATED = 'date_created';
    const DATE_UPDATED = 'date_updated';
    const DATE_DELETED = 'date_deleted';
    const STATE = 'state'; # dejar en null para desactivar el auto estado

    /*
        const DATE_CREATED = null;
        const DATE_UPDATED = null;
        const DATE_DELETED = null;
    */

    const ORDER_BY = null;

    const _STATE_DELETED = '0'; # eliminado
    const _STATE_ENABLED = '1'; # habilitado
    const _STATE_DISABLED = '2'; # desactivado

    #Skoy colors
    const COLOR_ROJO = '#FF1300';
    const COLOR_AMARILLO = '#FFC300';
    const COLOR_VERDE = '#2ECC71';

    const COLOR_AZUL = '#0000FF';
    const COLOR_BLANCO = '#FFFFFF';
    const COLOR_DEFAULT = '#D9D9D9';

    #colors bootstrap
    const COLOR_PRIMARY = '#007BFF';
    const COLOR_SECONDARY = '#6C757D';
    const COLOR_SUCCESS = '#28A745';
    const COLOR_DANGER = '#DC3545';
    const COLOR_WARNING = '#FFC107';
    const COLOR_INFO = '#17A2B8';
    const COLOR_LIGHT = '#F8F9FA';
    const COLOR_DARK = '#343A40';

}
