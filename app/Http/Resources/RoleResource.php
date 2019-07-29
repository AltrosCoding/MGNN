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
            'name' => $request->name,
            'createComment' => $request->create_comment,
            'createArticle' => $request->create_article,
            'createRole' => $request->create_role,
            'createUser' => $request->create_user,
            'editComment' => $request->edit_comment,
            'editArticle' => $request->edit_article,
            'editRole' => $request->edit_role,
            'editUser' => $request->edit_user,
            'deleteComment' => $request->delete_comment,
            'deleteArticle' => $request->delete_article,
            'deleteRole' => $request->delete_role,
            'deleteUser' => $request->delete_user,
            'inviteAuthor' => $request->invite_author,
            'revokeAuthor' => $request->revoke_author,
            'scheduleArticle' => $request->schedule_article,
            'runArticle' => $request->run_article,
            'viewPending' => $request->view_pending,
            'permalink' => $request->permalink,
        ];
    }
}
