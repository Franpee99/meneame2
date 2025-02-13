<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComentarioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comentario $comentario): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comentario $comentario): Response
    {
        return ($user->name === 'admin' || $user->id === $comentario->user_id)
        ? Response::allow()
        : Response::deny("No tienes permiso para eliminar este comentario.");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comentario $comentario): Response
    {
        return ($user->name === 'admin' || $user->id === $comentario->user_id)
        ? Response::allow()
        : Response::deny("No tienes permiso para eliminar este comentario.");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comentario $comentario): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comentario $comentario): bool
    {
        return false;
    }
}
