<?php

namespace App\Composite;

interface CompositeVisitorInterface
{

    function visit(CompositeAbstract $composite);

}
