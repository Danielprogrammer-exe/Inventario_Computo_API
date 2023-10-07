<?php

namespace App\DataTransferObjects;

use App\Http\Requests\personsRequest;


class PersonsDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $gender,
        public readonly string $id_type_person,
        public readonly string $state,
    )
    {
    }


    public static function fromApiRequest(personsRequest $request) : PersonsDto
    {
        return new self(
            name          : $request->validated('name'),
            surname       : $request->validated('surname'),
            email         : $request->validated('email'),
            phone         : $request->validated('phone'),
            gender        : $request->validated('gender'),
            id_type_person: $request->validated('id_type_person'),
            state         : $request->validated('state'),
        );

    }
}
