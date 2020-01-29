<?php

namespace App\Models;

use Eloquent as EloquentIdeHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @apiDefine ProjectUserObject
 *
 * @apiSuccess {Integer}  project_users.id          ID
 * @apiSuccess {Integer}  project_users.project_id  Project ID
 * @apiSuccess {Integer}  project_users.user_id     User ID
 * @apiSuccess {Integer}  project_users.role_id     Role ID
 * @apiSuccess {ISO8601}  project_users.created_at  Creation DateTime
 * @apiSuccess {ISO8601}  project_users.updated_at  Update DateTime
 * @apiSuccess {ISO8601}  project_users.deleted_at  Delete DateTime or `NULL` if wasn't deleted
 *
 * @apiVersion 1.0.0
 */

/**
 * @apiDefine ProjectUserParams
 *
 * @apiParam {Integer}  [id]          ID
 * @apiParam {Integer}  [project_id]  Project ID
 * @apiParam {Integer}  [user_id]     User ID
 * @apiParam {Integer}  [role_id]     Role ID
 * @apiParam {ISO8601}  [created_at]  Creation DateTime
 * @apiParam {ISO8601}  [updated_at]  Update DateTime
 * @apiParam {ISO8601}  [deleted_at]  Delete DateTime
 * @apiParam {Object}   [user]        ProjectUser's relation user. All params in <a href="#api-User-GetUserList" >@User</a>
 * @apiParam {Object}   [project]     ProjectUser's relation project. All params in <a href="#api-Project-GetProjectList" >@Project</a>
 *
 * @apiVersion 1.0.0
 */

/**
 * Class ProjectsUsers
 *
 * @package App\Models
 * @property int     $project_id
 * @property int     $user_id
 * @property int     $role_id
 * @property string  $created_at
 * @property string  $updated_at
 * @property User    $user
 * @property Project $project
 * @property Role    $role
 * @method static EloquentBuilder|ProjectsUsers whereCreatedAt($value)
 * @method static EloquentBuilder|ProjectsUsers whereProjectId($value)
 * @method static EloquentBuilder|ProjectsUsers whereUpdatedAt($value)
 * @method static EloquentBuilder|ProjectsUsers whereUserId($value)
 * @mixin EloquentIdeHelper
 */
class ProjectsUsers extends AbstractModel
{
    /**
     * table name from database
     *
     * @var string
     */
    protected $table = 'projects_users';

    /**
     * @var array
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'role_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'project_id' => 'integer',
        'user_id' => 'integer',
        'role_id' => 'integer',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @param  EloquentBuilder  $query
     *
     * @return EloquentBuilder
     */
    protected function setKeysForSaveQuery(Builder $query): EloquentBuilder
    {
        return $query->where('project_id', '=', $this->getAttribute('project_id'))
            ->where('user_id', '=', $this->getAttribute('user_id'));
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
