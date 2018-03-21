<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\belongsTo;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $fillable = [
        'name', 'description',
        'start_date', 'end_date', 
        'start_time', 'end_time',
        'register_deadline',
        'participants_limit',
        'user_id',
        'is_public'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'start_date',
        'end_date',
        'register_deadline'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    protected $date_format = 'l, d F';
    protected $time_format = 'H:i';

    public function getSlugAttribute()
    {
        return str_slug($this->name);
    }

    public function getFullDateAttribute()
    {
        $string = $this->f_start_date . ' ' . $this->f_start_time . ' - ' . $this->f_end_time;
        return $this->start_date == $this->end_date ? $string : ($string . ' ' . $this->f_end_date);
    }

    public function getFStartDateAttribute()
    {
        return $this->start_date->format($this->date_format);
    }

    public function getFStartTimeAttribute()
    {
        $time = Carbon::createFromFormat('H:i:s', $this->start_time);
        return $time->format($this->time_format);
    }

    public function getFEndDateAttribute()
    {
        return $this->end_date->format($this->date_format);
    }

    public function getFEndTimeAttribute()
    {
        $time = Carbon::createFromFormat('H:i:s', $this->end_time);
        return $time->format($this->time_format);
    }

    public function getFRegisterDeadlineAttribute()
    {
        return $this->register_deadline->format($this->date_format);
    }

    public function getEndTimestampAttribute()
    {
        $time = Carbon::createFromFormat('H:i:s', $this->end_time);
        $ts = (($time->hour * 60) + $time->minute) * 60;
        return $this->end_date->timestamp + $ts;
    }

    public function place()
    {
    	return $this->hasOne('App\Place');
    }

    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function invitations()
    {
    	return $this->hasMany('App\Invitation');
    }
}
