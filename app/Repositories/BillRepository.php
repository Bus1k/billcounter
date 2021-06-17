<?php
namespace App\Repositories;

use App\Models\Bill;
use App\Models\GroupsUsers;
use Illuminate\Support\Facades\Auth;

class BillRepository
{
    private Bill $billModel;

    public function __construct(Bill $billModel)
    {
        $this->billModel = $billModel;
    }

    public function all()
    {
        return $this->billModel->all();
    }

    public function allByMonth(int $month)
    {
        return Bill::join('groups_users', 'bills.group_id', '=', 'groups_users.group_id')
                    ->where('groups_users.user_id', Auth::id())
                    ->whereMonth('created_at', $month)
                    ->get();
    }

    public function get(int $id)
    {
        return $this->billModel->where('id', $id)->first();
    }

    public function create(string $description, int $categoryId, int $groupId, float $amount, ?string $fileName = null)
    {
        return $this->billModel->create([
            'user_id'     => Auth::id(),
            'description' => $description,
            'category_id' => $categoryId,
            'group_id'    => $groupId,
            'amount'      => $amount,
            'photo_name'  => $fileName,
        ]);
    }

    public function edit(Bill $bill, string $description, int $categoryId, float $amount,  ?string $fileName)
    {
        $bill->update([
            'description' => $description,
            'category_id' => $categoryId,
            'amount'      => $amount,
            'photo_name'  => $fileName,
        ]);
    }

    public function delete(Bill $bill)
    {
        $bill->delete();
    }


}
