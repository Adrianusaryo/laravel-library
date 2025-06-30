<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UsulBuku;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsulBukuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_usul::buku');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UsulBuku $usulBuku): bool
    {
        return $user->can('view_usul::buku');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_usul::buku');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UsulBuku $usulBuku): bool
    {
        return $user->can('update_usul::buku');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UsulBuku $usulBuku): bool
    {
        return $user->can('delete_usul::buku');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_usul::buku');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, UsulBuku $usulBuku): bool
    {
        return $user->can('force_delete_usul::buku');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_usul::buku');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, UsulBuku $usulBuku): bool
    {
        return $user->can('restore_usul::buku');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_usul::buku');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, UsulBuku $usulBuku): bool
    {
        return $user->can('replicate_usul::buku');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_usul::buku');
    }
}
