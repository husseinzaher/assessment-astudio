<?php

namespace Modules\EntityAttribute\Enums;

enum AttributeType: string
{
    case Text = 'text';
    case Date = 'date';
    case Number = 'number';
    case Select = 'select';
}
