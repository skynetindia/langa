<?php

namespace App\Repositories;

use App\User;
use App\Accounting;

class AccountingRepository
{
	/**
	 * Admin e Amministrazione vedono tutto
	 * gli altri vedono le loro
	 */
    public function forUser(User $user)
    {				
		// if($user->id == 0 || $user->dipartimento == "AMMINISTRAZIONE") {
		// 	return Accounting::get();
		// } else {
		// 	return Accounting::where('user_id', $user->id)->get();
		// }

		if($user->id == 0 || $user->dipartimento == 1) {
			return Accounting::join('users', 'accountings.user_id','=',
					'users.id')
					->where('users.is_delete', '=', 0)
					->get();
			
		} else {

			return Accounting::join('users', 'accountings.user_id','=',
					'users.id')
					->where('user_id', $user->id)
					->where('users.is_delete', '=', 0)
					->get();
		}
    }
    
}