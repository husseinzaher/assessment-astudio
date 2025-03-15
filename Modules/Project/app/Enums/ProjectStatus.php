<?php

namespace Modules\Project\Enums;

enum ProjectStatus: string
{
    case Upcoming = 'upcoming';
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
