<?php

namespace App\Messenger\Traits;

use App\Messenger\Models\Message;
use App\Messenger\Models\Participant;
use App\Messenger\Models\Thread;

trait Messagable
{
    /**
     * Message relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function messages()
    {
        return $this->hasMany("App\Messenger\Models\Message");
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function participants()
    {
        return $this->hasMany("App\Messenger\Models\Participant");
    }

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     *
     * @codeCoverageIgnore
     */
    public function threads()
    {
        return $this->belongsToMany(
            "App\Messenger\Models\Thread",
            'participants',
            'user_id',
            'thread_id'
        );
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function newThreadsCount()
    {
        return $this->threadsWithNewMessages()->count();
    }

    /**
     * Returns all threads with new messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function threadsWithNewMessages()
    {
        return $this->threads()
            ->where(function ($q) {
                $q->whereNull("participants.last_read");
                $q->orWhere('threads' . '.updated_at', '>', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . 'participants' . '.last_read'));
            })->get();
    }
}
