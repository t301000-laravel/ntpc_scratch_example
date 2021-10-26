<?php

namespace App\Imports;

use App\Models\Team;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeamsImport implements ToModel, WithHeadingRow
{
    private $rows = 0;

    public function model(array $row)
    {
        $user_data = [
            'name' => $row['學校'],
            'email' => $row['帳號'] . '@local.test',
            'username' => $row['帳號'],
            'password' => bcrypt($row['密碼']),
        ];

        $user = User::create($user_data);

        $team_data = [
            'user_id' => $user->id,
            'school_name' => $row['學校'],
            'game_group' => $row['組別'],
        ];

        $this->rows++;

        return new Team($team_data);
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
