<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Order Controller.
 *
 * Call an external API to process orders
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Order extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		return Response::forge(View::forge('order/index'));
	}

	/**
	 * Call the presenter to process XML from external API
	 * before to show in the view
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_parser()
	{
		return Response::forge(Presenter::forge('order/parser'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('order/404'), 404);
	}
}
