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

	private $naturalPageTitle;
	private $naturalPageDescription;
	private $naturalPageKeywords;
	private $controller;
	private $action;

	/**
	 * Create a new app composer.
	 * @return void
	 */
	public function __construct()
	{
		$this->initPageParams();
	}

	/**
	 * Bind data to the view.
	 *
	 * @param  View $view
	 * @return void
	 */
	public function compose(View $view)
	{
		$view->with([
			'naturalPageTitle'       => $this->naturalPageTitle,
			'naturalPageDescription' => $this->naturalPageDescription,
			'naturalPageKeywords'    => $this->naturalPageKeywords,
			'controller'             => $this->controller,
			'action'                 => $this->action,
			'naturalOgImage'         => url('images/default-og.jpg'),
			'user'                   => ($user = auth()->user()),
			'notifications'          => $user ? $user->unreadNotifications()->latest()->paginate(15) : [],
			'site'                => site_details(),
			'icons'                => icons(),
		]);
	}

	public function initPageParams()
	{
		$route_arr = request()->route() ? explode('.', request()->route()->getName()) : '';
		$key1 = isset($route_arr[1]) ? $route_arr[1] : '';
		$key0 = isset($route_arr[0]) ? $route_arr[0] : '';
		$this->controller = $key0;
		$this->action = $key1;
		$title = $this->action ? preg_replace('/[^a-z\d ]/i', " ", $this->action) : preg_replace('/[^a-z\d ]/i', " ",
			$this->controller);
        $this->naturalPageTitle = $title == 'home' ? 'Software Engineer in Nairobi, Kenya' : ucwords($title);
        $this->naturalPageKeywords = 'Rai Omido, raiomido, raiomido.com, Professional Web Developer, Payment gateway Integration, Professional Website Designer, Website Designer in Kenya, Mpesa Integration, eCommerce store Development, Web Designer, Software Developer in Kenya, Software Engineer in Kenya';
        $this->naturalPageDescription = 'For Enterprise software Development, Payment Gateway Integration, API Development, Web app Development, eCommerce stores call ' . config('sys.company.phone');
	}
}
