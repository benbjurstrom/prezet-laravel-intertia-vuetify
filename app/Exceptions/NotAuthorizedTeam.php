<?php

namespace App\Exceptions;

use Exception;

/**
 * Class NotAuthorizedTeam
 * @package App\Exceptions
 */
class NotAuthorizedTeam extends Exception
{
    /**
     * NotAuthorizedTeam constructor.
     * @param string $teamId
     * @param string $modelName
     * @param string $action
     */
    public function __construct($teamId, $modelName, $action)
    {
        $msg =
            $action .
            ' error on ' .
            $modelName .
            '. You do not have permission to modify records for team_id: ' .
            $teamId;

        parent::__construct($msg, 403, null);
    }
}
