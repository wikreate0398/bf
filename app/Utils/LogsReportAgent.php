<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.12.2018
 * Time: 20:15
 */

namespace App\Utils;

use App\Models\LogsReport;

class LogsReportAgent
{
    private $action;

    private $userId;

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function save($data)
    {
        LogsReport::create([
            'id_user' => $this->userId,
            'action'  => $this->action,
            'data'    => json_encode($data)
        ]);
    }
}