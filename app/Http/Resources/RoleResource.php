<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'createComment' => $this->create_comment,
            'createArticle' => $this->create_article,
            'createRole' => $this->create_role,
            'createUser' => $this->create_user,
            'editComment' => $this->edit_comment,
            'editArticle' => $this->edit_article,
            'editRole' => $this->edit_role,
            'editUser' => $this->edit_user,
            'deleteComment' => $this->delete_comment,
            'deleteArticle' => $this->delete_article,
            'deleteRole' => $this->delete_role,
            'deleteUser' => $this->delete_user,
            'inviteAuthor' => $this->invite_author,
            'revokeAuthor' => $this->revoke_author,
            'scheduleArticle' => $this->schedule_article,
            'runArticle' => $this->run_article,
            'viewPending' => $this->view_pending,
            'permalink' => $this->permalink,
            'users' => $this->users,
        ];
    }
}
