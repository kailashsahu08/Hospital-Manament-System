<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TestReport;
use App\Models\User;

class TestReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any TestReport');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TestReport $testreport): bool
    {
        return $user->checkPermissionTo('view TestReport');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create TestReport');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TestReport $testreport): bool
    {
        return $user->checkPermissionTo('update TestReport');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TestReport $testreport): bool
    {
        return $user->checkPermissionTo('delete TestReport');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any TestReport');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TestReport $testreport): bool
    {
        return $user->checkPermissionTo('restore TestReport');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any TestReport');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, TestReport $testreport): bool
    {
        return $user->checkPermissionTo('replicate TestReport');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder TestReport');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TestReport $testreport): bool
    {
        return $user->checkPermissionTo('force-delete TestReport');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any TestReport');
    }
}
