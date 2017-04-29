<?php

namespace App\Repositories;

use App\User;
use App\Event;
use DB;

class EventRepository
{
    /**
     * Get all of the events for a given user at a given month.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user, $month, $year)
    {
       // if($user->id == 0)
       //     return DB::table('events')->where('meseFine', '>=', $month)
       //      ->where('annoFine', '>=', $year)
       //      ->orderBy('giorno', 'asc')
       //      ->get();
       //  return DB::table('events')->where('user_id', $user->id)
       //      ->where('meseFine', '>=', $month)
       //      ->where('annoFine', '>=', $year)
       //      ->orderBy('giorno', 'asc')
       //      ->get();


        if($user->id == 0)
            return DB::table('events')
                ->join('users', 'events.user_id','=','users.id')
                ->where('users.is_delete', '=', 0)
                ->where('meseFine', '>=', $month)
                ->where('annoFine', '>=', $year)
                ->orderBy('giorno', 'asc')
                ->get();
            

        return DB::table('events')
            ->join('users', 'events.user_id','=','users.id')
            ->where('users.is_delete', '=', 0)
            ->where('user_id', $user->id)
            ->where('meseFine', '>=', $month)
            ->where('annoFine', '>=', $year)
            ->orderBy('giorno', 'asc')
            ->get();

    }
	
	public function forUser2(User $user, $month, $year)
    {
       if($user->id == 0)
            return DB::table('events')
                ->join('users', 'events.user_id','=','users.id')
                ->where('users.is_delete', '=', 0)
                ->where('meseFine', '>=', $month)
                ->where('annoFine', '>=', $year)
                ->orderBy('giorno', 'asc')
                ->get();

        return DB::table('events')
            ->join('users', 'events.user_id','=','users.id')
            ->where('users.is_delete', '=', 0)
            ->where('meseFine', '>=', $month)
            ->where('annoFine', '>=', $year)
            ->orderBy('giorno', 'asc')
            ->get();
        
    }
	
	public function findEvent(User $user, $id)
	{
            if($user->id == 0)
           return Event::where([
			'id' => $id,
		])
			->get();
		return Event::where([
			'id' => $id,
		])
			->get();
	}
}