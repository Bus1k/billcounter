<?php
namespace App\Repositories;

use App\Models\Group;
use App\Models\GroupsUsers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupRepository
{
    private Group $groupModel;
    private GroupsUsers $groupUsersModel;

    public function __construct(Group $groupModel, GroupsUsers $groupUsersModel)
    {
        $this->groupModel      = $groupModel;
        $this->groupUsersModel = $groupUsersModel;
    }

    public function create(string $name, string $description, string $color)
    {
        return $this->groupModel->create([
            'name'        => $name,
            'description' => $description,
            'token'       => $this->generateToken(),
            'color'       => $color
        ]);
    }

    public function delete(Group $group)
    {
        $group->delete();
    }

    public function assignUsers(int $groupId, array $userIds)
    {
        $data = [];
        foreach($userIds as $id) {
            $data[] = [
                'group_id' => $groupId,
                'user_id'  => $id
            ];
        }

        $this->groupUsersModel->insert($data);
    }

    //TODO to do poprawy fajnie by bylo ogarnac sql
    public function getGroupsByUserId(int $userId)
    {
        return User::find($userId)->groups;

//        $test = DB::select('SELECT g.id, g.name, g.description, g.token, g.color
//                                    FROM groups g
//                                    JOIN groups_users gu ON g.id = gu.group_id
//                                    WHERE gu.user_id = ?', [$userId]);
//
//        var_dump($test);
//        die;
    }

    private function generateToken($length = 16)
    {
        $token = Str::random($length);
        if($this->groupModel->where('token', $token)->first()) {
            return $this->generateToken();
        }

        return $token;
    }
}
