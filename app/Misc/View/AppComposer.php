<?php
/**
 * Created by PhpStorm.
 * User: raiomido
 * Date: 3/7/19
 * Time: 1:01 PM
 */

namespace App\Misc\View;

use Illuminate\View\View;


class AppComposer
{

	/**
	 * Bind data to the view.
	 *
	 * @param  View $view
	 * @return void
	 */
	public function compose(View $view)
	{
		$view->with([
			'user'                   => auth()->user(),
			'icons'                => icons(),
		]);
	}
}
