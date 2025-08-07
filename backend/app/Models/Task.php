<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pendente';
    const STATUS_IN_PROGRESS = 'em_andamento';
    const STATUS_COMPLETED = 'concluida';

    const PRIORITY_LOW = 'baixa';
    const PRIORITY_MEDIUM = 'media';
    const PRIORITY_HIGH = 'alta';

    protected $fillable = [
        'title',
        'description', 
        'status',
        'priority',
        'due_date',
        'company_id',
        'user_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes para multitenancy
    public function scopeForCompany(Builder $query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Status e Priority helpers
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
        ];
    }

    public static function getPriorities()
    {
        return [
            self::PRIORITY_LOW,
            self::PRIORITY_MEDIUM,
            self::PRIORITY_HIGH,
        ];
    }
}