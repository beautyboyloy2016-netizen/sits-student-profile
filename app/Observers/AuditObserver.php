<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditObserver
{
    private function branchId(): ?int
    {
        if (isset($this->_branchId)) {
            return $this->_branchId;
        }
        $this->_branchId = current_branch_id() ?? (auth()->user()?->branch_id);
        return $this->_branchId;
    }

    public function created(Model $model): void
    {
        AuditLog::create([
            'branch_id'  => $this->branchId(),
            'user_id'    => auth()->id(),
            'action'     => 'created',
            'table_name' => $model->getTable(),
            'record_id'  => $model->getKey(),
            'old_values' => null,
            'new_values' => json_encode($model->getAttributes()),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function updated(Model $model): void
    {
        AuditLog::create([
            'branch_id'  => $this->branchId(),
            'user_id'    => auth()->id(),
            'action'     => 'updated',
            'table_name' => $model->getTable(),
            'record_id'  => $model->getKey(),
            'old_values' => json_encode($model->getOriginal()),
            'new_values' => json_encode($model->getChanges()),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function deleted(Model $model): void
    {
        AuditLog::create([
            'branch_id'  => $this->branchId(),
            'user_id'    => auth()->id(),
            'action'     => 'deleted',
            'table_name' => $model->getTable(),
            'record_id'  => $model->getKey(),
            'old_values' => json_encode($model->getAttributes()),
            'new_values' => null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function restored(Model $model): void
    {
        AuditLog::create([
            'branch_id'  => $this->branchId(),
            'user_id'    => auth()->id(),
            'action'     => 'restored',
            'table_name' => $model->getTable(),
            'record_id'  => $model->getKey(),
            'old_values' => null,
            'new_values' => json_encode($model->getAttributes()),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
