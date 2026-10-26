<?php

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('it ensures strict types')
    ->expect('TLabsCo\TraitAndHelper')
    ->toUseStrictTypes();
