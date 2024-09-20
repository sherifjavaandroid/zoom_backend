<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Meeting extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $appends = ['formatted_date', 'creator', 'banner'];
    protected $with = ['user'];

    public function scopeMine($query){
        return $query->where('user_id', '=', Auth::id());
    }

    public function scopeToday($query){
        return $query->whereDate('created_at', Carbon::now());
    }

    public function scopeWeek($query){
        $now = Carbon::now();
        return $query->whereDate('created_at',  ">=" , $now->startOfWeek()->format("Y-m-d H:i:s"))
        ->whereDate('created_at', "<=" , $now->endOfWeek()->format("Y-m-d H:i:s"));
    }

    public function scopePublic($query){
        return $query->where('public', 1);
    }

    public function getFormattedDateAttribute()
    {
        return !empty($this->created_at) ? $this->created_at->format('d M Y') : "";
    }

    public function getCreatorAttribute()
    {
        return $this->user->name ?? "Anonymous";
    }

    public function getBannerAttribute()
    {
        return $this->getFirstMediaUrl();
    }

    public function user()
    {
        return $this->hasOne('App\Models\User','id', 'user_id');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useFallbackUrl(''.url('').'/images/meeting.png')
            ->useFallbackPath(public_path('/images/meeting.png'));
    }

}

