<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
class UserController extends Controller {
	/*
	 * Display all the posts of a particular user
	 *
	 * @param int $id
	 * @return Response
	 */
	public function user_posts_all(Request $request, $id)
	{
		$user = User::find($id);
		$posts = Posts::where('user_id', $id)->orderBy('created_at','desc')->paginate(5);
		$title = $user->name;
		return view('home')->withPosts($posts)->withTitle($title);
	}
}
