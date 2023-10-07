<?php

namespace App\Services;

use App\DataTransferObjects\PersonsDto;
use App\Models\person;


class PersonsService
{


  public function get()
  {
    return person::get();
  }


  public function store(PersonsDto $dto)
  {
    return person::create([
        'observacion' => $dto->observacion,
        'id_personal_registration' => $dto->id_personal_registration,
    ]);
  }

  public function update(person $persons, PersonsDto $dto)
  {
    return tap($persons)->update([
      'observacion' => $dto->observacion,
      'id_personal_registration' => $dto->id_personal_registration,

    ]);
  }


}
